<?php
// echo 'test';
require_once '../../../config/database.php';
require_once '../../../utils/Response.php';
require_once '../../../utils/Database.php';
require_once '../../../utils/Auth.php';
require_once '../../../models/OrderModel.php';
require_once '../../../controllers/OrderController.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, Origin");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 3600");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}

try {
    $db = new Database();
    $auth = new Auth($db, true);
    $orderModel = new OrderModel($db);
    $orderController = new OrderController($orderModel, $auth);

    // get the endpoint from the URL
    $endpoint = $_GET['endpoint'] ?? 'default';


    // echo ($_SERVER['REQUEST_METHOD']);
    switch ($_SERVER['REQUEST_METHOD']) {


        case 'GET':
            if ($endpoint === 'user') {
                $orderController->getUserOrders();
            } else {
                // echo 'works';
                $orderController->getAll();
            }
            break;
        case 'POST':
            $orderController->create();
            break;
        case 'PUT':
            $orderController->updateStatus();
            break;
        default:
            Response::json(['error' => 'Method not allowed'], 405);
    }
} catch (Exception $e) {
    Response::json(['error' => $e->getMessage()], 500);
}