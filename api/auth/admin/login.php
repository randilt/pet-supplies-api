<?php
// File: api/admin/login.php

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
    $conn = $db->getConnection();
    
    // Add debugging query to check if admin exists
    $stmt = $conn->prepare("SELECT id, password FROM admins WHERE email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$admin) {
        Response::json(['error' => 'Admin account not found'], 401);
    }
    
    if (!password_verify($password, $admin['password'])) {
        Response::json(['error' => 'Invalid password'], 401);
    }
    
    session_start();
    $_SESSION['admin_id'] = $admin['id'];
    
    Response::json([
        'message' => 'Admin login successful',
        'admin_id' => $admin['id']
    ]);

} catch (Exception $e) {
    Response::json([
        'error' => 'Login failed',
        'message' => $e->getMessage()
    ], 500);
}