<div class="jumbotron text-center py-5 bg-light">
    <h1 class="display-4">Welcome to <?php echo SITE_NAME; ?></h1>
    <p class="lead">A comprehensive platform for managing research data and collaboration.</p>
    <?php if(!isLoggedIn()): ?>
        <a href="index.php?page=register" class="btn btn-primary btn-lg">Get Started</a>
    <?php endif; ?>
</div>

<div class="row mt-5">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Management</h5>
                <p class="card-text">Efficiently organize and manage your research data with advanced metadata support.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Collaboration</h5>
                <p class="card-text">Work seamlessly with other researchers and share your findings.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Visualization</h5>
                <p class="card-text">Transform your data into meaningful visualizations and insights.</p>
            </div>
        </div>
    </div>
</div>