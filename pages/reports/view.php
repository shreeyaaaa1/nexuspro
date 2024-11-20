<?php
require_once 'includes/init.php';
require_once 'includes/auth.php';
require_once 'includes/header.php';

if (!isLoggedIn()) {
    header('Location: index.php?page=login');
    exit();
}

$report_id = $_GET['id'] ?? null;
if (!$report_id) {
    header('Location: index.php?page=reports');
    exit();
}

$report = getReport($report_id, $_SESSION['user_id']);
if (!$report) {
    $_SESSION['error'] = "Report not found or access denied";
    header('Location: index.php?page=reports');
    exit();
}
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?php echo htmlspecialchars($report['title']); ?></h1>
        <div>
            <a href="index.php?page=reports&action=download&id=<?php echo $report_id; ?>" class="btn btn-success me-2">
                <i class="fas fa-download"></i> Download PDF
            </a>
            <a href="index.php?page=reports" class="btn btn-secondary">Back to Reports</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="mb-4">
                <strong>Generated:</strong> <?php echo date('F j, Y g:i A', strtotime($report['created_at'])); ?><br>
                <strong>Type:</strong> <?php echo htmlspecialchars($report['type']); ?><br>
                <strong>Date Range:</strong> <?php echo date('M j, Y', strtotime($report['from_date'])); ?> - 
                                           <?php echo date('M j, Y', strtotime($report['to_date'])); ?>
            </div>

            <div class="report-content">
                <?php echo $report['content']; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>