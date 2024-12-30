<?php
// require_once 'app_config.php'; // Load configuration and set ENV
$dbConfig = 'prod';
// define('DB_HOST', 'localhost');
// define('DB_USER', 'root');
// define('DB_PASS', '');
// define('DB_NAME', 'pet_supplies_store_db');

// define('DB_HOST', 'db');
// define('DB_USER', 'root');
// define('DB_PASS', 'rootpassword');
// define('DB_NAME', 'pet_supplies_store_db');

if ($dbConfig === 'dev') {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'pet_supplies_store_db');
} else {
    define('DB_HOST', 'db');
    define('DB_USER', 'root');
    define('DB_PASS', 'rootpassword');
    define('DB_NAME', 'pet_supplies_store_db');
}