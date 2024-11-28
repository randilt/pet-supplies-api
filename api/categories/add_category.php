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
    $auth->requireAuth();
    $auth->requireAdmin();

    // Get raw POST data
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate required fields
    if (!isset($data['name']) || empty($data['name'])) {
        Response::json(['error' => 'Category name is required'], 400);
    }

    $conn = $db->getConnection();

    // Prepare SQL to insert new category
    $query = "INSERT INTO categories (name, description) VALUES (:name, :description)";
    $stmt = $conn->prepare($query);

    // Bind parameters
    $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
    $description = $data['description'] ?? null;
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);

    // Execute and return result
    if ($stmt->execute()) {
        $newCategoryId = $conn->lastInsertId();
        Response::json([
            'message' => 'Category created successfully',
            'categoryId' => $newCategoryId
        ], 201);
    } else {
        Response::json(['error' => 'Failed to create category'], 500);
    }
} catch (Exception $e) {
    Response::json(['error' => $e->getMessage()], 500);
}