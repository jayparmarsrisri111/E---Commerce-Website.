<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Logout | MARINE TRADERS</title>
  <link rel="icon" href="image/LOGO.jpg" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="css/logoutmain.css">
</head>
<body>

<!-- Brand Logo at Top -->
<a href="HOME PAGE WEBSITE.php" class="brand-link">
  <img src="image/LOGO.jpg" alt="Logo">
  MARINE TRADERS
</a>

<!-- Logout Container -->
<div class="logout-container">
  <div class="logout-card">
    <div class="logout-icon">
      <i class="fas fa-sign-out-alt"></i>
    </div>
    
    <h2 class="logout-title">Are you sure?</h2>
    <p class="logout-message">
      You are about to logout from your account. You can always log back in anytime.
    </p>

    <div class="btn-group-logout">
<a href="logout.php" class="btn-primary-logout">
  <i class="fas fa-check-circle"></i>
  Yes, Logout
</a>
<a href="HOME PAGE WEBSITE.php" class="btn-secondary-logout">
        <i class="fas fa-arrow-left"></i>
        Cancel
      </a>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'chatbot.php'; ?>
</body>
</html>
