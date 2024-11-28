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
    $auth->requireAuth();
    $auth->requireAdmin();

    // Get category ID from query parameters
    $categoryId = isset($_GET['id']) ? intval($_GET['id']) : null;

    if ($categoryId === null || $categoryId <= 0) {
        Response::json(['error' => 'Invalid category ID'], 400);
    }

    $conn = $db->getConnection();

    // First check if there are any products using this category
    $checkQuery = "SELECT COUNT(*) FROM products WHERE category_id = :id";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bindParam(':id', $categoryId, PDO::PARAM_INT);
    $checkStmt->execute();

    $productCount = $checkStmt->fetchColumn();
    if ($productCount > 0) {
        Response::json([
            'success' => false,
            'error' => 'Cannot delete category',
            'message' => "This category already contains {$productCount} product(s). Please remove or reassign these products before deleting the category."
        ], 409);
    }

    // If no products found, proceed with deletion
    $query = "DELETE FROM categories WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $categoryId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            Response::json([
                'success' => true,
                'message' => 'Category deleted successfully',
                'categoryId' => $categoryId
            ]);
        } else {
            Response::json(['success' => false, 'error' => 'Category not found'], 404);
        }
    } else {
        Response::json(['success' => false, 'error' => 'Failed to delete category'], 500);
    }
} catch (Exception $e) {
    Response::json(['success' => false, 'error' => $e->getMessage()], 500);
}