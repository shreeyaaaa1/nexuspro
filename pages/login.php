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
<!DOCTYPE html>
<html>
<head>
  <title>NexusDoc - Login</title>
<div class="login-form">
    <h2 class="text-center mb-4">Login</h2>
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
      width: 400px; /* Adjust width as needed */
      margin: 50px auto;
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

    .btn-primary::before {
      content: '';
      position: absolute;
      top: 50%;
      left: -50px; 
      width: 100px;
      height: 100px;
      background-color: rgba(255, 255, 255, 0.2); 
      border-radius: 50%;
      transform: translateY(-50%) translateX(-50%) scale(0); 
      animation: ripple 2s linear infinite; 
    }

    @keyframes ripple {
      to {
        transform: translateY(-50%) translateX(150px) scale(2); 
        opacity: 0; 
      }
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
    .paper-icon {
      position: fixed; /* Fixed position to keep them in the background */
      width: 40px;
      height: 40px;
      background-image: url('/research-paper-icon.svg'); 
      background-repeat: no-repeat;
      background-size: contain;
      opacity: 0;
      animation: float 10s linear infinite;
      z-index: -2; 
      filter: invert(100%); /* Invert the icon color to white */
      display: flex; 
      font-family: "Font Awesome 6 Free"; 
      content: "\f15c"; 
      filter: invert(100%); 
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
  </style>
</head>
<body>
  <div class="paper-icon paper-icon-1"></div>
  <div class="paper-icon paper-icon-2"></div>
  <div class="paper-icon paper-icon-3"></div>
  <div class="paper-icon paper-icon-4"></div>
  <div class="paper-icon paper-icon-5"></div>
  
    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php for ($i = 1; $i <= 5; $i++): ?>
    <div class="paper-icon paper-icon-<?php echo $i; ?>"></div>
    <?php endfor; ?>
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
        <p><a href="forgot_password.php">Forgot your password?</a></p>
        
    </div>
</div>

</body>
</html>