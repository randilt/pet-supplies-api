<?php
class Auth
{
    private $db;
    private $sessionStarted = false;
    private $isApi = false;

    public function __construct(Database $db, $isApi = false)
    {
        $this->db = $db;
        $this->isApi = $isApi;
        $this->startSession();
    }

    private function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            $this->sessionStarted = true;
        }
    }

    public function isAuthenticated()
    {
        return isset($_SESSION['user_id']) || isset($_SESSION['admin_id']);
    }

    public function isAdmin()
    {
        return isset($_SESSION['admin_id']);
    }

    public function requireAuth($redirectUrl = './login')
    {
        if (!$this->isAuthenticated()) {
            if ($this->isApi) {
                Response::json(['error' => 'Unauthorized access'], 401);
                exit;
            } else {
                header("Location: $redirectUrl");
                exit;
            }
        }
    }

    public function requireAdmin($redirectUrl = './login')
    {
        if (!$this->isAdmin()) {
            if ($this->isApi) {
                Response::json(['error' => 'Admin access required'], 403);
                exit;
            } else {
                header("Location: $redirectUrl");
                exit;
            }
        }
    }

    public function requireGuest($redirectUrl = './profile')
    {
        if ($this->isAuthenticated()) {
            header("Location: $redirectUrl");
            exit;
        }
    }

    public function requireAdminGuest($redirectUrl = './dashboard')
    {
        if ($this->isAdmin()) {
            header("Location: $redirectUrl");
            exit;
        }
    }

    public function loginAdmin($email, $password)
    {
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

    public function loginUser($email, $password)
    {
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


    public function logout($redirectUrl = './')
    {
        session_destroy();
        $this->sessionStarted = false;

        if (!$this->isApi) {
            header("Location: $redirectUrl");
            exit;
        }
    }
}