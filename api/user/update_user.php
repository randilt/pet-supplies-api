<?php
require_once '../../config/database.php';
require_once '../../utils/Response.php';
require_once '../../utils/Database.php';
require_once '../../utils/Auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    try {
        $db = new Database();
        $auth = new Auth($db, true);
        $auth->requireAuth();

        $user_id = $_GET['id'] ?? null;
        if (!$user_id) {
            Response::json(['error' => 'User ID is required'], 400);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            Response::json(['error' => 'Invalid JSON data'], 400);
            exit;
        }

        $updateFields = ['name', 'address', 'phone'];
        $updates = array_intersect_key($data, array_flip($updateFields));

        if (empty($updates)) {
            Response::json(['error' => 'No valid fields to update'], 400);
            exit;
        }

        $conn = $db->getConnection();

        $updateParts = [];
        $params = [];
        foreach ($updates as $field => $value) {
            if ($value !== null && $value !== '') {
                $updateParts[] = "$field = ?";
                $params[] = $value;
            }
        }

        if (empty($updateParts)) {
            Response::json(['error' => 'No valid fields to update'], 400);
            exit;
        }

        $params[] = $user_id;
        $sql = "UPDATE users SET " . implode(', ', $updateParts) . " WHERE id = ?";
        $stmt = $conn->prepare($sql);

        foreach ($params as $index => $value) {
            $stmt->bindValue($index + 1, $value, PDO::PARAM_STR);
        }

        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            Response::json(['error' => 'User not found or no changes made'], 404);
            exit;
        }

        $stmt = $conn->prepare("SELECT id, name, email, address, phone, created_at FROM users WHERE id = ?");
        $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        Response::json([
            'message' => 'User updated successfully',
            'user' => $user
        ]);

    } catch (Exception $e) {
        Response::json(['error' => $e->getMessage()], 500);
        exit;
    }
}