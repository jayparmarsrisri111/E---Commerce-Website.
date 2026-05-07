<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us | MARINE TRADERS</title>
  <link rel="icon" href="image/LOGO.jpg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="css/contact-us.css">
</head>
<body>
<?php include_once('includes/navbar.php'); ?>

<!-- Main Content -->
<div class="main-content">
  <div class="container contact-container">
    <div class="contact-wrapper">
      
      <!-- Contact Info Card -->
      <div class="contact-info-card">
        <h2>Get In Touch</h2>
        <p>We'd love to hear from you! Reach out to us through any of these channels and we'll respond as soon as possible.</p>
        
        <div class="contact-item">
          <div class="contact-icon">
            <i class="fas fa-map-marker-alt"></i>
          </div>
          <div class="contact-details">
            <h4>Our Location</h4>
            <p>Alang SBY,North Side Road,Gujarat,India</p>
          </div>
        </div>

        <div class="contact-item">
          <div class="contact-icon">
            <i class="fas fa-phone-alt"></i>
          </div>
          <div class="contact-details">
            <h4>Phone Number</h4>
            <p>+91 9712334903</p>
          </div>
        </div>

        <div class="contact-item">
          <div class="contact-icon">
            <i class="fas fa-envelope"></i>
          </div>
          <div class="contact-details">
            <h4>Email Address</h4>
            <p>info@marine.com</p>
          </div>
        </div>

        <div class="contact-item">
          <div class="contact-icon">
            <i class="fas fa-clock"></i>
          </div>
          <div class="contact-details">
            <h4>Business Hours</h4>
            <p>Mon - Sat: 9:00 AM - 6:00 PM</p>
          </div>
        </div>
      </div>

      <!-- Contact Form Card -->
      <div class="contact-form-card">
        <h2 class="form-title">
          <i class="fas fa-paper-plane"></i>
          Send Us a Message
        </h2>
        
        <!-- Form now submits to backend processor -->
        <form action="contactinsert.php" method="POST" id="contactForm">
          <div class="form-group">
            <label for="name" class="form-label">
              <i class="fas fa-user"></i>
              Full Name *
            </label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Enter your full name" required>
          </div>

          <div class="form-group">
            <label for="mono" class="form-label">
              <i class="fas fa-mobile-alt"></i>
              Mobile Number *
            </label>
            <input type="tel" id="mono" name="mono" class="form-control" placeholder="e.g. 9876543210" pattern="[0-9]{10}" maxlength="10" required>
          </div>

          <div class="form-group">
            <label for="email" class="form-label">
              <i class="fas fa-envelope"></i>
              Email Address *
            </label>
            <input type="email" id="email" name="email" class="form-control" placeholder="example@domain.com" required>
          </div>

          <div class="button-group">
            <button type="reset" class="btn btn-reset">
             <i class="fas fa-redo"></i> Reset  
            </button>
            <button type="submit" class="btn btn-submit">
               <span>Submit Mesaaage</span>
            <i class="fas fa-arrow-right"></i>
            </button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<!-- Footer -->
<?php include_once('includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Form validation and smooth animations
  document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault(); 
    
    const form = this;
    const btn = this.querySelector('.btn-submit');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
    btn.disabled = true;
    
    setTimeout(() => {
      btn.innerHTML = '<i class="fas fa-check"></i> Ready';
      form.submit();
    }, 800);
  });

  // Add smooth scroll
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({ behavior: 'smooth' });
      }
    });
  });
</script>
<?php include 'chatbot.php'; ?>
</body>
</html>





