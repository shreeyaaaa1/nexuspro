<?php
require_once 'includes/init.php';

// Get project ID from URL
$project_id = isset($_GET['id']) ? $_GET['id'] : null;
$user_id = $_SESSION['user_id'];

if ($project_id && $user_id) {
    // Debug database connection
    var_dump($conn);
    
    // Debug query parameters
    echo "Project ID: " . htmlspecialchars($project_id) . "\n";
    echo "User ID: " . htmlspecialchars($user_id) . "\n";
    
    // Run query directly
    $stmt = $conn->prepare("
        SELECT p.id, p.user_id, p.title, p.description, p.metadata, p.created_at, p.updated_at 
        FROM research_projects p
        LEFT JOIN collaborators c ON p.id = c.project_id AND c.user_id = ?
        WHERE p.id = ? AND (p.user_id = ? OR c.user_id IS NOT NULL)
    ");
    $stmt->execute([$user_id, $project_id, $user_id]);
    var_dump($stmt->fetch(PDO::FETCH_ASSOC));
    
    // Check if any rows exist at all for this project
    $check = $conn->prepare("SELECT * FROM research_projects WHERE id = ?");
    $check->execute([$project_id]);
    var_dump($check->fetch(PDO::FETCH_ASSOC));
} else {
    echo "Missing project ID or user ID\n";
}
?>