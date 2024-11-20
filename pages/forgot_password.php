<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Connect to the database
    include '../config/database.php';

    // Check if the email exists
    $query = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $query->execute(['email' => $email]);
    $user = $query->fetch();

    if ($user) {
        // Generate a unique reset token
        $token = bin2hex(random_bytes(50));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Store token in the database
        $update = $pdo->prepare("UPDATE users SET reset_token = :token, token_expiration = :expiry WHERE email = :email");
        $update->execute(['token' => $token, 'expiry' => $expiry, 'email' => $email]);

        // Send email
        $resetLink = "localhost/pages/reset_password.php?token=" . $token;
        mail($email, "Password Reset Request", "Click this link to reset your password: $resetLink");

        echo "A password reset link has been sent to your email.";
    } else {
        echo "No user found with this email.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>
    <form method="POST">
        <label>Email Address:</label>
        <input type="email" name="email" required>
        <button type="submit">Send Reset Link</button>
    </form>
</body>
</html>
