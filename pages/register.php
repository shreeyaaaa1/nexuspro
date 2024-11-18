<?php
if(isLoggedIn()) {
    header('Location: index.php?page=dashboard');
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'includes/db_functions.php';
    
    $name = validateInput($_POST['name']);
    $email = validateInput($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if(empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Please fill in all fields";
    } elseif($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {
        $result = registerUser($name, $email, $password);
        if($result === true) {
            header('Location: index.php?page=login');
            exit();
        } else {
            $error = $result;
        }
    }
}
?>

<div class="register-form">
    <h2 class="text-center mb-4">Register</h2>
    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
    
    <div class="text-center mt-3">
        <p>Already have an account? <a href="index.php?page=login">Login here</a></p>
    </div>
</div>