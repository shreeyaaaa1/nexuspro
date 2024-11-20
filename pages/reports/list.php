<?php
require_once 'includes/init.php';
require_once 'includes/auth.php';
require_once 'includes/report_functions.php';
require_once 'includes/header.php';

if (!isLoggedIn()) {
    header('Location: index.php?page=login');
    exit();
}

$reports = getReports($_SESSION['user_id']);
?>

<div class="container">
    <h1>Reports</h1>
    <div class="mb-4">
        <a href="index.php?page=reports&action=generate" class="btn btn-primary">Generate New Report</a>
    </div>

    <?php if(empty($reports)): ?>
        <p>No reports found. Generate your first report!</p>
    <?php else: ?>
        <div class="row">
            <?php foreach($reports as $report): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($report['title']); ?></h5>
                            <p class="card-text">
                                Generated: <?php echo date('M j, Y', strtotime($report['created_at'])); ?>
                            </p>
                            <a href="index.php?page=reports&action=view&id=<?php echo $report['id']; ?>" 
                               class="btn btn-info">View Report</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>