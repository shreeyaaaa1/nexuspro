<?php
function uploadResearchFile($project_id, $file, $metadata = []) {
    global $conn;
    
    $upload_dir = __DIR__ . '/../uploads/research/' . $project_id . '/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_type = $file['type'];
    
    // Generate unique filename
    $unique_filename = uniqid() . '_' . $file_name;
    $file_path = $upload_dir . $unique_filename;
    
    try {
        if (move_uploaded_file($file_tmp, $file_path)) {
            $stmt = $conn->prepare("
                INSERT INTO research_files (project_id, file_name, file_path, file_type, file_size, metadata)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $project_id,
                $file_name,
                'uploads/research/' . $project_id . '/' . $unique_filename,
                $file_type,
                $file_size,
                json_encode($metadata)
            ]);
            return true;
        }
        return "Error uploading file";
    } catch(PDOException $e) {
        return "Database error: " . $e->getMessage();
    }
}

function getProjectFiles($project_id) {
    global $conn;
    
    try {
        $stmt = $conn->prepare("SELECT * FROM research_files WHERE project_id = ? ORDER BY uploaded_at DESC");
        $stmt->execute([$project_id]);
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        return [];
    }
}

function deleteResearchFile($file_id, $project_id) {
    global $conn;
    
    try {
        // Get file details first
        $stmt = $conn->prepare("SELECT file_path FROM research_files WHERE id = ? AND project_id = ?");
        $stmt->execute([$file_id, $project_id]);
        $file = $stmt->fetch();
        
        if ($file) {
            // Delete physical file
            $full_path = __DIR__ . '/../' . $file['file_path'];
            if (file_exists($full_path)) {
                unlink($full_path);
            }
            
            // Delete database record
            $stmt = $conn->prepare("DELETE FROM research_files WHERE id = ?");
            $stmt->execute([$file_id]);
            return true;
        }
        return "File not found";
    } catch(PDOException $e) {
        return "Database error: " . $e->getMessage();
    }
}

function isAllowedFileType($filename) {
    $allowed_types = explode(',', getenv('ALLOWED_FILE_TYPES'));
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return in_array($ext, $allowed_types);
}

function formatFileSize($bytes) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, 2) . ' ' . $units[$pow];
}