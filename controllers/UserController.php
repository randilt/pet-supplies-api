<?php

class UserController
{
    private $userModel;
    private $auth;

    public function __construct(UserModel $userModel, Auth $auth)
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->userModel = $userModel;
        $this->auth = $auth;
    }

    public function get()
    {
        if (isset($_GET['id'])) {
            $this->auth->requireAuth();
        } else {
            $this->auth->requireAdmin();
        }

        $id = $_GET['id'] ?? null;
        $name = $_GET['name'] ?? null;

        try {
            $users = $this->userModel->getUsers($id, $name);
            Response::json($users);
        } catch (Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }

    public function update()
    {
        $this->auth->requireAuth();

        $user_id = $_GET['id'] ?? null;
        if (!$user_id) {
            Response::json(['error' => 'User ID is required'], 400);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            Response::json(['error' => 'Invalid JSON data'], 400);
            return;
        }

        try {
            $user = $this->userModel->updateUser($user_id, $data);
            Response::json([
                'success' => true,
                'message' => 'User updated successfully',
                'user' => $user
            ]);
        } catch (Exception $e) {
            $code = $e->getMessage() === 'User not found or no changes made' ? 404 : 500;
            Response::json(['error' => $e->getMessage()], $code);
        }
    }

    public function register()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['email']) || !isset($data['password']) || !isset($data['name'])) {
            Response::json(['error' => 'Email, name and password are required'], 400);
            return;
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            Response::json(['error' => 'Invalid email format'], 400);
            return;
        }

        try {
            $userId = $this->userModel->registerUser($data['email'], $data['password'], $data['name']);
            Response::json(['message' => 'User registered successfully', 'id' => $userId], 201);
        } catch (Exception $e) {
            $code = $e->getMessage() === 'Email already exists' ? 400 : 500;
            Response::json(['error' => $e->getMessage()], $code);
        }
    }

    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['email']) || !isset($data['password'])) {
            Response::json(['error' => 'Email and password are required'], 400);
            return;
        }

        try {
            if ($this->auth->loginUser($data['email'], $data['password'])) {
                Response::json(['message' => 'Login successful']);
            } else {
                Response::json(['error' => 'Invalid credentials'], 401);
            }
        } catch (Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }

    public function logout()
    {
        try {
            // session_start();
            $_SESSION = array();

            if (isset($_COOKIE[session_name()])) {
                setcookie(session_name(), '', time() - 3600, '/');
            }

            session_destroy();
            Response::json(['message' => 'Logout successful']);
        } catch (Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }
}