<?php
require_once '../../../config/database.php';
require_once '../../../utils/Response.php';
require_once '../../../utils/Database.php';

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
    $password = password_hash($data['password'], PASSWORD_DEFAULT);

    $db = new Database();
    $conn = $db->getConnection();

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        Response::json(['error' => 'Email already exists'], 400);
    }

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->execute([$email, $password]);

    Response::json(['message' => 'User registered successfully'], 201);
} catch (Exception $e) {
    Response::json(['error' => $e->getMessage()], 500);
}