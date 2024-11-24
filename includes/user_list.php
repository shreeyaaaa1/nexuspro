Seeing the list of users

You can create a simple PHP page to display the list of users. Here's an example:

PHP
<?php
require_once 'config/config.php'; // Assuming this file contains your database connection

try {
    $stmt = $conn->query("SELECT id, name, email FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<ul>";
    foreach ($users as $user) {
        echo "<li>{$user['name']} ({$user['email']})</li>";
    }
    echo "</ul>";

} catch(PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>