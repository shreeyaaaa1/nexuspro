<div class="container">
    <h2>Create New Research Project</h2>
    
    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
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