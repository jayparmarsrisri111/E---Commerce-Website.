<?php
session_start();
include("configpage.php");

// ─── PHPMailer ───────────────────────────────────────────────────────────────
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
require '../PHPMailer/Exception.php';

define('GMAIL_USER',  'jayparmar84792@gmail.com');
define('GMAIL_PASS',  'bksryvzrymzlcxrm');
// ─────────────────────────────────────────────────────────────────────────────

if($_SERVER["REQUEST_METHOD"] == "POST"){
$email=mysqli_real_escape_string($mysqli,$_POST['email']);
$password=mysqli_real_escape_string($mysqli,$_POST['password']);
$query ="SELECT * FROM adminlo WHERE email='$email' AND password='$password'";
$result=mysqli_query($mysqli,$query);
if(mysqli_num_rows($result)==1){
    // Generate OTP
    $otp = rand(100000, 999999);
    $_SESSION['admin_pending_otp'] = $otp;
    $_SESSION['admin_pending_email'] = $email;

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = GMAIL_USER;
        $mail->Password   = GMAIL_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom(GMAIL_USER, 'MARINE TRADERS ADMIN');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Admin Login OTP - MARINE TRADERS';
        $mail->Body    = '
        <div style="font-family:Arial,sans-serif;max-width:520px;margin:auto;
                     border:1px solid #ddd;border-radius:12px;overflow:hidden;">
          <div style="background:#003366;color:#fff;padding:24px;text-align:center;">
            <h2 style="margin:0;letter-spacing:1px;">MARINE TRADERS</h2>
            <p style="margin:6px 0 0;font-size:14px;opacity:.85;">Admin Login OTP Verification</p>
          </div>
          <div style="padding:32px;background:#f9f9f9;text-align:center;">
            <p style="font-size:15px;color:#333;">
              Your <strong>One-Time Password (OTP)</strong> for Admin Access is:
            </p>
            <div style="font-size:40px;font-weight:bold;color:#003366;
                         letter-spacing:10px;margin:22px 0;
                         background:#eef2ff;border-radius:8px;padding:14px 0;">'
                         . $otp . '</div>
            <p style="color:#888;font-size:13px;">
              ⏱ Valid for <strong>10 minutes</strong>.<br>
              🔒 Do <strong>not</strong> share this OTP with anyone.
            </p>
          </div>
          <div style="background:#003366;color:#aaa;padding:10px;text-align:center;font-size:12px;">
            &copy; 2025 MARINE TRADERS &nbsp;|&nbsp; All rights reserved.
          </div>
        </div>';
        $mail->AltBody = "Your OTP for Admin login is: $otp\nValid for 10 minutes. Do not share.";

        $mail->send();
        echo "<script>alert('OTP sent to your email successfully!'); window.location.href='verify_admin_login_otp.php';</script>";
        exit();
    } catch (Exception $e) {
        // Fallback for localhost debug if SMTP fails
        $emailErr = addslashes($mail->ErrorInfo);
        echo "<script>alert('Could not send OTP via email.\\n\\n[Localhost Debug] Your OTP is: " . $otp . "\\n\\nEmail Error: " . $emailErr . "'); window.location.href='verify_admin_login_otp.php';</script>";
        exit();
    }
    }else{
        echo "<style>.error-message { color: red; font-weight: bold; }</style>";
        echo "<script>alert('Invalid email or password. Please try again.');</script>";

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - MARINE TRADERS</title>
    <link rel="icon" href="../image/LOGO.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/adminlogin.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <i class="fas fa-anchor fa-3x mb-3"></i>
                <h2>MARINE TRADERS</h2>
                <p>Admin Panel</p>
                <span class="admin-badge">
                    <i class="fas fa-shield-alt"></i> Administrator Access
                </span>
            </div>
            
            <div class="login-body">
                <form  method="POST" id="adminLoginForm">
                    <div class="mb-3">
                        <label for="adminEmail" class="form-label">
                            <i class="fas fa-envelope me-2"></i>Admin Email Address
                        </label>
                        <div class="input-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" name="email" id="adminEmail" class="form-control" 
                                   placeholder="admin@marinetraders.com" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="adminPassword" class="form-label">
                            <i class="fas fa-lock me-2"></i>Admin Password
                        </label>
                        <div class="input-icon">
                            <i class="fas fa-key"></i>
                            <input type="password" name="password" id="adminPassword" class="form-control" 
                                   placeholder="Enter your admin password" required style="padding-right: 40px;">
                            <i class="fas fa-eye-slash password-toggle-icon" id="toggleAdminPwd" onclick="togglePasswordVisibility('adminPassword', 'toggleAdminPwd')"></i>
                        </div>
                    </div>

                    

                    
                    <button type="submit" name="submit" class="btn btn-login mb-3">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </button>

                    <div class="text-center mt-3 mb-2">
                        <a href="forgot_password.php" class="text-decoration-none" style="color:#003366; font-weight:600; font-size:14px;">
                            <i class="fas fa-lock me-1"></i> Forgot Password?
                        </a>
                    </div>

                    
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

        document.getElementById('adminLoginForm').addEventListener('submit', function(e) {
            // Optional: Show loading state
            const submitBtn = e.target.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Authenticating...';
            // Note: Not calling e.preventDefault() to allow the actual PHP login to proceed
        });
        
        function handleForgotPassword() {
            alert('Forgot password functionality: Please contact the super administrator for password reset.');
        }
        
        function handleSignup() {
            alert('New admin account requests must be approved by the super administrator.');
        }
    </script>
</body>
</html>