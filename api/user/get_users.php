<?php
require_once '../../config/database.php';
require_once '../../utils/Response.php';
require_once '../../utils/Database.php';
require_once '../../utils/Auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $db = new Database();
        $auth = new Auth($db, true);
        $auth->requireAuth();

        $conn = $db->getConnection();

        $id = $_GET['id'] ?? null;
        $name = $_GET['name'] ?? null;

        if ($id) {
            $stmt = $conn->prepare("SELECT id, name, email, address, phone, created_at FROM users WHERE id = ?");
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
        } elseif ($name) {
            $stmt = $conn->prepare("SELECT id, name, email, address, phone, created_at FROM users WHERE name LIKE ?");
            $stmt->bindValue(1, "%$name%", PDO::PARAM_STR);
        } else {
            $stmt = $conn->prepare("SELECT id, name, email, address, phone, created_at FROM users");
        }

        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        Response::json($users);

    } catch (Exception $e) {
        Response::json(['error' => $e->getMessage()], 500);
    }
}