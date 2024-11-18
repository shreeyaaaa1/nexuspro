<?php
function loginUser($email, $password) {
    global $conn;
    
    try {
        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            return true;
        }
        return "Invalid email or password";
    } catch(PDOException $e) {
        return "Database error: " . $e->getMessage();
    }
}

function registerUser($name, $email, $password) {
    global $conn;
    
    try {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if($stmt->fetch()) {
            return "Email already exists";
        }
        
        // Hash password and insert user
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hashed_password]);
        return true;
    } catch(PDOException $e) {
        return "Database error: " . $e->getMessage();
    }
}

function getResearchProjects($user_id) {
    global $conn;
    
    try {
        $stmt = $conn->prepare("SELECT * FROM research_projects WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        return [];
    }
}

function createResearchProject($user_id, $title, $description, $metadata) {
    global $conn;
    
    try {
        $stmt = $conn->prepare("INSERT INTO research_projects (user_id, title, description, metadata) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $title, $description, json_encode($metadata)]);
        return $conn->lastInsertId();
    } catch(PDOException $e) {
        return false;
    }
}

function updateResearchProject($project_id, $user_id, $title, $description, $metadata) {
    global $conn;
    
    try {
        $stmt = $conn->prepare("UPDATE research_projects SET title = ?, description = ?, metadata = ? WHERE id = ? AND user_id = ?");
        return $stmt->execute([$title, $description, json_encode($metadata), $project_id, $user_id]);
    } catch(PDOException $e) {
        return false;
    }
}
function getUserDetails($user_id) {
    global $conn;
    
    try {
        // Get user basic info
        $stmt = $conn->prepare("SELECT id, name, email FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(!$user) {
            return null;
        }
        
        // Get project statistics
        $stmt = $conn->prepare("
            SELECT 
                COUNT(*) as total_projects,
                SUM(CASE WHEN JSON_EXTRACT(metadata, '$.status') = 'in_progress' THEN 1 ELSE 0 END) as active_projects,
                SUM(CASE WHEN JSON_EXTRACT(metadata, '$.status') = 'completed' THEN 1 ELSE 0 END) as completed_projects
            FROM research_projects 
            WHERE user_id = ?
        ");
        $stmt->execute([$user_id]);
        $stats = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return array_merge($user, $stats);
    } catch(PDOException $e) {
        return null;
    }
}

function updateUserProfile($user_id, $name, $email) {
    global $conn;
    
    try {
        // Check if email is already used by another user
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->execute([$email, $user_id]);
        if($stmt->fetch()) {
            return "Email is already in use";
        }
        
        // Update user profile
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $stmt->execute([$name, $email, $user_id]);
        return true;
    } catch(PDOException $e) {
        return "Database error: " . $e->getMessage();
    }
}

function changeUserPassword($user_id, $current_password, $new_password) {
    global $conn;
    
    try {
        // Verify current password
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();
        
        if(!$user || !password_verify($current_password, $user['password'])) {
            return "Current password is incorrect";
        }
        
        // Update password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashed_password, $user_id]);
        return true;
    } catch(PDOException $e) {
        return "Database error: " . $e->getMessage();
    }
}

function getProjectDetails($project_id, $user_id) {
    global $conn;
    
    try {
        // Get project details with permission check
        $stmt = $conn->prepare("
            SELECT p.* FROM research_projects p
            LEFT JOIN collaborators c ON p.id = c.project_id AND c.user_id = ?
            WHERE p.id = ? AND (p.user_id = ? OR c.user_id IS NOT NULL)
        ");
        $stmt->execute([$user_id, $project_id, $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        return null;
    }
}
?>