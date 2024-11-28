<?php
require_once '../../config/database.php';
require_once '../../utils/Response.php';
require_once '../../utils/Database.php';
require_once '../../utils/Auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    Response::json(['error' => 'Method not allowed'], 405);
}

try {
    $db = new Database();
    $auth = new Auth($db);

    // Get category ID from query parameters
    $categoryId = isset($_GET['id']) ? intval($_GET['id']) : null;

    if ($categoryId === null || $categoryId <= 0) {
        Response::json(['error' => 'Invalid category ID'], 400);
    }

    $conn = $db->getConnection();

    // Prepare SQL to delete category
    $query = "DELETE FROM categories WHERE id = :id";
    $stmt = $conn->prepare($query);

    // Bind parameters
    $stmt->bindParam(':id', $categoryId, PDO::PARAM_INT);

    // Execute and return result
    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            Response::json([
                'message' => 'Category deleted successfully',
                'categoryId' => $categoryId
            ]);
        } else {
            Response::json(['error' => 'Category not found'], 404);
        }
    } else {
        Response::json(['error' => 'Failed to delete category'], 500);
    }
} catch (Exception $e) {
    Response::json(['error' => $e->getMessage()], 500);
}