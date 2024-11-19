<?php

require_once '../../utils/Response.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::json(['error' => 'Method not allowed'], 405);
}

try {
    // Start the session
    session_start();
    
    // Unset all session variables
    $_SESSION = array();
    
    // Destroy the session cookie
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    
    // Destroy the session
    session_destroy();
    
    Response::json(['message' => 'Logout successful']);
} catch (Exception $e) {
    Response::json(['error' => $e->getMessage()], 500);
}