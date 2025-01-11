<?php
require_once '../../config/database.php';
require_once '../../utils/Response.php';
require_once '../../utils/Database.php';
require_once '../../utils/Auth.php';
require_once '../../models/UserModel.php';
require_once '../../controllers/UserController.php';

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
    $userModel = new UserModel($db);
    $userController = new UserController($userModel, $auth);

    $path = $_SERVER['PATH_INFO'] ?? '/';

    // echo $path;

    switch ($path) {
        case '/login':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userController->login();
            } else {
                Response::json(['error' => 'Method not allowed'], 405);
            }
            break;

        case '/register':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userController->register();
            } else {
                Response::json(['error' => 'Method not allowed'], 405);
            }
            break;

        case '/logout':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userController->logout();
            } else {
                Response::json(['error' => 'Method not allowed'], 405);
            }
            break;

        default:
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    $userController->get();
                    break;
                case 'PUT':
                    $userController->update();
                    break;
                default:
                    Response::json(['error' => 'Method not allowed'], 405);
            }
    }
} catch (Exception $e) {
    Response::json(['error' => $e->getMessage()], 500);
}