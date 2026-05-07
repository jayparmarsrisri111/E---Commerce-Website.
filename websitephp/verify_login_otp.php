<?php
session_start();

if(!isset($_SESSION['pending_login_email'])){
    header("location: login.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $entered_otp = $_POST['otp'];
    if($entered_otp == $_SESSION['pending_login_otp']){
        // OTP is correct, log the user in
        $_SESSION['email'] = $_SESSION['pending_login_email'];
        
        // Clear pending session variables
        unset($_SESSION['pending_login_otp']);
        unset($_SESSION['pending_login_email']);
        
        // Redirect to saved page or home
        if (isset($_SESSION['login_redirect']) && !empty($_SESSION['login_redirect'])) {
            $redirect = $_SESSION['login_redirect'];
            unset($_SESSION['login_redirect']);
            header("location: " . $redirect);
        } else {
            header("location: HOME PAGE WEBSITE.php");
        }
        exit();
    } else {
        echo "<link rel=\"stylesheet\" href=\"css/login.css\">";
        echo "<script>alert('Invalid OTP. Please try again.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Verify Login OTP | MARINE TRADERS</title>
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
          Verify Login OTP
        </h2>
        <p class="text-center text-muted mb-4">An OTP has been sent to <?php echo htmlspecialchars($_SESSION['pending_login_email']); ?></p>

        <form method="POST" class="mt-4" id="verifyOtpForm">
          <div class="form-group mb-4">
            <label for="otp" class="form-label">
              <i class="fas fa-key"></i>
              Enter OTP
            </label>
            <div class="password-wrapper">
              <input type="password" class="form-control" id="otp" name="otp" placeholder="Enter 6-digit OTP" required maxlength="6" pattern="\d{6}">
              <button type="button" class="password-toggle" onclick="togglePassword('otp', 'toggleIcon1')">
                <i class="fas fa-eye-slash" id="toggleIcon1"></i>
              </button>
            </div>
          </div>

          <button type="submit" name="submit" class="btn btn-submit">
            <span>Verify OTP & Login</span>
            <div class="loading"></div>
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<?php include_once('includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword(inputId, iconId) {
  const passwordField = document.getElementById(inputId);
  const toggleIcon = document.getElementById(iconId);

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
