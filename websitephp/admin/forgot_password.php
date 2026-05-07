<?php
session_start();
include("configpage.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
require '../PHPMailer/Exception.php';

define('GMAIL_USER',  'jayparmar84792@gmail.com');
define('GMAIL_PASS',  'bksryvzrymzlcxrm');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    
    // Check if email exists in adminlo table
    $query = "SELECT * FROM adminlo WHERE email='$email'";
    $result = mysqli_query($mysqli, $query);
    
    if (mysqli_num_rows($result) > 0) {
        // Generate OTP
        $otp = rand(100000, 999999);
        $_SESSION['admin_reset_otp'] = $otp;
        $_SESSION['admin_reset_email'] = $email;

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
            $mail->Subject = 'Admin Password Reset OTP - MARINE TRADERS';
            $mail->Body    = '
            <div style="font-family:Arial,sans-serif;max-width:520px;margin:auto;
                         border:1px solid #ddd;border-radius:12px;overflow:hidden;">
              <div style="background:#dc3545;color:#fff;padding:24px;text-align:center;">
                <h2 style="margin:0;letter-spacing:1px;">MARINE TRADERS</h2>
                <p style="margin:6px 0 0;font-size:14px;opacity:.85;">Admin Password Reset</p>
              </div>
              <div style="padding:32px;background:#f9f9f9;text-align:center;">
                <p style="font-size:15px;color:#333;">
                  Your <strong>One-Time Password (OTP)</strong> for Password Reset is:
                </p>
                <div style="font-size:40px;font-weight:bold;color:#dc3545;
                             letter-spacing:10px;margin:22px 0;
                             background:#ffeeff;border-radius:8px;padding:14px 0;">'
                             . $otp . '</div>
                <p style="color:#888;font-size:13px;">
                  ⏱ Valid for <strong>10 minutes</strong>.<br>
                  🔒 Do <strong>not</strong> share this OTP with anyone.
                </p>
              </div>
              <div style="background:#333;color:#aaa;padding:10px;text-align:center;font-size:12px;">
                &copy; 2025 MARINE TRADERS &nbsp;|&nbsp; All rights reserved.
              </div>
            </div>';
            $mail->AltBody = "Your OTP for Admin password reset is: $otp\nValid for 10 minutes. Do not share.";

            $mail->send();
            echo "<script>alert('OTP sent to your email successfully!'); window.location.href='verify_forgot_otp.php';</script>";
            exit();
        } catch (Exception $e) {
            $emailErr = addslashes($mail->ErrorInfo);
            echo "<script>alert('Could not send OTP via email.\\n\\n[Localhost Debug] Your OTP is: " . $otp . "\\n\\nEmail Error: " . $emailErr . "'); window.location.href='verify_forgot_otp.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Email not found in admin records. Please check and try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Forgot Password - MARINE TRADERS</title>
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
                <p>Forgot Password</p>
                <span class="admin-badge">
                    <i class="fas fa-key"></i> Account Recovery
                </span>
            </div>
            
            <div class="login-body">
                <form method="POST" action="forgot_password.php" id="forgotPasswordForm">
                    <div class="mb-4">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2"></i>Enter Registered Admin Email
                        </label>
                        <div class="input-icon">
                            <i class="fas fa-envelope"></i>
                            <input type="email" class="form-control" name="email" id="email" required placeholder="admin@marinetraders.com">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-login mb-4">
                        <i class="fas fa-paper-plane me-2"></i>Send OTP
                    </button>
                    
                    <div class="text-center mt-3">
                        <a href="adminlogin.php" class="text-decoration-none" style="color:var(--dark-color); font-weight:600; font-size:14px; transition: color 0.3s;" onmouseover="this.style.color='#667eea'" onmouseout="this.style.color='var(--dark-color)'">
                            <i class="fas fa-arrow-left me-1"></i> Back to Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
            const submitBtn = e.target.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending OTP...';
        });
    </script>
</body>
</html>
