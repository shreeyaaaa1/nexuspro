<?php
require_once 'includes/auth.php';

// Restrict access to admin only
if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header('Location: index.php?page=login');
    exit();
}

echo "<h1>Welcome, Admin {$_SESSION['name']}!</h1>";
?>
<div>
    <p>This is the admin dashboard. You can manage users and the system here.</p>
    <a href="index.php?page=register">Register a new user/admin</a>
    <a href="logout.php">Logout</a>
</div>
