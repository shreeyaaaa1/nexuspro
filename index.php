<?php
session_start();
require_once 'config/config.php';
require_once 'includes/auth.php';

// Route handling
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$allowed_pages = ['home', 'login', 'register', 'dashboard', 'research', 'profile'];

if (!in_array($page, $allowed_pages)) {
    $page = 'home';
}

include 'includes/header.php';
include "pages/{$page}.php";
include 'includes/footer.php';
?>