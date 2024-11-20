<?php
// Database configuration
define('DB_HOST', getenv('DB_HOST') ?: 'mysql');
define('DB_USER', getenv('DB_USER') ?: 'rcmwa_user');
define('DB_PASS', getenv('DB_PASS') ?: 'secret_password');
define('DB_NAME', getenv('DB_NAME') ?: 'rcmwa_db');

// Application configuration
define('SITE_NAME', 'NexusDoc - Your Research Data Manager');
define('SITE_URL', 'http://localhost/index.php');

// Establish database connection
try {
    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>