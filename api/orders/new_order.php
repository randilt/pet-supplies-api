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
    $auth = new Auth($db, true);  // Set isApi to true for API authentication

    // Require user authentication
    $auth->requireAuth();

    // Get raw POST data
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate required fields
    $required_fields = ['items', 'shipping_address'];
    $errors = [];

    foreach ($required_fields as $field) {
        if (!isset($data[$field]) || empty($data[$field])) {
            $errors[] = "Field '{$field}' is required";
        }
    }

    // Validate items
    if (!is_array($data['items']) || empty($data['items'])) {
        $errors[] = "Order must contain at least one item";
    }

    if (!empty($errors)) {
        Response::json(['errors' => $errors], 400);
        exit;
    }

    $conn = $db->getConnection();

    // Begin transaction
    $conn->beginTransaction();

    try {
        // Get current user ID directly from session
        $user_id = $_SESSION['user_id'];

        // Calculate total amount and validate items
        $total_amount = 0;
        $order_items = [];

        foreach ($data['items'] as $item) {
            // Validate item structure
            if (!isset($item['product_id']) || !isset($item['quantity'])) {
                $errors[] = "Each item must have a product_id and quantity";
                continue;
            }

            // Fetch product details to get current price
            $stmt = $conn->prepare("SELECT price, stock_quantity FROM products WHERE id = ?");
            $stmt->bindValue(1, $item['product_id'], PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$product) {
                $errors[] = "Product ID {$item['product_id']} not found";
                continue;
            }

            // Check stock availability
            if ($product['stock_quantity'] < $item['quantity']) {
                $errors[] = "Insufficient stock for product ID {$item['product_id']}";
                continue;
            }

            // Calculate item total and add to order total
            $item_total = $product['price'] * $item['quantity'];
            $total_amount += $item_total;

            // Prepare order item
            $order_items[] = [
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price_at_time' => $product['price']
            ];

            // Update product stock
            $update_stmt = $conn->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?");
            $update_stmt->bindValue(1, $item['quantity'], PDO::PARAM_INT);
            $update_stmt->bindValue(2, $item['product_id'], PDO::PARAM_INT);
            $update_stmt->execute();
        }

        // Check for validation errors
        if (!empty($errors)) {
            Response::json(['errors' => $errors], 400);
            exit;
        }

        // Insert order
        $order_stmt = $conn->prepare("
            INSERT INTO orders (
                user_id, 
                total_amount, 
                status, 
                shipping_address, 
                created_at
            ) VALUES (
                ?, ?, 'pending', ?, NOW()
            )
        ");

        $order_stmt->bindValue(1, $user_id, PDO::PARAM_INT);
        $order_stmt->bindValue(2, $total_amount, PDO::PARAM_STR);
        $order_stmt->bindValue(3, $data['shipping_address'], PDO::PARAM_STR);
        $order_stmt->execute();

        $order_id = $conn->lastInsertId();

        // Insert order items
        $item_stmt = $conn->prepare("
            INSERT INTO order_items (
                order_id, 
                product_id, 
                quantity, 
                price_at_time, 
                created_at
            ) VALUES (
                ?, ?, ?, ?, NOW()
            )
        ");

        foreach ($order_items as $item) {
            $item_stmt->bindValue(1, $order_id, PDO::PARAM_INT);
            $item_stmt->bindValue(2, $item['product_id'], PDO::PARAM_INT);
            $item_stmt->bindValue(3, $item['quantity'], PDO::PARAM_INT);
            $item_stmt->bindValue(4, $item['price_at_time'], PDO::PARAM_STR);
            $item_stmt->execute();
        }

        // Commit transaction
        $conn->commit();

        // Fetch and return the complete order details
        $order_details_stmt = $conn->prepare("
            SELECT 
                o.id,
                o.user_id,
                o.total_amount,
                o.status,
                o.shipping_address,
                o.created_at,
                oi.product_id,
                oi.quantity,
                oi.price_at_time,
                p.name as product_name
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.id
            WHERE o.id = ?
        ");

        $order_details_stmt->bindValue(1, $order_id, PDO::PARAM_INT);
        $order_details_stmt->execute();
        $order_details = $order_details_stmt->fetchAll(PDO::FETCH_ASSOC);

        Response::json([
            'message' => 'Order created successfully',
            'order' => [
                'id' => $order_id,
                'user_id' => $user_id,
                'total_amount' => $total_amount,
                'status' => 'pending',
                'shipping_address' => $data['shipping_address'],
                'items' => $order_details
            ]
        ], 201);

    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollBack();
        throw $e;
    }

} catch (Exception $e) {
    Response::json(['error' => $e->getMessage()], 500);
}