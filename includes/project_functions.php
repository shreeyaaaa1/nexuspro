<?php
function getProjectDetailsSecure($project_id, $user_id) {
    global $conn;
    
    try {
        // First verify project exists
        $check = $conn->prepare("SELECT * FROM research_projects WHERE id = ?");
        $check->execute([$project_id]);
        $project = $check->fetch(PDO::FETCH_ASSOC);
        
        if (!$project) {
            error_log("Project not found: $project_id");
            return null;
        }
        
        // Check if user is owner
        if ($project['user_id'] == $user_id) {
            return $project;
        }
        
        // Check if user is collaborator
        $collab = $conn->prepare("SELECT 1 FROM collaborators WHERE project_id = ? AND user_id = ?");
        $collab->execute([$project_id, $user_id]);
        
        if ($collab->fetch()) {
            return $project;
        }
        
        error_log("Access denied for user $user_id to project $project_id");
        return null;
    } catch(PDOException $e) {
        error_log("Database error in getProjectDetailsSecure: " . $e->getMessage());
        return null;
    }
}