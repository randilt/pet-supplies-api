<?php
class Auth {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function isAuthenticated() {
        session_start();
        return isset($_SESSION['user_id']);
    }
    
    public function requireAuth() {
        if (!$this->isAuthenticated()) {
            Response::json(['error' => 'Unauthorized access'], 401);
        }
    }
}
