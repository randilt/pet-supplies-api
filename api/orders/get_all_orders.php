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
    $auth = new Auth($db, true);
    $auth->requireAuth();

    $conn = $db->getConnection();

    // Get filter and sort parameters
    $status = $_GET['status'] ?? null;
    $sort = $_GET['sort'] ?? 'latest'; // default to latest

    // Prepare base query
    $query = "
        SELECT 
            id,
            user_id,
            total_amount,
            status,
            shipping_address,
            created_at
        FROM orders
    ";

    // Add status filter if provided
    if ($status) {
        $query .= " WHERE status = :status";
    }

    // Add sorting
    $query .= $sort === 'oldest'
        ? " ORDER BY created_at ASC"
        : " ORDER BY created_at DESC";

    // Prepare and execute statement
    $stmt = $conn->prepare($query);

    if ($status) {
        $stmt->bindParam(':status', $status);
    }

    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch items for each order
    $items_stmt = $conn->prepare("
        SELECT 
            oi.order_id,
            oi.product_id,
            oi.quantity,
            oi.price_at_time,
            p.name as product_name
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