<?php

class UserModel
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getUsers($id = null, $name = null)
    {
        $conn = $this->db->getConnection();

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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $data)
    {
        $conn = $this->db->getConnection();

        $updateFields = ['name', 'address', 'phone'];
        $updates = array_intersect_key($data, array_flip($updateFields));

        if (empty($updates)) {
            throw new Exception('No valid fields to update');
        }

        $updateParts = [];
        $params = [];
        foreach ($updates as $field => $value) {
            if ($value !== null && $value !== '') {
                $updateParts[] = "$field = ?";
                $params[] = $value;
            }
        }

        if (empty($updateParts)) {
            throw new Exception('No valid fields to update');
        }

        $params[] = $id;
        $sql = "UPDATE users SET " . implode(', ', $updateParts) . " WHERE id = ?";
        $stmt = $conn->prepare($sql);

        foreach ($params as $index => $value) {
            $stmt->bindValue($index + 1, $value, PDO::PARAM_STR);
        }

        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            throw new Exception('User not found or no changes made');
        }

        return $this->getUsers($id)[0] ?? null;
    }

    public function registerUser($email, $password, $name)
    {
        $conn = $this->db->getConnection();

        // check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            throw new Exception('Email already exists');
        }

        // insert new user
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (email, password, name) VALUES (?, ?, ?)");
        $stmt->execute([$email, $hashedPassword, $name]);

        return $conn->lastInsertId();
    }

    public function validateCredentials($email, $password)
    {
        $conn = $this->db->getConnection();

        $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            return false;
        }

        return $user['id'];
    }
}