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
                        <!-- Add data visualizations here -->
                        <p class="text-muted">Data visualizations will be displayed here.</p>
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
                    
                    <div class="metadata-item">
                        <strong>Category:</strong>
                        <p><?php echo ucfirst(str_replace('_', ' ', $metadata['category'])); ?></p>
                    </div>
                    
                    <div class="metadata-item">
                        <strong>Status:</strong>
                        <p><?php echo ucfirst(str_replace('_', ' ', $metadata['status'])); ?></p>
                    </div>
                    
                    <div class="metadata-item">
                        <strong>Created:</strong>
                        <p><?php echo date('F d, Y', strtotime($project['created_at'])); ?></p>
                    </div>
                    
                    <div class="metadata-item">
                        <strong>Last Updated:</strong>
                        <p><?php echo date('F d, Y', strtotime($project['updated_at'])); ?></p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Collaborators</h5>
                    <!-- Add collaborator management here -->
                    <p class="text-muted">No collaborators yet.</p>
                    <button class="btn btn-sm btn-outline-primary">Add Collaborator</button>
                </div>
            </div>
        </div>
    </div>
</div>