<?php
require_once '../../config/database.php';
require_once '../../utils/Response.php';
require_once '../../utils/Database.php';
require_once '../../utils/Auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    Response::json(['error' => 'Method not allowed'], 405);
    exit;
}

try {
    $db = new Database();
    $auth = new Auth($db, true);  // Set isApi to true for API authentication

    // Require user authentication
    $auth->requireAuth();

    $conn = $db->getConnection();

    // Fetch all orders first
    $orders_stmt = $conn->prepare("
        SELECT 
            id,
            user_id,
            total_amount,
            status,
            shipping_address,
            created_at
        FROM orders
        ORDER BY created_at DESC
    ");
    $orders_stmt->execute();
    $orders = $orders_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch items for each order
    $items_stmt = $conn->prepare("
        SELECT 
            oi.order_id,
            oi.product_id,
            oi.quantity,
            oi.price_at_time,
            p.name as product_name,
            p.image_url as product_image
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        WHERE oi.order_id = ?
    ");

    // Add items to each order
    foreach ($orders as &$order) {
        $items_stmt->execute([$order['id']]);
        $order['items'] = $items_stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    Response::json([
        'orders' => $orders,
        'total_count' => count($orders)
    ]);

} catch (Exception $e) {
    Response::json(['error' => $e->getMessage()], 500);
}