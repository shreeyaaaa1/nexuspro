<?php
// start output buffering
ob_start();
require_once 'includes/auth.php';
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
    adding: 12px 15px; /* Increase padding */
    font-size: 16px;
    background-color: #343a40; 
    color: #fff;
  }

  .btn-primary {
    padding: 12px 20px; /* Increase padding */
    font-size: 18px;
    font-weight: 700;
    background-image: linear-gradient(to right, #007bff, #0056b3); /* Blue gradient */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); /* Add a subtle shadow */
    position: relative; /* To position the pseudo-element */
    overflow: hidden; /* To contain the animation */
    
  }

  .btn-primary:hover {
    background-image: linear-gradient(to right, #0069d9, #0049a3); /* Darker blue gradient on hover */
    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.3); /* More pronounced shadow */
  }

  .register-form::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #8ab4f8; /* Blue color */
    transform: skewY(-5deg); /* Skew the element */
    z-index: -1; /* Place it behind the form */
  }

  @keyframes ripple {
    to {
      transform: translateY(-50%) translateX(150px) scale(2); /* Move and scale up */
      opacity: 0; /* Fade out */
    }
  }

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