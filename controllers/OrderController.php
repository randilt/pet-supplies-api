<?php

class OrderController
{
    private $orderModel;
    private $auth;

    public function __construct(OrderModel $orderModel, Auth $auth)
    {
        $this->orderModel = $orderModel;
        $this->auth = $auth;
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::json(['error' => 'Method not allowed'], 405);
        }

        try {
            $this->auth->requireAuth();

            $data = json_decode(file_get_contents('php://input'), true);

            // validate required fields
            $this->validateCreateData($data);

            $userId = $_SESSION['user_id'];
            $orderDetails = $this->orderModel->createOrder(
                $userId,
                $data['items'],
                $data['shipping_address']
            );

            Response::json([
                'message' => 'Order created successfully',
                'order' => $orderDetails
            ], 201);

        } catch (Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            Response::json(['error' => 'Method not allowed'], 405);
        }

        try {
            // $this->auth->requireAuth();
            $this->auth->requireAdmin();

            $status = $_GET['status'] ?? null;
            $sort = $_GET['sort'] ?? 'latest';

            $orders = $this->orderModel->getAllOrders($status, $sort);

            Response::json([
                'orders' => $orders,
                'total_count' => count($orders)
            ]);

        } catch (Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }

    public function getUserOrders()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            Response::json(['error' => 'Method not allowed'], 405);
        }

        try {
            $this->auth->requireAuth();

            $userId = $_SESSION['user_id'];
            $status = $_GET['status'] ?? null;

            $orders = $this->orderModel->getUserOrders($userId, $status);

            Response::json([
                'orders' => $orders,
                'total_count' => count($orders)
            ]);

        } catch (Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            Response::json(['error' => 'Method not allowed'], 405);
        }

        try {
            $this->auth->requireAdmin();

            $orderId = $_GET['id'] ?? null;
            if (!$orderId) {
                Response::json(['error' => 'Order ID is required'], 400);
            }

            $data = json_decode(file_get_contents('php://input'), true);
            $this->validateStatusUpdate($data);

            $updatedOrder = $this->orderModel->updateOrderStatus($orderId, $data['status']);

            Response::json([
                'message' => 'Order status updated successfully',
                'success' => true,
                'order' => $updatedOrder
            ]);

        } catch (Exception $e) {
            Response::json([
                'error' => $e->getMessage(),
                'success' => false
            ], 500);
        }
    }

    private function validateCreateData($data)
    {
        $errors = [];

        if (!isset($data['items']) || empty($data['items'])) {
            $errors[] = "Order must contain at least one item";
        }

        if (!isset($data['shipping_address']) || empty($data['shipping_address'])) {
            $errors[] = "Shipping address is required";
        }

        if (!empty($errors)) {
            Response::json(['errors' => $errors], 400);
            exit;
        }
    }

    private function validateStatusUpdate($data)
    {
        if (!isset($data['status'])) {
            Response::json(['error' => 'Status is required'], 400);
        }

        $validStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        if (!in_array($data['status'], $validStatuses)) {
            Response::json(['error' => 'Invalid status value'], 400);
        }
    }
}