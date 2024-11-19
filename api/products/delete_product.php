<?php
// File: api/products/delete_product.php
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
    
    // This is a protected route for admins
    $auth->requireAuth();
    $auth->requireAdmin();
    
    // Get product ID from URL parameter
    $product_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
    
    if (!$product_id) {
        Response::json(['error' => 'Product ID is required'], 400);
        exit;
    }
    
    $conn = $db->getConnection();
    
    // Begin transaction
    $conn->beginTransaction();
    
    try {
        // Check if product exists and get its details for the response
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
        
        if (!$product) {
            Response::json(['error' => 'Product not found'], 404);
            exit;
        }
        
        // // Check if product has any active offers
        // $stmt = $conn->prepare("
        //     SELECT id 
        //     FROM offers 
        //     WHERE product_id = ? 
        //     AND status = 'active'
        //     AND end_date > NOW()
        // ");
        // $stmt->bindValue(1, $product_id, PDO::PARAM_INT);
        // $stmt->execute();
        
        // if ($stmt->fetch()) {
        //     Response::json(['error' => 'Cannot delete product with active offers'], 409);
        //     exit;
        // }
        
        // Check if product is in any orders (assuming you have an order_items table)
        $stmt = $conn->prepare("
            SELECT id 
            FROM order_items 
            WHERE product_id = ? 
            LIMIT 1
        ");
        $stmt->bindValue(1, $product_id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->fetch()) {
            // If product is in orders, soft delete by marking as inactive
            $stmt = $conn->prepare("
                UPDATE products 
                SET status = 'inactive', updated_at = NOW() 
                WHERE id = ?
            ");
            $stmt->bindValue(1, $product_id, PDO::PARAM_INT);
            $stmt->execute();
            
            $conn->commit();
            
            Response::json([
                'message' => 'Product marked as inactive due to existing orders',
                'product' => $product
            ]);
        } else {
            // If product is not in any orders, perform hard delete
            $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
            $stmt->bindValue(1, $product_id, PDO::PARAM_INT);
            $stmt->execute();
            
            $conn->commit();
            
            Response::json([
                'message' => 'Product deleted successfully',
                'product' => $product
            ]);
        }
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollBack();
        throw $e;
    }
    
} catch (Exception $e) {
    Response::json(['error' => $e->getMessage()], 500);
}