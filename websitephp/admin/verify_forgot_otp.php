<?php
session_start();

if (!isset($_SESSION['admin_reset_email']) || !isset($_SESSION['admin_reset_otp'])) {
    header("Location: forgot_password.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];
    
    if ($entered_otp == $_SESSION['admin_reset_otp']) {
        // OTP verified
        $_SESSION['admin_otp_verified'] = true;
        echo "<script>alert('OTP Verified Successfully!'); window.location.href='reset_password.php';</script>";
        exit();
    } else {
        echo "<script>alert('Invalid OTP. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP - MARINE TRADERS</title>
    <link rel="icon" href="../image/LOGO.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/adminlogin.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <i class="fas fa-shield-alt fa-3x mb-3"></i>
                <h2>MARINE TRADERS</h2>
                <p>Verify Admin OTP</p>
                <span class="admin-badge">
                    <i class="fas fa-check-circle"></i> Secure Verification
                </span>
            </div>
            
            <div class="login-body">
                <div class="text-center mb-4">
                    <p class="text-muted" style="font-size: 14px; margin-bottom: 5px;">An OTP has been sent to</p>
                    <strong style="color: #667eea; font-size: 15px;"><?php echo htmlspecialchars($_SESSION['admin_reset_email']); ?></strong>
                </div>

                <form method="POST" action="verify_forgot_otp.php" id="verifyOtpForm">
                    <div class="mb-4">
                        <label for="otp" class="form-label">
                            <i class="fas fa-key me-2"></i>Enter 6-digit OTP
                        </label>
                        <div class="input-icon">
                            <i class="fas fa-hashtag"></i>
                            <input type="password" class="form-control text-center" style="letter-spacing: 5px; font-weight: bold; font-size: 18px; padding-right: 40px;" name="otp" id="otp" required maxlength="6" pattern="\d{6}" placeholder="------">
                            <i class="fas fa-eye-slash password-toggle-icon" id="toggleOtp" onclick="togglePasswordVisibility('otp', 'toggleOtp')"></i>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-login mb-4">
                        <i class="fas fa-check-circle me-2"></i>Verify OTP
                    </button>
                    
                    <div class="text-center mt-3">
                        <a href="forgot_password.php" class="text-decoration-none text-danger" style="font-weight:600; font-size:14px; transition: opacity 0.3s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                            <i class="fas fa-times-circle me-1"></i> Cancel
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

        document.getElementById('verifyOtpForm').addEventListener('submit', function(e) {
            const submitBtn = e.target.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Verifying...';
        });
    </script>
</body>
</html>
