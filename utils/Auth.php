<?php
class Auth {
    private $db;
    private $sessionStarted = false;

    public function __construct(Database $db) {
        $this->db = $db;
        $this->startSession();
    }

    private function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            $this->sessionStarted = true;
        }
    }

    public function isAuthenticated() {
        return isset($_SESSION['user_id']) || isset($_SESSION['admin_id']);
    }

    public function isAdmin() {
        return isset($_SESSION['admin_id']);
    }

    public function requireAuth() {
        if (!$this->isAuthenticated()) {
            Response::json(['error' => 'Unauthorized access'], 401);
            exit;
        }
    }

    public function requireAdmin() {
        if (!$this->isAdmin()) {
            Response::json(['error' => 'Admin access required'], 403);
            exit;
        }
    }

    public function loginAdmin($email, $password) {
        $conn = $this->db->getConnection();
        
        $stmt = $conn->prepare("SELECT id, password FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$admin || !password_verify($password, $admin['password'])) {
            return false;
        }

        $_SESSION['admin_id'] = $admin['id'];
        return true;
    }

    public function loginUser($email, $password) {
        $conn = $this->db->getConnection();
        
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            return false;
        }

        $_SESSION['user_id'] = $user['id'];
        return true;
    }

    public function logout() {
        session_destroy();
        $this->sessionStarted = false;
    }
}