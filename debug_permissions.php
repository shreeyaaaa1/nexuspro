<?php
require_once 'includes/init.php';
requireLogin();

$project_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user_id = $_SESSION['user_id'];

echo "Debugging Project Access\n";
echo "=======================\n";
echo "Project ID: " . htmlspecialchars($project_id) . "\n";
echo "User ID: " . htmlspecialchars($user_id) . "\n\n";

try {
    // 1. Check if project exists
    $check = $conn->prepare("SELECT * FROM research_projects WHERE id = ?");
    $check->execute([$project_id]);
    $project = $check->fetch(PDO::FETCH_ASSOC);
    
    echo "1. Project Lookup:\n";
    var_dump($project);
    echo "\n";
    
    if ($project) {
        echo "2. Ownership Check:\n";
        echo "Project owner ID: " . $project['user_id'] . "\n";
        echo "Current user ID: " . $user_id . "\n";
        echo "Is owner? " . ($project['user_id'] == $user_id ? "Yes" : "No") . "\n\n";
        
        echo "3. Collaborator Check:\n";
        $collab = $conn->prepare("SELECT * FROM collaborators WHERE project_id = ? AND user_id = ?");
        $collab->execute([$project_id, $user_id]);
        $collaboration = $collab->fetch(PDO::FETCH_ASSOC);
        echo "Collaboration record:\n";
        var_dump($collaboration);
    }
    
} catch(PDOException $e) {
    echo "Database Error: " . $e->getMessage() . "\n";
    echo "SQL State: " . $e->errorInfo[0] . "\n";
}