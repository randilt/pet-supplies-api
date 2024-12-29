<?php
require_once '../../../config/database.php';
require_once '../../../utils/Response.php';
require_once '../../../utils/Database.php';
require_once '../../../utils/Auth.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, Cookie");
header("Access-Control-Expose-Headers: Set-Cookie");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::json(['error' => 'Method not allowed'], 405);
}

try {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['email']) || !isset($data['password'])) {
        Response::json(['error' => 'Email and password are required'], 400);
    }

    $email = $data['email'];
    $password = $data['password'];

    $db = new Database();
    $auth = new Auth($db);

    if ($auth->loginUser($email, $password)) {
        Response::json(['message' => 'Login successful']);
    } else {
        Response::json(['error' => 'Invalid credentials'], 401);
    }
} catch (Exception $e) {
    Response::json(['error' => $e->getMessage()], 500);
}