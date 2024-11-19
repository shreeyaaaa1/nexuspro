<div class="container">
    <h2>Add Your Research Project</h2>
    
    <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error = '';
    $uploadedFiles = [];
    $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf', 'application/msword', 'application/vnd.ms-excel', 'video/mp4'];

    // Check if files were uploaded
    if (isset($_FILES['files']) && !empty($_FILES['files']['name'][0])) {
        $files = $_FILES['files'];

        // Loop through each uploaded file
        for ($i = 0; $i < count($files['name']); $i++) {
            $fileName = $files['name'][$i];
            $fileTmpName = $files['tmp_name'][$i];
            $fileSize = $files['size'][$i];
            $fileError = $files['error'][$i];
            $fileType = $files['type'][$i];

            // Check for file upload errors
            if ($fileError !== UPLOAD_ERR_OK) {
                $error .= "Error uploading file: $fileName.<br>";
                continue;
            }

            // Check if file type is allowed
            if (!in_array($fileType, $allowedTypes)) {
                $error .= "File type not allowed: $fileName.<br>";
                continue;
            }

            // Set the file upload directory
            $uploadDir = 'uploads/research_files/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
            }

            // Create a unique name for the file to avoid conflicts
            $fileDestination = $uploadDir . uniqid('', true) . '-' . basename($fileName);

            // Move the file to the upload directory
            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                $uploadedFiles[] = [
                    'name' => $fileName,
                    'type' => $fileType,
                    'path' => $fileDestination
                ];
            } else {
                $error .= "Failed to upload file: $fileName.<br>";
            }
        }
    } else {
        $error .= "No files selected.<br>";
    }

    // If there are any errors, display them
    if ($error) {
        echo "<div class='alert alert-danger'>$error</div>";
    }

    if (!empty($uploadedFiles)) {
        echo "<h5>Uploaded Files:</h5>";
        echo "<ul>";
        foreach ($uploadedFiles as $file) {
            echo "<li><strong>File Name:</strong> {$file['name']}<br>
                      <strong>File Type:</strong> {$file['type']}<br>
                      <strong>File Path:</strong> {$file['path']}</li><br>";
        }
        echo "</ul>";
    }
    
    // File type statistics initialization
$fileTypeCounts = [
    'image' => 0,
    'video' => 0,
    'document' => 0,
    'other' => 0
];

// File types
$imageTypes = ['image/jpeg', 'image/png'];
$videoTypes = ['video/mp4'];
$documentTypes = ['application/pdf', 'application/msword', 'application/vnd.ms-excel'];

foreach ($uploadedFiles as $file) {
    if (in_array($file['type'], $imageTypes)) {
        $fileTypeCounts['image']++;
    } elseif (in_array($file['type'], $videoTypes)) {
        $fileTypeCounts['video']++;
    } elseif (in_array($file['type'], $documentTypes)) {
        $fileTypeCounts['document']++;
    } else {
        $fileTypeCounts['other']++;
    }
}

// Calculate total files uploaded
$totalFiles = array_sum($fileTypeCounts);

// Display file type distribution
if ($totalFiles > 0) {
    echo "<h5>File Type Distribution</h5>";
    echo "<ul>";
    echo "<li>Images: " . round(($fileTypeCounts['image'] / $totalFiles) * 100, 2) . "%</li>";
    echo "<li>Videos: " . round(($fileTypeCounts['video'] / $totalFiles) * 100, 2) . "%</li>";
    echo "<li>Documents: " . round(($fileTypeCounts['document'] / $totalFiles) * 100, 2) . "%</li>";
    echo "<li>Other: " . round(($fileTypeCounts['other'] / $totalFiles) * 100, 2) . "%</li>";
    echo "</ul>";
} else {
    echo "<p>No files uploaded yet.</p>";
}
}
?>
  
    <form method="POST" action="" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="title" class="form-label">Project Title *</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
        </div>
        
        <div class="metadata-section">
            <h4>Project Metadata</h4>
            
            <div class="mb-3">
                <label for="keywords" class="form-label">Keywords (comma-separated)</label>
                <input type="text" class="form-control" id="keywords" name="keywords">
            </div>
            
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-control" id="category" name="category">
                    <option value="">Select Category</option>
                    <option value="experimental">Experimental Research</option>
                    <option value="theoretical">Theoretical Research</option>
                    <option value="review">Literature Review</option>
                    <option value="case_study">Case Study</option>
                    <option value="other">Other</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="status" class="form-label">Project Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="planning">Planning</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                    <option value="archived">Archived</option>
                </select>
            </div>
            <div class="mb-3">
            <label for="files" class="form-label">Upload Files</label>
            <input type="file" class="form-control" id="files" name="files[]" multiple>
            <small class="form-text text-muted">You can upload multiple files from one folder (images, documents, etc.).</small>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Create Project</button>
        <a href="index.php?page=dashboard" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
// Form validation
(function() {
    'use strict';
    var forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>