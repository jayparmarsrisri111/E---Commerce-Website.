<?php
session_start();
include("configpage.php");

// ─── PHPMailer ───────────────────────────────────────────────────────────────
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

define('GMAIL_USER',  'jayparmar84792@gmail.com');
define('GMAIL_PASS',  'bksryvzrymzlcxrm');
// ─────────────────────────────────────────────────────────────────────────────

if($_SERVER["REQUEST_METHOD"] == "POST"){
$email=mysqli_real_escape_string($mysqli,$_POST['email']);
$password=mysqli_real_escape_string($mysqli,$_POST['password']);
$query ="SELECT * FROM login WHERE email='$email' AND password='$password'";
$result=mysqli_query($mysqli,$query);
if(mysqli_num_rows($result)>0){
    // Generate OTP
    $otp = rand(100000, 999999);
    $_SESSION['pending_login_otp'] = $otp;
    $_SESSION['pending_login_email'] = $email;
    // Store redirect URL if provided
    if (isset($_GET['redirect']) && !empty($_GET['redirect'])) {
        $_SESSION['login_redirect'] = urldecode($_GET['redirect']);
    } else if (isset($_POST['redirect']) && !empty($_POST['redirect'])) {
        $_SESSION['login_redirect'] = $_POST['redirect'];
    }

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = GMAIL_USER;
        $mail->Password   = GMAIL_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom(GMAIL_USER, 'MARINE TRADERS');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Login OTP - MARINE TRADERS';
        $mail->Body    = '
        <div style="font-family:Arial,sans-serif;max-width:520px;margin:auto;
                     border:1px solid #ddd;border-radius:12px;overflow:hidden;">
          <div style="background:#003366;color:#fff;padding:24px;text-align:center;">
            <h2 style="margin:0;letter-spacing:1px;">MARINE TRADERS</h2>
            <p style="margin:6px 0 0;font-size:14px;opacity:.85;">Login OTP Verification</p>
          </div>
          <div style="padding:32px;background:#f9f9f9;text-align:center;">
            <p style="font-size:15px;color:#333;">
              Your <strong>One-Time Password (OTP)</strong> for logging into your account is:
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
        $mail->AltBody = "Your OTP for login is: $otp\nValid for 10 minutes. Do not share.";

        $mail->send();
        echo "<script>alert('OTP sent to your email successfully!'); window.location.href='verify_login_otp.php';</script>";
        exit();
    } catch (Exception $e) {
        // Fallback for localhost debug if SMTP fails
        $emailErr = addslashes($mail->ErrorInfo);
        echo "<script>alert('Could not send OTP via email.\\n\\n[Localhost Debug] Your OTP is: " . $otp . "\\n\\nEmail Error: " . $emailErr . "'); window.location.href='verify_login_otp.php';</script>";
        exit();
    }
    }else{
        echo "<link rel=\"stylesheet\" href=\"css/login.css\">";
        echo "<script>alert('Invalid email or password. Please try again.');</script>";

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login | MARINE TRADERS</title>
  <link rel="icon" href="image/LOGO.jpg" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="css/login.css" />
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-dark">
  <div class="container justify-content-center">
    <a class="navbar-brand" href="HOME PAGE WEBSITE.php">
      <img src="image/LOGO.jpg" alt="Logo" width="35" height="35" class="me-2">
      MARINE TRADERS
    </a>
  </div>
</nav>

<!-- Main Content -->
<div class="main-content">
  <div class="container">
    <div class="login-container">
      <div class="login-form">
        <h2 class="form-title">
          Login Page
        </h2>

        <form method="POST" id="loginForm">
          <div class="form-group">
            <label for="email" class="form-label">
              <i class="fas fa-envelope"></i>
              Email Address
            </label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
          </div>

          <div class="form-group">
            <label for="password" class="form-label">
              <i class="fas fa-lock"></i>
              Password
            </label>
            <div class="password-wrapper">
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
              <button type="button" class="password-toggle" onclick="togglePassword()">
                <i class="fas fa-eye-slash" id="toggleIcon"></i>
              </button>
            </div>
          </div>

          <button type="submit" name="submit" class="btn btn-submit mb-3">
            <span>Login</span>
            <div class="loading"></div>
          </button>
          
          <div class="form-options text-center" style="display: block; margin-top: 15px;">
            <a href="forgot_password.php" class="forgot-link"><i class="fas fa-lock me-1"></i> Forgot Password?</a>
          </div>
        </form>

        <div class="divider">
          <span>OR</span>
        </div>

        <div class="signup-link">
          Don't have an account? <a href="signup.php">Sign up here</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<?php include_once('includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword() {
  const passwordField = document.getElementById("password");
  const toggleIcon = document.getElementById("toggleIcon");

  if (passwordField.type === "password") {
    passwordField.type = "text";
    toggleIcon.classList.remove("fa-eye-slash");
    toggleIcon.classList.add("fa-eye");
  } else {
    passwordField.type = "password";
    toggleIcon.classList.remove("fa-eye");
    toggleIcon.classList.add("fa-eye-slash");
  }
}
</script>
<?php include 'chatbot.php'; ?>
</body>
</html>
