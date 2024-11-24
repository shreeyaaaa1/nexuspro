<?php
if (isLoggedIn()) {
    header('Location: index.php?page=dashboard');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'includes/db_functions.php';
    
    $email = validateInput($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];  // New field to determine whether it's user or admin login
    
    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields";
    } else {
        $result = loginUser($email, $password, $role);  // Pass role to the login function
        if ($result === true) {
            // Redirect to the correct dashboard based on role
            if ($role == 'admin') {
                header('Location: index.php?page=admin_dashboard');
            } else {
                header('Location: index.php?page=user_dashboard');
            }
            exit();
        } else {
            $error = $result;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusDoc - Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap');
        body {
            background-color: #a4c0a2; 
            color: #000; 
            font-family: 'Playfair Display', serif; 
            overflow: hidden; 
        }

        .login-form {
            background-color: #fff; 
            border-radius: 15px;
            padding: 40px;
            position: relative; 
            width: 400px; 
            margin: 50px auto;
        }

        .login-form h2 {
            font-weight: 700;
            margin-bottom: 30px;
            color: #fff; 
        }

        .form-control {
            padding: 12px 15px; 
            font-size: 16px;
            background-color: #fff; 
            color: #000;
            border: 1px solid #ced4da;
        }

        .btn-primary {
            padding: 12px 20px; 
            font-size: 18px;
            font-weight: 700;
            background-image: linear-gradient(to right, #8ab4f8, #6495ED); 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); 
            position: relative; 
            overflow: hidden; 
        }

        .btn-primary:hover {
            background-image: linear-gradient(to right, #6495ED, #4169E1);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.3); 
        }

        .btn-icon {
            margin-right: 8px;
        }

        .login-form::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #8ab4f8; 
            transform: skewY(-5deg); 
            z-index: -1; 
        }
    </style>
</head>
<body>

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

        <!-- Role Selection Buttons with Icons -->
        <div class="mb-3">
            <button type="submit" class="btn btn-primary w-100" name="role" value="user">
                <i class="fas fa-user btn-icon"></i> Login as User
            </button>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary w-100" name="role" value="admin">
                <i class="fas fa-user-shield btn-icon"></i> Login as Admin
            </button>
        </div>
    </form>

    <div class="text-center mt-3">
        <p>Don't have an account? <a href="index.php?page=register">Register here</a></p>
        <p><a href="forgot_password.php">Forgot your password?</a></p>
    </div>
</div>

</body>
</html>
