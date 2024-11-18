<?php
requireLogin();
require_once 'includes/db_functions.php';

$user_id = $_SESSION['user_id'];
$error = null;
$success = null;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = validateInput($_POST['name']);
    $email = validateInput($_POST['email']);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Update profile information
    if(isset($_POST['update_profile'])) {
        if(empty($name) || empty($email)) {
            $error = "Name and email are required";
        } else {
            $result = updateUserProfile($user_id, $name, $email);
            if($result === true) {
                $_SESSION['user_name'] = $name;
                $success = "Profile updated successfully";
            } else {
                $error = $result;
            }
        }
    }
    
    // Change password
    if(isset($_POST['change_password'])) {
        if(empty($current_password) || empty($new_password) || empty($confirm_password)) {
            $error = "All password fields are required";
        } elseif($new_password !== $confirm_password) {
            $error = "New passwords do not match";
        } else {
            $result = changeUserPassword($user_id, $current_password, $new_password);
            if($result === true) {
                $success = "Password changed successfully";
            } else {
                $error = $result;
            }
        }
    }
}

$user = getUserDetails($user_id);
?>

<div class="container">
    <h2 class="mb-4">Profile Settings</h2>
    
    <?php if($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Profile Information</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                        <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Change Password</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Account Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stats-item text-center">
                                <h3><?php echo $user['total_projects']; ?></h3>
                                <p class="text-muted">Total Projects</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-item text-center">
                                <h3><?php echo $user['active_projects']; ?></h3>
                                <p class="text-muted">Active Projects</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-item text-center">
                                <h3><?php echo $user['completed_projects']; ?></h3>
                                <p class="text-muted">Completed Projects</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>