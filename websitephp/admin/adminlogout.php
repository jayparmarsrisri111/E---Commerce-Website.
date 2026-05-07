<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - MARINE TRADERS</title>
    <link rel="icon" href="../image/LOGO.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/adminlogout.css">
</head>
<body>
    <div class="logout-container">
        <div class="brand-logo">
            <i class="fas fa-anchor"></i>
        </div>

        <div class="logout-icon">
            <i class="fas fa-check"></i>
        </div>

        <h1>Logged Out Successfully</h1>
        <p>Thank you for using Marine Traders Admin Dashboard. Your session has been securely terminated.</p>

        <div class="redirect-message">
            <i class="fas fa-spinner"></i> Redirecting to login page in <span id="countdown">5</span> seconds...
        </div>

        <div class="btn-container">
            <a href="adminlogin.php" class="btn btn-primary">
                <i class="fas fa-sign-in-alt"></i>
                Login Again
            </a>
            <a href="../HOME PAGE WEBSITE.php" class="btn btn-secondary">
                <i class="fas fa-home"></i>
                Go to Homepage
            </a>
        </div>

        <div class="footer-text">
            <i class="fas fa-shield-alt"></i> Your data is secure with us
        </div>
    </div>

    <script>
        // Countdown timer
        let countdown = 5;
        const countdownElement = document.getElementById('countdown');
        
        const timer = setInterval(function() {
            countdown--;
            countdownElement.textContent = countdown;
            
            if (countdown <= 0) {
                clearInterval(timer);
                window.location.href = 'adminlogin.php'; // Change this to your login page
            }
        }, 1000);

        // Optional: Clear any remaining data
        if (typeof(Storage) !== "undefined") {
            localStorage.clear();
            sessionStorage.clear();
        }
    </script>
</body>
</html>