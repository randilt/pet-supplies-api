<?php
require_once '../../config/database.php';
require_once '../../utils/Response.php';
require_once '../../utils/Database.php';
require_once '../../utils/Auth.php';
require_once '../../models/SubscriptionModel.php';
require_once '../../controllers/SubscriptionController.php';

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
    $subscriptionModel = new SubscriptionModel($db);
    $subscriptionController = new SubscriptionController($subscriptionModel, $auth);

    $endpoint = $_GET['endpoint'] ?? 'default';

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            switch ($endpoint) {
                case 'plans':
                    $subscriptionController->getAllPlans();
                    break;
                case 'active':
                    $subscriptionController->getActiveSubscription();
                    break;
                default:
                    $subscriptionController->getUserSubscriptions();
            }
            break;
        case 'POST':
            $subscriptionController->subscribe();
            break;
        case 'PUT':
            $subscriptionController->cancel();
            break;
        default:
            Response::json(['error' => 'Method not allowed'], 405);
    }
} catch (Exception $e) {
    Response::json(['error' => $e->getMessage()], 500);
}