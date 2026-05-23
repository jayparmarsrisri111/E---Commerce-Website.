<?php
session_start();

if(!isset($_SESSION['admin_pending_email'])){
    header("location: adminlogin.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $entered_otp = $_POST['otp'];
    if($entered_otp == $_SESSION['admin_pending_otp']){
        // OTP is correct, log the admin in
        $_SESSION['email'] = $_SESSION['admin_pending_email'];
        
        // Clear pending session variables
        unset($_SESSION['admin_pending_otp']);
        unset($_SESSION['admin_pending_email']);
        
        // Redirect to dashboard
        header("location: index.php");
        exit();
    } else {
        echo "<style>.error-message { color: red; font-weight: bold; }</style>";
        echo "<script>alert('Invalid OTP. Please try again.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Admin OTP - MARINE TRADERS</title>
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
                <p>Admin OTP Verification</p>
                <span class="admin-badge">
                    <i class="fas fa-lock"></i> Secure Login
                </span>
            </div>
            
            <div class="login-body">
                <p class="text-center text-muted mb-4" style="color: #fff !important;">An OTP has been sent to <?php echo htmlspecialchars($_SESSION['admin_pending_email']); ?></p>

                <form method="POST" id="verifyAdminOtpForm">
                    <div class="mb-3">
                        <label for="otp" class="form-label" style="color: #fff;">
                            <i class="fas fa-key me-2"></i>Enter OTP
                        </label>
                        <div class="input-icon">
                            <i class="fas fa-hashtag"></i>
                            <input type="password" name="otp" id="otp" class="form-control" 
                                   placeholder="Enter 6-digit OTP" required maxlength="6" pattern="\d{6}" style="padding-right: 40px;">
                            <i class="fas fa-eye-slash password-toggle-icon" id="toggleOtp" onclick="togglePasswordVisibility('otp', 'toggleOtp')"></i>
                        </div>
                    </div>

                    <button type="submit" name="submit" class="btn btn-login mt-3">
                        <i class="fas fa-check-circle me-2"></i>Verify & Login
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

        document.getElementById('verifyAdminOtpForm').addEventListener('submit', function(e) {
            const submitBtn = e.target.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Verifying...';
        });
    </script>
</body>
</html>
