<?php
require_once 'includes/init.php';
require_once 'includes/auth.php';
require_once 'includes/header.php';

if (!isLoggedIn()) {
    header('Location: index.php?page=login');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $type = $_POST['type'] ?? '';
    $from_date = $_POST['from_date'] ?? '';
    $to_date = $_POST['to_date'] ?? '';
    
    // Validate input
    $errors = [];
    if (empty($title)) {
        $errors[] = "Title is required";
    }
    if (empty($type)) {
        $errors[] = "Report type is required";
    }
    if (empty($from_date)) {
        $errors[] = "Start date is required";
    }
    if (empty($to_date)) {
        $errors[] = "End date is required";
    }

    if (empty($errors)) {
        $report_id = generateReport([
            'user_id' => $_SESSION['user_id'],
            'title' => $title,
            'type' => $type,
            'from_date' => $from_date,
            'to_date' => $to_date
        ]);

        if ($report_id) {
            header('Location: index.php?page=reports&action=view&id=' . $report_id);
            exit();
        } else {
            $errors[] = "Failed to generate report";
        }
    }
}
?>

<div class="container">
    <h1>Generate New Report</h1>
    
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="title" class="form-label">Report Title</label>
            <input type="text" class="form-control" id="title" name="title" required
                   value="<?php echo isset($title) ? htmlspecialchars($title) : ''; ?>">
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Report Type</label>
            <select class="form-select" id="type" name="type" required>
                <option value="">Select a report type...</option>
                <option value="research_summary" <?php echo (isset($type) && $type === 'research_summary') ? 'selected' : ''; ?>>Research Summary</option>
                <option value="project_progress" <?php echo (isset($type) && $type === 'project_progress') ? 'selected' : ''; ?>>Project Progress</option>
                <option value="activity_log" <?php echo (isset($type) && $type === 'activity_log') ? 'selected' : ''; ?>>Activity Log</option>
            </select>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="from_date" class="form-label">From Date</label>
                    <input type="date" class="form-control" id="from_date" name="from_date" required
                           value="<?php echo isset($from_date) ? htmlspecialchars($from_date) : ''; ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="to_date" class="form-label">To Date</label>
                    <input type="date" class="form-control" id="to_date" name="to_date" required
                           value="<?php echo isset($to_date) ? htmlspecialchars($to_date) : ''; ?>">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Generate Report</button>
        <a href="index.php?page=reports" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>