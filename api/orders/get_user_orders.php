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

    // Get current user ID directly from session
    $user_id = $_SESSION['user_id'];

    $conn = $db->getConnection();

    // Optional status filter
    $status_filter = isset($_GET['status']) ? $_GET['status'] : null;

    // Fetch orders first
    $query = "
        SELECT 
            id,
            total_amount,
            status,
            shipping_address,
            created_at,
            updated_at
        FROM orders
        WHERE user_id = ?
    ";

    // Add status filter if provided
    if ($status_filter) {
        $query .= " AND status = ?";
    }

    $query .= " ORDER BY created_at DESC";

    // Prepare and execute statement for orders
    $stmt = $conn->prepare($query);

    // Bind parameters
    $param_index = 1;
    $stmt->bindValue($param_index++, $user_id, PDO::PARAM_INT);

    if ($status_filter) {
        $stmt->bindValue($param_index, $status_filter, PDO::PARAM_STR);
    }

    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare statement to fetch items for each order
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

    // Attach items to each order
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