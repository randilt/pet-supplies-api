<?php

class OrderModel
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function createOrder($userId, $items, $shippingAddress)
    {
        $conn = $this->db->getConnection();
        $conn->beginTransaction();

        try {
            $totalAmount = 0;
            $orderItems = [];

            // validate and process items
            foreach ($items as $item) {
                $product = $this->validateOrderItem($conn, $item);
                if (isset($product['error'])) {
                    throw new Exception($product['error']);
                }

                $itemTotal = $product['price'] * $item['quantity'];
                $totalAmount += $itemTotal;
                $orderItems[] = [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price_at_time' => $product['price']
                ];

                // update product stock
                $this->updateProductStock($conn, $item['product_id'], $item['quantity']);
            }

            // create order
            $orderId = $this->insertOrder($conn, $userId, $totalAmount, $shippingAddress);

            // insert order items
            $this->insertOrderItems($conn, $orderId, $orderItems);

            // get complete order details
            $orderDetails = $this->getOrderWithItems($conn, $orderId);

            $conn->commit();
            return $orderDetails;

        } catch (Exception $e) {
            $conn->rollBack();
            throw $e;
        }
    }

    public function getAllOrders($status = null, $sort = 'latest')
    {
        $conn = $this->db->getConnection();

        $query = "SELECT id, user_id, total_amount, status, shipping_address, created_at, updated_at 
                 FROM orders";

        if ($status) {
            $query .= " WHERE status = :status";
        }

        $query .= $sort === 'oldest' ? " ORDER BY created_at ASC" : " ORDER BY created_at DESC";

        $stmt = $conn->prepare($query);
        if ($status) {
            $stmt->bindParam(':status', $status);
        }

        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->attachItemsToOrders($orders);
    }

    public function getUserOrders($userId, $status = null)
    {
        $conn = $this->db->getConnection();

        $query = "SELECT id, total_amount, status, shipping_address, created_at, updated_at 
                 FROM orders WHERE user_id = ?";

        if ($status) {
            $query .= " AND status = ?";
        }

        $query .= " ORDER BY created_at DESC";

        $stmt = $conn->prepare($query);
        $params = [$userId];
        if ($status) {
            $params[] = $status;
        }

        $stmt->execute($params);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->attachItemsToOrders($orders);
    }

    public function updateOrderStatus($orderId, $status)
    {
        $conn = $this->db->getConnection();

        $order = $this->getOrder($orderId);
        if (!$order) {
            throw new Exception("Order not found");
        }

        $stmt = $conn->prepare("UPDATE orders SET status = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$status, $orderId]);

        return $this->getOrder($orderId);
    }

    private function validateOrderItem($conn, $item)
    {
        if (!isset($item['product_id']) || !isset($item['quantity'])) {
            return ['error' => "Invalid item structure"];
        }

        $stmt = $conn->prepare("SELECT price, stock_quantity FROM products WHERE id = ?");
        $stmt->execute([$item['product_id']]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            return ['error' => "Product ID {$item['product_id']} not found"];
        }

        if ($product['stock_quantity'] < $item['quantity']) {
            return ['error' => "Insufficient stock for product ID {$item['product_id']}"];
        }

        return $product;
    }

    private function updateProductStock($conn, $productId, $quantity)
    {
        $stmt = $conn->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?");
        $stmt->execute([$quantity, $productId]);
    }

    private function insertOrder($conn, $userId, $totalAmount, $shippingAddress)
    {
        $stmt = $conn->prepare("
            INSERT INTO orders (user_id, total_amount, status, shipping_address, created_at)
            VALUES (?, ?, 'pending', ?, NOW())
        ");
        $stmt->execute([$userId, $totalAmount, $shippingAddress]);
        return $conn->lastInsertId();
    }

    private function insertOrderItems($conn, $orderId, $items)
    {
        $stmt = $conn->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, price_at_time, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");

        foreach ($items as $item) {
            $stmt->execute([
                $orderId,
                $item['product_id'],
                $item['quantity'],
                $item['price_at_time']
            ]);
        }
    }

    private function getOrderWithItems($conn, $orderId)
    {
        $stmt = $conn->prepare("
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
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function attachItemsToOrders($orders)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("
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

        foreach ($orders as &$order) {
            $stmt->execute([$order['id']]);
            $order['items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $orders;
    }

    private function getOrder($orderId)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("
            SELECT id, user_id, total_amount, status, shipping_address, created_at, updated_at
            FROM orders WHERE id = ?
        ");
        $stmt->execute([$orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
