<?php
require_once '../../../config/database.php';
require_once '../../../utils/Response.php';
require_once '../../../utils/Database.php';
require_once '../../../utils/Auth.php';
require_once '../../../models/ProductModel.php';
require_once '../../../controllers/ProductController.php';

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
    $productModel = new ProductModel($db);
    $productController = new ProductController($productModel, $auth);

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $productController->get();
            break;
        case 'POST':
            $productController->create();
            break;
        case 'PUT':
            $productController->update();
            break;
        case 'DELETE':
            $productController->delete();
            break;
        default:
            Response::json(['error' => 'Method not allowed'], 405);
    }
} catch (Exception $e) {
    Response::json(['error' => $e->getMessage()], 500);
}