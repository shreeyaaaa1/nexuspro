<?php
require_once 'includes/auth.php';

// Restrict access to users only
if (!isLoggedIn() || $_SESSION['role'] !== 'user') {
    header('Location: index.php?page=login');
    exit();
}

echo "<h1>Welcome, {$_SESSION['name']}!</h1>";
?>
<div>
    <p>This is your user dashboard. Explore your features here.</p>
    <a href="logout.php">Logout</a>
</div>
