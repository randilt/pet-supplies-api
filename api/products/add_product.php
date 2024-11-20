<?php
require_once '../../config/database.php';
require_once '../../utils/Response.php';
require_once '../../utils/Database.php';
require_once '../../utils/Auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::json(['error' => 'Method not allowed'], 405);
}

try {
    $db = new Database();
    $auth = new Auth($db);

    // This is a protected route for admins
    $auth->requireAuth();
    $auth->requireAdmin();

    // Get JSON input
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Validate required fields
    $required_fields = ['category_id', 'name', 'description', 'price', 'stock_quantity', 'long_description'];
    $errors = [];

    foreach ($required_fields as $field) {
        if (!isset($data[$field]) || ($data[$field] === '' && $data[$field] !== 0)) {
            $errors[] = "Field '{$field}' is required";
        }
    }

    if (!empty($errors)) {
        Response::json(['errors' => $errors], 400);
        exit;
    }

    // Sanitize and validate input
    $category_id = (int) $data['category_id'];
    $name = trim($data['name']);
    $description = trim($data['description']);
    $long_description = trim($data['long_description']);
    $price = (float) $data['price'];
    $stock_quantity = (int) $data['stock_quantity'];
    $image_url = isset($data['image_url']) ? trim($data['image_url']) : null;

    // Validate and process variants
    $variants = isset($data['variants']) ? $data['variants'] : null;
    if ($variants !== null) {
        // Validate variants structure
        if (!is_array($variants)) {
            Response::json(['error' => 'Variants must be an array'], 400);
            exit;
        }

        // Normalize and validate each variant
        foreach ($variants as &$variant) {
            if (!isset($variant['type']) || !isset($variant['values'])) {
                Response::json(['error' => 'Each variant must have a type and values'], 400);
                exit;
            }

            if (!is_array($variant['values'])) {
                Response::json(['error' => 'Variant values must be an array'], 400);
                exit;
            }

            // Normalize variant structure
            $variant = [
                'type' => trim($variant['type']),
                'values' => array_map('trim', $variant['values']),
                'price_adjustments' => isset($variant['price_adjustments']) ?
                    array_map('floatval', $variant['price_adjustments']) :
                    array_fill(0, count($variant['values']), 0.0)
            ];
        }

        // Encode variants as JSON
        $variants_json = json_encode($variants, JSON_UNESCAPED_UNICODE);
        if ($variants_json === false) {
            Response::json(['error' => 'Invalid variants format'], 400);
            exit;
        }
    }

    // Additional validation
    if (strlen($name) < 2 || strlen($name) > 100) {
        Response::json(['error' => 'Name must be between 2 and 100 characters'], 400);
        exit;
    }

    if (strlen($description) < 10 || strlen($description) > 1000) {
        Response::json(['error' => 'Description must be between 10 and 1000 characters'], 400);
        exit;
    }

    if (strlen($long_description) < 50) {
        Response::json(['error' => 'Long description must be at least 50 characters'], 400);
        exit;
    }

    if ($price <= 0) {
        Response::json(['error' => 'Price must be greater than 0'], 400);
        exit;
    }

    if ($stock_quantity < 0) {
        Response::json(['error' => 'Stock quantity cannot be negative'], 400);
        exit;
    }

    $conn = $db->getConnection();

    // Check if category exists
    $stmt = $conn->prepare("SELECT id FROM categories WHERE id = ?");
    $stmt->bindValue(1, $category_id, PDO::PARAM_INT);
    $stmt->execute();

    if (!$stmt->fetch()) {
        Response::json(['error' => 'Category not found'], 404);
        exit;
    }

    // Check if product name already exists
    $stmt = $conn->prepare("SELECT id FROM products WHERE name = ?");
    $stmt->bindValue(1, $name, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->fetch()) {
        Response::json(['error' => 'A product with this name already exists'], 409);
        exit;
    }

    // Begin transaction
    $conn->beginTransaction();

    try {
        // Insert product
        $stmt = $conn->prepare("
            INSERT INTO products (
                category_id,
                name,
                description,
                long_description,
                price,
                stock_quantity,
                image_url,
                variants,
                created_at,
                updated_at
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW()
            )
        ");

        $stmt->bindValue(1, $category_id, PDO::PARAM_INT);
        $stmt->bindValue(2, $name, PDO::PARAM_STR);
        $stmt->bindValue(3, $description, PDO::PARAM_STR);
        $stmt->bindValue(4, $long_description, PDO::PARAM_STR);
        $stmt->bindValue(5, $price, PDO::PARAM_STR);
        $stmt->bindValue(6, $stock_quantity, PDO::PARAM_INT);
        $stmt->bindValue(7, $image_url, $image_url === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(8, $variants_json ?? null, $variants === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $stmt->execute();
        $product_id = $conn->lastInsertId();

        // Commit transaction
        $conn->commit();

        // Fetch the created product with category information
        $stmt = $conn->prepare("
            SELECT 
                p.*,
                c.name as category_name,
                c.description as category_description
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.id = ?
        ");

        $stmt->bindValue(1, $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        Response::json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);

    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollBack();
        throw $e;
    }

} catch (Exception $e) {
    Response::json(['error' => $e->getMessage()], 500);
}