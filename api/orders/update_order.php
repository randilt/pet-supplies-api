<?php
require_once '../../config/database.php';
require_once '../../utils/Response.php';
require_once '../../utils/Database.php';
require_once '../../utils/Auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    Response::json(['error' => 'Method not allowed'], 405);
}

try {
    $db = new Database();
    $auth = new Auth($db, true);
    $auth->requireAuth();

    // get order ID from URL parameter
    $order_id = $_GET['id'] ?? null;
    if (!$order_id) {
        Response::json(['error' => 'Order ID is required'], 400);
    }

    // get raw PUT data
    $data = json_decode(file_get_contents('php://input'), true);

    // validate status
    if (!isset($data['status'])) {
        Response::json(['error' => 'Status is required'], 400);
    }

    $valid_statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
    if (!in_array($data['status'], $valid_statuses)) {
        Response::json(['error' => 'Invalid status value'], 400);
    }

    $conn = $db->getConnection();

    // check if order exists
    $check_stmt = $conn->prepare("SELECT id, status FROM orders WHERE id = ?");
    $check_stmt->bindValue(1, $order_id, PDO::PARAM_INT);
    $check_stmt->execute();

    $order = $check_stmt->fetch(PDO::FETCH_ASSOC);
    if (!$order) {
        Response::json(['error' => 'Order not found'], 404);
    }

    // update order status
    $update_stmt = $conn->prepare("
        UPDATE orders 
        SET status = ?, 
            updated_at = NOW() 
        WHERE id = ?
    ");

    $update_stmt->bindValue(1, $data['status'], PDO::PARAM_STR);
    $update_stmt->bindValue(2, $order_id, PDO::PARAM_INT);
    $update_stmt->execute();

    // fetch updated order details
    $order_details_stmt = $conn->prepare("
        SELECT 
            o.id,
            o.user_id,
            o.total_amount,
            o.status,
            o.shipping_address,
            o.created_at,
            o.updated_at
        FROM orders o
        WHERE o.id = ?
    ");

    $order_details_stmt->bindValue(1, $order_id, PDO::PARAM_INT);
    $order_details_stmt->execute();
    $order_details = $order_details_stmt->fetch(PDO::FETCH_ASSOC);

    Response::json([
        'message' => 'Order status updated successfully',
        'success' => true,
        'order' => $order_details
    ]);

} catch (Exception $e) {
    Response::json([
        'error' => $e->getMessage(),
        'success' => false
    ], 500);
}