<?php
require_once '../../config/database.php';
require_once '../../utils/Response.php';
require_once '../../utils/Database.php';
require_once '../../utils/Auth.php';

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