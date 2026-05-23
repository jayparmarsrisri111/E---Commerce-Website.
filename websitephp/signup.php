<?php
session_start();
include("configpage.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign Up | MARINE TRADERS</title>
  <link rel="icon" href="image/LOGO.jpg" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="css/signup.css">
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
    <div class="signup-container">
      <div class="signup-form">
        <h2 class="form-title">
          <i class="fas fa-user-plus"></i>
          Create Account
        </h2>

        <form action="sginupinsert.php" method="POST" id="signupForm">
          <div class="row-custom">
            <div class="form-group">
              <label for="firstName" class="form-label">
                <i class="fas fa-user"></i>
                First Name
              </label>
              <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter first name" required>
            </div>

            <div class="form-group">
              <label for="lastName" class="form-label">
                <i class="fas fa-user"></i>
                Last Name
              </label>
              <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter last name" required>
            </div>
          </div>

          <div class="form-group">
            <label for="email" class="form-label">
              <i class="fas fa-envelope"></i>
              Email Address
            </label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
          </div>

          <div class="form-group">
            <label for="phone" class="form-label">
              <i class="fas fa-phone"></i>
              Phone Number
            </label>
            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required>
          </div>

          <div class="form-group">
            <label for="password" class="form-label">
              <i class="fas fa-lock"></i>
              Password
            </label>
            <div class="password-wrapper">
              <input type="password" class="form-control" id="password" name="password" placeholder="Create password" required>
              <button type="button" class="password-toggle" onclick="togglePassword('password', 'toggleIcon1')">
                <i class="fas fa-eye-slash" id="toggleIcon1"></i>
              </button>
            </div>
          </div>

          <div class="form-group">
            <label for="confirmPassword" class="form-label">
              <i class="fas fa-lock"></i>
              Confirm Password
            </label>
            <div class="password-wrapper">
              <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Re-enter password" required>
              <button type="button" class="password-toggle" onclick="togglePassword('confirmpassword', 'toggleIcon2')">
                <i class="fas fa-eye-slash" id="toggleIcon2"></i>
              </button>
            </div>
          </div>

          <button type="submit" name="submit" class="btn btn-submit">
            <span>Create Account</span>
            <i class="fas fa-arrow-right"></i>
            <div class="loading"></div>
          </button>
        </form>

        <div class="divider">
          <span>OR</span>
        </div>

        <div class="login-link">
          <i class="fas fa-user-check"></i> Already have an account? <a href="login.php">Login here</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<?php include_once('includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (input.type === "password") {
      input.type = "text";
      icon.classList.remove("fa-eye-slash");
      icon.classList.add("fa-eye");
    } else {
      input.type = "password";
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
    }
  }
</script>
<?php include 'chatbot.php'; ?>
</body>
</html>
