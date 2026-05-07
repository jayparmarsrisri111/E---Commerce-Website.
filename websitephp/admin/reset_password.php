<?php
session_start();
include("configpage.php");

if (!isset($_SESSION['admin_otp_verified']) || $_SESSION['admin_otp_verified'] !== true) {
    header("Location: forgot_password.php");
    exit();
}

$email = $_SESSION['admin_reset_email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = mysqli_real_escape_string($mysqli, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($mysqli, $_POST['confirm_password']);
    
    if ($new_password === $confirm_password) {
        // Update password in database
        $query = "UPDATE adminlo SET password='$new_password' WHERE email='$email'";
        if (mysqli_query($mysqli, $query)) {
            // Clear session variables
            unset($_SESSION['admin_reset_email']);
            unset($_SESSION['admin_reset_otp']);
            unset($_SESSION['admin_otp_verified']);
            
            echo "<script>alert('Password reset successfully! You can now login with your new password.'); window.location.href='adminlogin.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error updating password. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Passwords do not match. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - MARINE TRADERS</title>
    <link rel="icon" href="../image/LOGO.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/adminlogin.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <i class="fas fa-key fa-3x mb-3"></i>
                <h2>MARINE TRADERS</h2>
                <p>Create New Password</p>
                <span class="admin-badge">
                    <i class="fas fa-lock"></i> Secure Reset
                </span>
            </div>
            
            <div class="login-body">
                <form method="POST" action="reset_password.php" id="resetPasswordForm">
                    <div class="mb-3">
                        <label for="new_password" class="form-label">
                            <i class="fas fa-lock me-2"></i>New Password
                        </label>
                        <div class="input-icon">
                            <i class="fas fa-key"></i>
                            <input type="password" class="form-control" name="new_password" id="new_password" required placeholder="Enter new password" style="padding-right: 40px;">
                            <i class="fas fa-eye-slash password-toggle-icon" id="toggleNewPwd" onclick="togglePasswordVisibility('new_password', 'toggleNewPwd')"></i>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="confirm_password" class="form-label">
                            <i class="fas fa-check-circle me-2"></i>Confirm Password
                        </label>
                        <div class="input-icon">
                            <i class="fas fa-check-double"></i>
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" required placeholder="Confirm new password" style="padding-right: 40px;">
                            <i class="fas fa-eye-slash password-toggle-icon" id="toggleConfPwd" onclick="togglePasswordVisibility('confirm_password', 'toggleConfPwd')"></i>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-login mb-3">
                        <i class="fas fa-save me-2"></i>Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }

        document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match. Please try again.');
                return;
            }
            
            const submitBtn = e.target.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
        });
    </script>
</body>
</html>
