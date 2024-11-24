<?php
require_once __DIR__ . '/../includes/db_functions.php';

// start output buffering
ob_start();
require_once 'includes/auth.php';
if(isLoggedIn()) {
    header('Location: index.php?page=dashboard');
    exit();
}

// Check if the user is logged in
if (isLoggedIn()) {
  if ($_SESSION['role'] !== 'admin') {
      // Redirect logged-in users who are not admin
      header('Location: index.php?page=dashboard');
      exit();
  }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = validateInput($_POST['name']);
  $email = validateInput($_POST['email']);
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  $role = isset($_POST['role']) ? $_POST['role'] : 'user'; // Default to 'user'

  if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
    $error = "Please fill in all fields";
} elseif ($password !== $confirm_password) {
    $error = "Passwords do not match";
} else {
    // Check if the current session role allows role assignment
    if ($_SESSION['role'] !== 'admin') {
        $role = 'user'; // Enforce 'user' role for non-admins
    }

    $result = registerUser($name, $email, $password, $role); // Updated to include role
    if ($result === true) {
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
    <?php if (isset($error)): ?>
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
        
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-control" id="role" name="role">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
        <?php endif; ?>

        <!-- Register Button with Icon -->
        <button type="submit" class="btn btn-primary w-100">
            <i class="fas fa-user-plus btn-icon"></i> Register
        </button>
    </form>
    
    <div class="text-center mt-3">
        <p>Already have an account? <a href="index.php?page=login">Login here</a></p>
    </div>
</div>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap');

  body {
    background-color: #a4c0a2; 
    color: #000; 
    font-family: 'Playfair Display', serif; /* Apply the font */
    overflow: hidden; /* To prevent scrollbars with the angled background */
  }

  .register-form {
    background-color: #fff; 
    border-radius: 15px;
    padding: 40px;
    position: relative;
  }

  .register-form h2 {
    font-weight: 700;
    margin-bottom: 30px;
    color: #fff; /* White heading color */
  }

  .form-control {
    padding: 12px 15px; /* Increased padding for better usability */
    font-size: 16px;
    background-color: #343a40; 
    color: #fff;
  }

  .btn-primary {
    padding: 12px 20px; /* Increased padding for better button size */
    font-size: 18px;
    font-weight: 700;
    background-image: linear-gradient(to right, #007bff, #0056b3); /* Blue gradient */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); /* Subtle shadow */
    position: relative; /* To position the pseudo-element */
    overflow: hidden; /* To contain the animation */
  }

  .btn-primary:hover {
    background-image: linear-gradient(to right, #0069d9, #0049a3); /* Darker blue gradient on hover */
    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.3); /* More pronounced shadow */
  }

  .btn-icon {
    margin-right: 8px;
  }

  .register-form::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #8ab4f8; /* Blue background */
    transform: skewY(-5deg); /* Skew the background */
    z-index: -1; /* Behind the form */
  }

  @keyframes ripple {
    to {
      transform: translateY(-50%) translateX(150px) scale(2); /* Move and scale up */
      opacity: 0; /* Fade out */
    }
  }

  /* Add floating paper icons animation */
  .paper-icon {
    position: absolute;
    width: 40px;
    height: 40px;
    background-image: url('path/to/your/research-paper-icon.svg'); /* Replace with your icon path */
    background-repeat: no-repeat;
    background-size: contain;
    opacity: 0;
    animation: float 10s linear infinite;
  }

  .paper-icon-1 {
    left: 10%;
    bottom: 20%;
    animation-delay: 1s;
  }

  .paper-icon-2 {
    right: 15%;
    top: 30%;
    animation-delay: 3s;
  }

  .paper-icon-3 {
    left: 50%;
    top: 10%;
    animation-delay: 5s;
  }

  .paper-icon-4 {
    left: 70%;
    top: 50%;
    animation-delay: 2s;
  }

  .paper-icon-5 {
    left: 20%;
    top: 10%;
    animation-delay: 4s;
  }

  @keyframes float {
    0% {
      opacity: 0;
      transform: translateY(0) scale(0.8);
    }
    50% {
      opacity: 0.7;
      transform: translateY(-80px) scale(1);
    }
    100% {
      opacity: 0;
      transform: translateY(-160px) scale(0.8);
    }
  }
</style>
