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
    
    // This is a protected route
    $auth->requireAuth();
    
    // Get JSON input
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    // Validate required fields
    $required_fields = ['category_id', 'name', 'description', 'price', 'stock_quantity'];
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
    $category_id = (int)$data['category_id'];
    $name = trim($data['name']);
    $description = trim($data['description']);
    $price = (float)$data['price'];
    $stock_quantity = (int)$data['stock_quantity'];
    $image_url = isset($data['image_url']) ? trim($data['image_url']) : null;
    
    // Additional validation
    if (strlen($name) < 2 || strlen($name) > 100) {
        Response::json(['error' => 'Name must be between 2 and 100 characters'], 400);
        exit;
    }
    
    if (strlen($description) < 10 || strlen($description) > 1000) {
        Response::json(['error' => 'Description must be between 10 and 1000 characters'], 400);
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
                price,
                stock_quantity,
                image_url,
                created_at,
                updated_at
            ) VALUES (
                ?, ?, ?, ?, ?, ?, NOW(), NOW()
            )
        ");
        
        $stmt->bindValue(1, $category_id, PDO::PARAM_INT);
        $stmt->bindValue(2, $name, PDO::PARAM_STR);
        $stmt->bindValue(3, $description, PDO::PARAM_STR);
        $stmt->bindValue(4, $price, PDO::PARAM_STR);
        $stmt->bindValue(5, $stock_quantity, PDO::PARAM_INT);
        $stmt->bindValue(6, $image_url, $image_url === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        
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