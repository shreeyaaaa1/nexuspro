<?php
requireLogin();
require_once 'includes/db_functions.php';

$user_id = $_SESSION['user_id'];
$research_projects = getResearchProjects($user_id);
?>

<div class="dashboard-container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Welcome, <?php echo $_SESSION['user_name']; ?></h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="index.php?page=research&action=create" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Research Project
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="dashboard-stats">
                <h4>Your Statistics</h4>
                <p>Total Projects: <?php echo count($research_projects); ?></p>
                <!-- Add more statistics here -->
            </div>
        </div>
        <div class="col-md-8">
            <div class="recent-activity">
                <h4>Recent Projects</h4>
                <?php if(empty($research_projects)): ?>
                    <p class="text-muted">No research projects found. Create your first project!</p>
                <?php else: ?>
                    <div class="row">
                        <?php foreach($research_projects as $project): ?>
                            <div class="col-md-6 mb-4">
                                <div class="card research-item">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($project['title']); ?></h5>
                                        <p class="card-text"><?php echo substr(htmlspecialchars($project['description']), 0, 100); ?>...</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">Created: <?php echo date('M d, Y', strtotime($project['created_at'])); ?></small>
                                            <a href="index.php?page=research&action=view&id=<?php echo $project['id']; ?>" class="btn btn-sm btn-outline-primary">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>