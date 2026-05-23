<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Product Enquiry | MARINE TRADERS</title>
  <link rel="icon" href="image/LOGO.jpg" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="css/enquery-form.css">
  <link rel="stylesheet" href="css/navbar-common.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="css/page-header.css?v=<?php echo time(); ?>">
</head>
<body>
<?php include_once('includes/navbar.php'); ?>

<div class="page-header">
  <div class="container text-center">
    <h1>Enquiry</h1>
    <p>Send your product enquiry and our team will reply within 24 hours.</p>
  </div>
</div>
<!-- Main Content -->
<div class="main-content">
  <div class="container">
    <div class="enquiry-container">
      <div class="enquiry-form">
        <h2 class="form-title">
          <i class="fas fa-paper-plane"></i>
          Product Enquiry Form
        </h2>
        
        <div class="info-box">
          <i class="fas fa-info-circle"></i>
          <strong>Need help?</strong> Fill out the form below and our team will get back to you within 24 hours.
        </div>

        <form action="enqueryinsert.php" method="POST" id="enquiryForm">
          <div class="form-group">
            <label for="name" class="form-label">
              <i class="fas fa-user"></i>
              Full Name *
            </label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
          </div>

          <div class="form-group">
            <label for="email" class="form-label">
              <i class="fas fa-envelope"></i>
              Email Address *
            </label>
            <input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" required>
          </div>

          <div class="form-group">
            <label for="phone" class="form-label">
              <i class="fas fa-phone"></i>
              Phone Number
            </label>
            <input type="tel" class="form-control" id="phone" name="phone" placeholder="e.g. +91 9876543210" pattern="[0-9+\s\-()]*">
          </div>

          <div class="form-group">
            <label for="product" class="form-label">
              <i class="fas fa-box-open"></i>
              Product Interested In *
            </label>
            <input type="text" class="form-control" id="product" name="product" placeholder="Enter product name or code" required>
          </div>

          <div class="form-group">
            <label for="message" class="form-label">
              <i class="fas fa-comment-dots"></i>
              Your Message / Enquiry
            </label>
            <textarea class="form-control" id="message" name="message" rows="4" placeholder="Describe your requirements, quantity needed, or any specific questions..."></textarea>
          </div>

          <button type="submit" name="submit" class="btn btn-submit">
            <span>Submit Enquiry</span>
            <i class="fas fa-arrow-right"></i>
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

<?php include 'chatbot.php'; ?>
</body>
</html>
