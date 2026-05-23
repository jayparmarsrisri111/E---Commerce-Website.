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
// ─────────────────────────────────────────────────────────────────────────────

// ════════════════════════════════════════════════════════════════════════════
//  ⚙️  CONFIGURATION  — Apni details yahan daalo
// ════════════════════════════════════════════════════════════════════════════
define('GMAIL_USER',  'jayparmar84792@gmail.com');   // ← Apna Gmail
define('GMAIL_PASS',  'bksryvzrymzlcxrm');           // ← Gmail App Password
define('FAST2SMS_KEY','YOUR_FAST2SMS_API_KEY_HERE');  // ← Fast2SMS API key
// ════════════════════════════════════════════════════════════════════════════

// ── Helper: Send SMS via Fast2SMS ────────────────────────────────────────────
function sendSMS($phone, $otp) {
    $key  = FAST2SMS_KEY;
    $url  = "https://www.fast2sms.com/dev/bulkV2";

    $data = [
        'route'         => 'otp',
        'variables_values' => $otp,
        'numbers'       => $phone,
        'flash'         => 0
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'authorization: ' . $key,
        'Content-Type: application/json'
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($response, true);
    return isset($result['return']) && $result['return'] === true;
}
// ─────────────────────────────────────────────────────────────────────────────

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $query = "SELECT * FROM login WHERE email='$email'";
    $result = mysqli_query($mysqli, $query);

    if(mysqli_num_rows($result) > 0){
        $row   = mysqli_fetch_assoc($result);
        $phone = $row['phone'];      // DB se phone number

        // Generate OTP
        $otp = rand(100000, 999999);
        $_SESSION['reset_otp']   = $otp;
        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_phone'] = $phone;

        $emailSent = false;
        $smsSent   = false;
        $emailErr  = '';
        $smsErr    = '';

        // ── 1. Send OTP via Email (PHPMailer Gmail SMTP) ─────────────────────
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
            $mail->Subject = 'Password Reset OTP - MARINE TRADERS';
            $mail->Body    = '
            <div style="font-family:Arial,sans-serif;max-width:520px;margin:auto;
                         border:1px solid #ddd;border-radius:12px;overflow:hidden;">
              <div style="background:#003366;color:#fff;padding:24px;text-align:center;">
                <h2 style="margin:0;letter-spacing:1px;">MARINE TRADERS</h2>
                <p style="margin:6px 0 0;font-size:14px;opacity:.85;">Password Reset Request</p>
              </div>
              <div style="padding:32px;background:#f9f9f9;text-align:center;">
                <p style="font-size:15px;color:#333;">
                  Your <strong>One-Time Password (OTP)</strong> for password reset is:
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
                © 2025 MARINE TRADERS &nbsp;|&nbsp; All rights reserved.
              </div>
            </div>';
            $mail->AltBody = "Your OTP for password reset is: $otp\nValid for 10 minutes. Do not share.";

            $mail->send();
            $emailSent = true;
        } catch (Exception $e) {
            $emailErr = $mail->ErrorInfo;
        }
        // ─────────────────────────────────────────────────────────────────────

        // ── 2. Send OTP via SMS (Fast2SMS) ────────────────────────────────────
        if(!empty($phone) && FAST2SMS_KEY !== 'YOUR_FAST2SMS_API_KEY_HERE'){
            $smsSent = sendSMS($phone, $otp);
            if(!$smsSent) $smsErr = "SMS could not be sent.";
        }
        // ─────────────────────────────────────────────────────────────────────

        // ── Build result message ──────────────────────────────────────────────
        echo "<link rel=\"stylesheet\" href=\"css/login.css\">";

        if($emailSent && $smsSent){
            echo "<script>alert('OTP sent successfully!\\n📧 Email: $email\\n📱 Phone: $phone'); window.location.href='verify_otp.php';</script>";
        } elseif($emailSent){
            echo "<script>alert('OTP sent to your Email: $email\\n(SMS could not be sent)'); window.location.href='verify_otp.php';</script>";
        } elseif($smsSent){
            echo "<script>alert('OTP sent to your Phone: $phone\\n(Email could not be sent)'); window.location.href='verify_otp.php';</script>";
        } else {
            // Both failed — show OTP in alert for localhost debug
            echo "<script>alert('Could not send OTP.\\n\\n[Localhost Debug] Your OTP is: $otp\\n\\nEmail Error: $emailErr'); window.location.href='verify_otp.php';</script>";
        }
        // ─────────────────────────────────────────────────────────────────────

    } else {
        echo "<link rel=\"stylesheet\" href=\"css/login.css\">";
        echo "<script>alert('Email not found in our records.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Forgot Password | MARINE TRADERS</title>
  <link rel="icon" href="image/LOGO.jpg" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="css/login.css" />
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-dark">
  <div class="container justify-content-center">
    <a class="navbar-brand" href="index.php">
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
        <h2 class="form-title">Forgot Password</h2>
        <p class="text-center text-muted mb-4" style="font-size:14px;">
          OTP will be sent to your registered <strong>Email</strong> &amp; <strong>Phone Number</strong>.
        </p>

        <form method="POST" id="forgotPasswordForm">
          <div class="form-group">
            <label for="email" class="form-label">
              <i class="fas fa-envelope"></i>
              Registered Email Address
            </label>
            <input type="email" class="form-control" id="email" name="email"
                   placeholder="Enter your registered email" required>
          </div>

          <button type="submit" name="submit" class="btn btn-submit">
            <span><i class="fas fa-paper-plane me-2"></i>Send OTP</span>
            <div class="loading"></div>
          </button>
        </form>

        <div class="divider">
          <span>OR</span>
        </div>

        <div class="signup-link">
          Remember your password? <a href="login.php">Login here</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<?php include_once('includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'chatbot.php'; ?>
</body>
</html>


