<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Research Projects</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="index.php?page=research&action=create" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Project
            </a>
        </div>
    </div>

    <?php if(empty($projects)): ?>
        <div class="alert alert-info">
            No research projects found. Create your first project to get started!
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach($projects as $project): ?>
                <div class="col-md-6 mb-4">
                    <div class="card research-item">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($project['title']); ?></h5>
                            <p class="card-text"><?php echo substr(htmlspecialchars($project['description']), 0, 150); ?>...</p>
                            
                            <?php $metadata = json_decode($project['metadata'], true); ?>
                            <div class="mb-3">
                                <?php foreach($metadata['keywords'] as $keyword): ?>
                                    <span class="badge bg-secondary me-1"><?php echo htmlspecialchars($keyword); ?></span>
                                <?php endforeach; ?>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">Status: <?php echo ucfirst($metadata['status']); ?></small>
                                    <br>
                                    <small class="text-muted">Created: <?php echo date('M d, Y', strtotime($project['created_at'])); ?></small>
                                </div>
                                <div>
                                    <a href="index.php?page=research&action=view&id=<?php echo $project['id']; ?>" class="btn btn-sm btn-outline-primary">View</a>
                                    <a href="index.php?page=research&action=edit&id=<?php echo $project['id']; ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>