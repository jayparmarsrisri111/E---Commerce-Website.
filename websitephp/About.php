<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us | MARINE TRADERS</title>
  <link rel="icon" href="image/LOGO.jpg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="css/about.css?v=<?php echo time(); ?>">
</head>
<body>

<?php include_once('includes/navbar.php'); ?>

<div class="container pb-5">
  <div class="page-title">
    <h1>ABOUT US</h1>
  </div>

  <div class="row mb-5">
    <div class="col-lg-6 mb-4">
      <img src="image/LOGO.jpg" height="700px" alt="Company Image" class="company-image">
    </div>
    <div class="col-lg-6">
      <div class="styled-card">
        <div class="about-text">
          <p><strong>MARINE TRADERS</strong> is dedicated to delivering innovative solutions that empower businesses and individuals. Since our founding, we have remained focused on providing high-quality products and exceptional customer service.</p>
          
          <p>We envision a world where innovation drives meaningful change, empowering individuals and organizations to reach their full potential.</p>
          
          <p>Our primary goal is to achieve sustainable growth by consistently delivering exceptional value to our customers, employees, and stakeholders.</p>
          
          <p>Our mission is to deliver high-quality, innovative solutions that solve real-world problems and create lasting value for our customers.</p>
          
          <p>Our journey began with a mission to create products that inspire and meet customer needs. From concept to final product, we ensure quality and attention to detail.</p>
          
          <p>Our core values—<strong>Integrity, Innovation, and Customer-Centricity</strong>—guide our work. We believe that our clients' success is our success.</p>
          
          <p><em>Thank you for choosing MARINE TRADERS. We are honored to serve you.</em></p>
        </div>
      </div>
    </div>
  </div>

  <div class="row text-center mb-5">
    <div class="col-lg-4 mb-4">
      <div class="vmg-card">
        <h2>VISION</h2>
        <p>We envision a world where innovation drives meaningful change and empowers organizations to achieve their full potential.</p>
      </div>
    </div>
    <div class="col-lg-4 mb-4">
      <div class="vmg-card">
        <h2>MISSION</h2>
        <p>Our mission is to deliver innovative solutions, build strong relationships, and foster a culture of integrity and excellence.</p>
      </div>
    </div>
    <div class="col-lg-4 mb-4">
      <div class="vmg-card">
        <h2>GOAL</h2>
        <p>Our goal is to achieve sustainable growth by providing exceptional value and maintaining a commitment to quality and ethics.</p>
      </div>
    </div>
  </div>

  <h2 class="team-title">OUR TEAM</h2>

  <div class="row text-center">
    <div class="col-lg-3 col-md-6 mb-4">
      <div class="team-card" data-bs-toggle="modal" data-bs-target="#rohanModal" style="cursor: pointer;">
        <img src="image/ROHAN.jpeg" alt="ROHAN" class="team-img">
        <h4>ROHAN</h4>
        <p>CEO</p>
        <div class="team-progress">
          <div class="team-progress-fill" style="width: 90%"></div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
      <div class="team-card" data-bs-toggle="modal" data-bs-target="#jayModal" style="cursor: pointer;">
        <img src="image/Anas.jpg" alt="JAY" class="team-img">
        <h4>JAY</h4>
        <p>CO-CEO</p>
        <div class="team-progress">
          <div class="team-progress-fill" style="width: 80%"></div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
      <div class="team-card" data-bs-toggle="modal" data-bs-target="#anasModal" style="cursor: pointer;">
        <img src="image/JAY.jpeg" alt="ANAS" class="team-img">
        <h4>ANAS</h4>
        <p>MANAGER</p>
        <div class="team-progress">
          <div class="team-progress-fill" style="width: 70%"></div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
      <div class="team-card" data-bs-toggle="modal" data-bs-target="#jilayModal" style="cursor: pointer;">
        <img src="image/Asad.jpg" alt="JILAY" class="team-img">
        <h4>JILAY</h4>
        <p>HR</p>
        <div class="team-progress">
          <div class="team-progress-fill" style="width: 60%"></div>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- Team Modals -->
<!-- Rohan Modal -->
<div class="modal fade" id="rohanModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ROHAN - CEO</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img src="image/ROHAN.jpeg" alt="ROHAN" class="img-fluid rounded mb-3" style="max-height: 250px;">
        <p><strong>Role:</strong> CEO</p>
        <p>Rohan is the visionary behind MARINE TRADERS. With years of experience in the maritime industry, he steers the company towards growth and excellence.</p>
        <p><strong>Email:</strong> rohannawani@marinetraders.com</p>
        <p><strong>Phone:</strong> +91 9876543210</p>
      </div>
    </div>
  </div>
</div>

<!-- Jay Modal -->
<div class="modal fade" id="jayModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">JAY - CO-CEO</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img src="image/Anas.jpg" alt="JAY" class="img-fluid rounded mb-3" style="max-height: 250px;">
        <p><strong>Role:</strong> CO-CEO</p>
        <p>Jay co-leads MARINE TRADERS with a focus on operations and strategy. His expertise ensures that the company delivers on its promises efficiently.</p>
        <p><strong>Email:</strong> jayparmar@marinetraders.com</p>
        <p><strong>Phone:</strong> +91 9714611331</p>
      </div>
    </div>
  </div>
</div>

<!-- Anas Modal -->
<div class="modal fade" id="anasModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ANAS - MANAGER</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img src="image/JAY.jpeg" alt="ANAS" class="img-fluid rounded mb-3" style="max-height: 250px;">
        <p><strong>Role:</strong> MANAGER</p>
        <p>Anas manages the day-to-day activities, ensuring smooth operations and excellent team coordination across all departments.</p>
        <p><strong>Email:</strong> anassorthiya@marinetraders.com</p>
        <p><strong>Phone:</strong> +91 9876543212</p>
      </div>
    </div>
  </div>
</div>

<!-- Jilay Modal -->
<div class="modal fade" id="jilayModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">JILAY - HR</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img src="image/Asad.jpg" alt="JILAY" class="img-fluid rounded mb-3" style="max-height: 250px;">
        <p><strong>Role:</strong> HR</p>
        <p>Jilay handles Human Resources, focusing on employee well-being, recruitment, and maintaining a positive company culture.</p>
        <p><strong>Email:</strong> jilaygajjar@marinetraders.com</p>
        <p><strong>Phone:</strong> +91 9876543213</p>
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
