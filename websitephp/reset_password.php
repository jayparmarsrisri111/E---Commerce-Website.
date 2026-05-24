<?php
session_start();
include("configpage.php");

if(!isset($_SESSION['reset_email'])){
    header("location: login.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $npass = $_POST['new_password'];
    $cpass = $_POST['confirm_password'];

    if($npass === $cpass){
        $email = $_SESSION['reset_email'];
        // Update password in db
        $hashed_password = password_hash($npass, PASSWORD_DEFAULT);
        $updateQuery = "UPDATE login SET password='$hashed_password', confirmpassword='$hashed_password' WHERE email='$email'";
        if(mysqli_query($mysqli, $updateQuery)){
            // Clear session variables
            unset($_SESSION['reset_email']);
            unset($_SESSION['reset_otp']);
            echo "<link rel=\"stylesheet\" href=\"css/login.css\">";
            echo "<script>alert('Password reset successful. Please login with your new password.'); window.location.href='login.php';</script>";
        } else {
            echo "<link rel=\"stylesheet\" href=\"css/login.css\">";
            echo "<script>alert('Error updating password. Please try again later.');</script>";
        }
    } else {
        echo "<link rel=\"stylesheet\" href=\"css/login.css\">";
        echo "<script>alert('Passwords do not match. Please try again.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reset Password | MARINE TRADERS</title>
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
        <h2 class="form-title">
          Reset Password
        </h2>

        <form method="POST" id="resetPasswordForm" class="mt-4">
          <div class="form-group mb-4">
            <label for="new_password" class="form-label">
              <i class="fas fa-lock"></i>
              New Password
            </label>
            <div class="password-wrapper">
              <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password" required>
              <button type="button" class="password-toggle" onclick="togglePassword('new_password', 'toggleIcon1')">
                <i class="fas fa-eye-slash" id="toggleIcon1"></i>
              </button>
            </div>
          </div>

          <div class="form-group mb-4">
            <label for="confirm_password" class="form-label">
              <i class="fas fa-lock"></i>
              Confirm Password
            </label>
            <div class="password-wrapper">
              <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
              <button type="button" class="password-toggle" onclick="togglePassword('confirm_password', 'toggleIcon2')">
                <i class="fas fa-eye-slash" id="toggleIcon2"></i>
              </button>
            </div>
          </div>

          <button type="submit" name="submit" class="btn btn-submit mt-2">
            <span>Reset Password</span>
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


