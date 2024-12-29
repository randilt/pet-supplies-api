<?php
require_once '../../config/database.php';
require_once '../../utils/Response.php';
require_once '../../utils/Database.php';
require_once '../../utils/Auth.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Authorization, Cookie");


if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    Response::json(['error' => 'Method not allowed'], 405);
}

try {
    $db = new Database();
    $auth = new Auth($db);

    // This is a protected route
    // $auth->requireAuth();

    $conn = $db->getConnection();

    // Check if a specific product ID is requested
    $product_id = isset($_GET['id']) ? (int) $_GET['id'] : null;

    // If a specific product ID is requested, fetch only that product
    if ($product_id) {
        $query = "
            SELECT 
                p.id,
                p.category_id,
                p.name,
                p.description,
                p.long_description,
                p.price,
                p.stock_quantity,
                p.image_url,
                p.variants,
                p.created_at,
                p.updated_at,
                c.name as category_name,
                c.description as category_description
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.id = ?
        ";

        $stmt = $conn->prepare($query);
        $stmt->bindValue(1, $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            Response::json(['error' => 'Product not found'], 404);
        }

        Response::json([
            'product' => $product
        ]);
        exit;
    }

    // Get query parameters with defaults
    $category_id = isset($_GET['category_id']) ? (int) $_GET['category_id'] : null;
    $search = isset($_GET['search']) ? trim($_GET['search']) : null;
    $min_price = isset($_GET['min_price']) ? (float) $_GET['min_price'] : null;
    $max_price = isset($_GET['max_price']) ? (float) $_GET['max_price'] : null;
    $in_stock = isset($_GET['in_stock']) ? (bool) $_GET['in_stock'] : null;
    $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'created_at';
    $sort_order = isset($_GET['sort_order']) && strtoupper($_GET['sort_order']) === 'ASC' ? 'ASC' : 'DESC';
    $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
    $limit = isset($_GET['limit']) ? min(50, max(1, (int) $_GET['limit'])) : 10;
    $offset = ($page - 1) * $limit;

    // Validate sort_by parameter
    $allowed_sort_fields = ['name', 'price', 'created_at', 'stock_quantity'];
    if (!in_array($sort_by, $allowed_sort_fields)) {
        $sort_by = 'created_at';
    }

    // Base query
    $query = "
        SELECT 
            p.id,
            p.category_id,
            p.name,
            p.description,
            p.long_description,
            p.price,
            p.stock_quantity,
            p.image_url,
            p.variants,
            p.created_at,
            p.updated_at,
            c.name as category_name,
            c.description as category_description
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE 1=1
    ";

    // Parameters for prepared statement
    $params = [];
    $types = [];

    // Add filters
    if ($category_id) {
        $query .= " AND p.category_id = ?";
        $params[] = $category_id;
        $types[] = PDO::PARAM_INT;
    }

    if ($search) {
        $query .= " AND (p.name LIKE ? OR p.description LIKE ?)";
        $searchTerm = "%{$search}%";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $types[] = PDO::PARAM_STR;
        $types[] = PDO::PARAM_STR;
    }

    if ($min_price !== null) {
        $query .= " AND p.price >= ?";
        $params[] = $min_price;
        $types[] = PDO::PARAM_STR;
    }

    if ($max_price !== null) {
        $query .= " AND p.price <= ?";
        $params[] = $max_price;
        $types[] = PDO::PARAM_STR;
    }

    if ($in_stock !== null) {
        $query .= " AND p.stock_quantity > 0";
    }

    // Add sorting
    $query .= " ORDER BY p.{$sort_by} {$sort_order}";

    // Add pagination
    $query .= " LIMIT ? OFFSET ?";
    $params[] = (int) $limit;
    $params[] = (int) $offset;
    $types[] = PDO::PARAM_INT;
    $types[] = PDO::PARAM_INT;

    // Execute main query
    $stmt = $conn->prepare($query);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key + 1, $value, $types[$key] ?? PDO::PARAM_STR);
    }
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get total count for pagination (without limit/offset)
    $countQuery = "
        SELECT COUNT(*) as total 
        FROM products p
        WHERE 1=1
    ";

    // Add the same filters to count query
    $countParams = [];
    $countTypes = [];
    if ($category_id) {
        $countQuery .= " AND p.category_id = ?";
        $countParams[] = $category_id;
        $countTypes[] = PDO::PARAM_INT;
    }

    if ($search) {
        $countQuery .= " AND (p.name LIKE ? OR p.description LIKE ?)";
        $countParams[] = $searchTerm;
        $countParams[] = $searchTerm;
        $countTypes[] = PDO::PARAM_STR;
        $countTypes[] = PDO::PARAM_STR;
    }

    if ($min_price !== null) {
        $countQuery .= " AND p.price >= ?";
        $countParams[] = $min_price;
        $countTypes[] = PDO::PARAM_STR;
    }

    if ($max_price !== null) {
        $countQuery .= " AND p.price <= ?";
        $countParams[] = $max_price;
        $countTypes[] = PDO::PARAM_STR;
    }

    if ($in_stock !== null) {
        $countQuery .= " AND p.stock_quantity > 0";
    }

    // Execute count query
    $stmt = $conn->prepare($countQuery);
    foreach ($countParams as $key => $value) {
        $stmt->bindValue($key + 1, $value, $countTypes[$key] ?? PDO::PARAM_STR);
    }
    $stmt->execute();
    $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Get summary statistics
    $statsQuery = "
        SELECT 
            COUNT(*) as total_products,
            COUNT(DISTINCT category_id) as total_categories,
            MIN(price) as min_price,
            MAX(price) as max_price,
            AVG(price) as avg_price,
            SUM(CASE WHEN stock_quantity > 0 THEN 1 ELSE 0 END) as in_stock_count
        FROM products
    ";
    $stmt = $conn->prepare($statsQuery);
    $stmt->execute();
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);

    Response::json([
        'products' => $products,
        'pagination' => [
            'total' => (int) $total,
            'page' => $page,
            'limit' => $limit,
            'total_pages' => ceil($total / $limit)
        ],
        'filters' => [
            'category_id' => $category_id,
            'search' => $search,
            'min_price' => $min_price,
            'max_price' => $max_price,
            'in_stock' => $in_stock
        ],
        'sorting' => [
            'sort_by' => $sort_by,
            'sort_order' => $sort_order
        ],
        'stats' => $stats
    ]);
} catch (Exception $e) {
    Response::json(['error' => $e->getMessage()], 500);
}