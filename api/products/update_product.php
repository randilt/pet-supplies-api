<?php

require_once '../../config/database.php';
require_once '../../utils/Response.php';
require_once '../../utils/Database.php';
require_once '../../utils/Auth.php';

header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, Origin");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 3600");


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    Response::json(['error' => 'Method not allowed'], 405);
}

try {
    $db = new Database();
    $auth = new Auth($db);

    // This is a protected route for admins
    $auth->requireAuth();
    $auth->requireAdmin();

    // Get product ID from URL parameter
    $product_id = isset($_GET['id']) ? (int) $_GET['id'] : null;

    if (!$product_id) {
        Response::json(['error' => 'Product ID is required'], 400);
        exit;
    }

    // Get JSON input
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (empty($data)) {
        Response::json(['error' => 'No data provided for update'], 400);
        exit;
    }

    $conn = $db->getConnection();

    // Check if product exists
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bindValue(1, $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $existing_product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existing_product) {
        Response::json(['error' => 'Product not found'], 404);
        exit;
    }

    // Validate and prepare update data
    $updates = [];
    $params = [];
    $types = [];

    if (isset($data['category_id'])) {
        $category_id = (int) $data['category_id'];
        // Check if category exists
        $stmt = $conn->prepare("SELECT id FROM categories WHERE id = ?");
        $stmt->bindValue(1, $category_id, PDO::PARAM_INT);
        $stmt->execute();

        if (!$stmt->fetch()) {
            Response::json(['error' => 'Category not found'], 404);
            exit;
        }

        $updates[] = "category_id = ?";
        $params[] = $category_id;
        $types[] = PDO::PARAM_INT;
    }

    if (isset($data['name'])) {
        $name = trim($data['name']);
        if (strlen($name) < 2 || strlen($name) > 100) {
            Response::json(['error' => 'Name must be between 2 and 100 characters'], 400);
            exit;
        }

        // Check if name already exists for another product
        $stmt = $conn->prepare("SELECT id FROM products WHERE name = ? AND id != ?");
        $stmt->bindValue(1, $name, PDO::PARAM_STR);
        $stmt->bindValue(2, $product_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->fetch()) {
            Response::json(['error' => 'A product with this name already exists'], 409);
            exit;
        }

        $updates[] = "name = ?";
        $params[] = $name;
        $types[] = PDO::PARAM_STR;
    }

    if (isset($data['description'])) {
        $description = trim($data['description']);
        if (strlen($description) < 10 || strlen($description) > 1000) {
            Response::json(['error' => 'Description must be between 10 and 1000 characters'], 400);
            exit;
        }
        $updates[] = "description = ?";
        $params[] = $description;
        $types[] = PDO::PARAM_STR;
    }

    // Add long_description field
    if (isset($data['long_description'])) {
        $long_description = trim($data['long_description']);
        if (strlen($long_description) < 50) {
            Response::json(['error' => 'Long description must be at least 50 characters'], 400);
            exit;
        }
        $updates[] = "long_description = ?";
        $params[] = $long_description;
        $types[] = PDO::PARAM_STR;
    }

    if (isset($data['price'])) {
        $price = (float) $data['price'];
        if ($price <= 0) {
            Response::json(['error' => 'Price must be greater than 0'], 400);
            exit;
        }
        $updates[] = "price = ?";
        $params[] = $price;
        $types[] = PDO::PARAM_STR;
    }

    if (isset($data['stock_quantity'])) {
        $stock_quantity = (int) $data['stock_quantity'];
        if ($stock_quantity < 0) {
            Response::json(['error' => 'Stock quantity cannot be negative'], 400);
            exit;
        }
        $updates[] = "stock_quantity = ?";
        $params[] = $stock_quantity;
        $types[] = PDO::PARAM_INT;
    }

    if (isset($data['image_url'])) {
        $image_url = trim($data['image_url']);
        $updates[] = "image_url = ?";
        $params[] = $image_url;
        $types[] = PDO::PARAM_STR;
    }

    // Add variants field
    if (isset($data['variants'])) {
        $variants = $data['variants'];

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

        $updates[] = "variants = ?";
        $params[] = $variants_json;
        $types[] = PDO::PARAM_STR;
    }

    if (empty($updates)) {
        Response::json(['error' => 'No valid fields to update'], 400);
        exit;
    }

    // Add updated_at to updates
    $updates[] = "updated_at = NOW()";

    // Begin transaction
    $conn->beginTransaction();

    try {
        // Update product
        $query = "UPDATE products SET " . implode(", ", $updates) . " WHERE id = ?";
        $stmt = $conn->prepare($query);

        // Bind all update parameters
        foreach ($params as $key => $value) {
            $stmt->bindValue($key + 1, $value, $types[$key]);
        }

        // Bind product_id as last parameter
        $stmt->bindValue(count($params) + 1, $product_id, PDO::PARAM_INT);

        $stmt->execute();

        // Commit transaction
        $conn->commit();

        // Fetch updated product with category information
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
        $updated_product = $stmt->fetch(PDO::FETCH_ASSOC);

        Response::json([
            'message' => 'Product updated successfully',
            'product' => $updated_product
        ]);

    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollBack();
        throw $e;
    }

} catch (Exception $e) {
    Response::json(['error' => $e->getMessage()], 500);
}