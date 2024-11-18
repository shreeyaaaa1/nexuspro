<?php
if(isLoggedIn()) {
    header('Location: index.php?page=dashboard');
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'includes/db_functions.php';
    
    $email = validateInput($_POST['email']);
    $password = $_POST['password'];
    
    if(empty($email) || empty($password)) {
        $error = "Please fill in all fields";
    } else {
        $result = loginUser($email, $password);
        if($result === true) {
            header('Location: index.php?page=dashboard');
            exit();
        } else {
            $error = $result;
        }
    }
}
?>

<div class="login-form">
    <h2 class="text-center mb-4">Login</h2>
    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    
    <div class="text-center mt-3">
        <p>Don't have an account? <a href="index.php?page=register">Register here</a></p>
    </div>
</div>