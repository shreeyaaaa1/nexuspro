<?php
require_once 'includes/init.php';
require_once 'includes/auth.php';
require_once 'includes/header.php';

// Ensure user is logged in
if (!isLoggedIn()) {
    header('Location: index.php?page=login');
    exit();
}

// Get project ID from URL
$project_id = isset($_GET['id']) ? $_GET['id'] : null;
if (!$project_id) {
    echo '<div class="container mt-4"><div class="alert alert-danger">Project ID not provided.</div></div>';
    require_once 'includes/footer.php';
    exit();
}

// Get project details
$project = getProjectDetailsSecure($project_id, $_SESSION['user_id']);
if (!$project) {
    echo '<div class="container mt-4"><div class="alert alert-danger">Project not found or you don\'t have permission to view it.</div></div>';
    require_once 'includes/footer.php';
    exit();
}

// Get file data counts for visualizations
$fileDataCounts = getFileDataCounts($project_id); // This function needs to be defined in your backend
?>
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><?php echo htmlspecialchars($project['title']); ?></h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="index.php?page=research&action=edit&id=<?php echo $project['id']; ?>" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit Project
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Description</h5>
                    <p class="card-text"><?php echo nl2br(htmlspecialchars($project['description'])); ?></p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Research Data</h5>
                    <div class="visualization-container">
                        <h6>File Type Distribution</h6>
                        <canvas id="barChart"></canvas>
                        <canvas id="pieChart" class="mt-4"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Project Metadata</h5>
                    <?php $metadata = json_decode($project['metadata'], true); ?>
                    
                    <div class="metadata-item">
                        <strong>Keywords:</strong>
                        <div class="mt-2">
                            <?php foreach($metadata['keywords'] as $keyword): ?>
                                <span class="badge bg-secondary me-1"><?php echo htmlspecialchars($keyword); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const fileDataCounts = <?php echo json_encode($fileDataCounts); ?>;

    const labels = Object.keys(fileDataCounts); // ['pdf', 'audio', 'video']
    const data = Object.values(fileDataCounts); // [2, 3, 3]

    // Bar Chart
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Number of Files',
                data: data,
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#17a2b8'],
                borderColor: '#333',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });

    // Pie Chart
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#17a2b8'],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            }
        }
    });
});
</script>
<?php
require_once 'includes/footer.php';
?>
