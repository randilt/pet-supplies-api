<?php
require_once '../../config/database.php';
require_once '../../utils/Response.php';
require_once '../../utils/Database.php';


if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    Response::json(['error' => 'Method not allowed'], 405);
}

try {
    $db = new Database();

    $conn = $db->getConnection();

    $query = "SELECT id, name, description, created_at FROM categories";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    Response::json([
        'categories' => $categories
    ]);
} catch (Exception $e) {
    Response::json(['error' => $e->getMessage()], 500);
}