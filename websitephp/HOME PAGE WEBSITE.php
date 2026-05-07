<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>MARINE TRADERS | Home</title>
  <link rel="icon" href="image/LOGO.jpg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="css/home-page-website.css?v=<?php echo time(); ?>">
</head>
<body>

<?php include_once('includes/navbar.php'); ?>

<section class="hero">
  <div class="hero-decoration decoration-1"></div>
  <div class="hero-decoration decoration-2"></div>
  <div class="hero-decoration decoration-3"></div>
  <div class="container hero-content">
    <h1 class="display-3 fw-bold">WELCOME TO MARINE TRADERS</h1>
    <p class="lead">Delivering excellence in every service we provide. Your trusted partner for quality solutions.</p>
    <a href="contact us.php" class="btn btn-primary btn-lg">
      <i class="fas fa-envelope me-2"></i>Get in Touch
    </a>
  </div>
</section>

<!-- Slideshow Section -->
<section class="slideshow-section">
  <div class="slideshow-container">
    <!-- Slide 1 -->
    <div class="slide active">
      <img src="image/ship.jpg" alt="Ship">
      <div class="slide-overlay">
        <h2 class="slide-title">Premium Power Solutions</h2>
        <p class="slide-description">High-quality power supply units designed for optimal performance and reliability</p>
      </div>
    </div>

    <!-- Slide 2 -->
    <div class="slide">
      <img src="image/unnamed.jpg" alt="stering wheel">
      <div class="slide-overlay">
        <h2 class="slide-title">Advanced Technology</h2>
        <p class="slide-description">Cutting-edge solutions engineered to meet the highest industry standards</p>
      </div>
    </div>

    <!-- Slide 3 -->
    <div class="slide">
      <img src="image/mac.jpg" alt="Machine">
      <div class="slide-overlay">
        <h2 class="slide-title">Industrial Grade Quality</h2>
        <p class="slide-description">Built to last with superior components and expert craftsmanship</p>
      </div>
    </div>

    <!-- Slide 4 -->
    <div class="slide">
      <img src="image/h8.jpg" alt="Hook">
      <div class="slide-overlay">
        <h2 class="slide-title">Trusted by Industry Leaders</h2>
        <p class="slide-description">Delivering excellence in power solutions since years</p>
      </div>
    </div>

    <!-- Navigation Buttons -->
    <button class="slide-nav slide-prev" onclick="changeSlide(-1)">
      <i class="fas fa-chevron-left"></i>
    </button>
    <button class="slide-nav slide-next" onclick="changeSlide(1)">
      <i class="fas fa-chevron-right"></i>
    </button>

    <!-- Indicators -->
    <div class="slide-indicators">
      <span class="indicator active" onclick="goToSlide(0)"></span>
      <span class="indicator" onclick="goToSlide(1)"></span>
      <span class="indicator" onclick="goToSlide(2)"></span>
      <span class="indicator" onclick="goToSlide(3)"></span>
    </div>
  </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
  <div class="container">
    <div class="row">
      <div class="col-md-3 col-6">
        <div class="stat-item">
          <span class="stat-number">500+</span>
          <span class="stat-label">Projects Completed</span>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="stat-item">
          <span class="stat-number">250+</span>
          <span class="stat-label">Happy Clients</span>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="stat-item">
          <span class="stat-number">10+</span>
          <span class="stat-label">Years Experience</span>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="stat-item">
          <span class="stat-number">24/7</span>
          <span class="stat-label">Support Available</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- About Section -->
<section class="about-section">
  <div class="container text-center">
    <h2 class="section-title">About Us</h2>
    <p class="about-content">
      AAFRIN ENTERPRISE is dedicated to delivering high-quality solutions tailored to your business needs. 
      We combine experience, innovation, and professionalism to provide services that exceed expectations. 
      Our commitment to excellence and customer satisfaction has made us a trusted name in the industry.
    </p>
  </div>
</section>

<!-- Products Section -->
<section class="products-section">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="section-title">Our Products</h2>
      <p class="text-muted mt-3">Explore our range of premium quality products</p>
    </div>
    <div class="row g-4">
      <!-- Product 1 -->
      <div class="col-lg-4 col-md-6">
        <div class="card product-card">
          <div class="product-img-wrapper">
            <img src="image/WIRING.jpg" alt="Power Supply Product 1" class="product-img">
            <div class="product-overlay">
              <a href="product_detail.php?id=8" class="view-btn">
                <i class="fas fa-eye me-2"></i>View Details
              </a>
            </div>
          </div>
        </div>
      </div>
      <!-- Product 2 -->
      <div class="col-lg-4 col-md-6">
        <div class="card product-card">
          <div class="product-img-wrapper">
            <img src="image/P2.jpg" alt="Power Supply Product 2" class="product-img">
            <div class="product-overlay">
              <a href="product_detail.php?id=1" class="view-btn">
                <i class="fas fa-eye me-2"></i>View Details
              </a>
            </div>
          </div>
        </div>
      </div>
      <!-- Product 3 -->
      <div class="col-lg-4 col-md-6">
        <div class="card product-card">
          <div class="product-img-wrapper">
            <img src="image/P3.jpg" alt="Power Supply Product 3" class="product-img">
            <div class="product-overlay">
              <a href="product_detail.php?id=2" class="view-btn">
                <i class="fas fa-eye me-2"></i>View Details
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- CTA Section -->
<section class="cta-section">
  <div class="container">
    <h2>Ready to Get Started?</h2>
    <p>Contact us today and let's discuss how we can help your business grow</p>
    <a href="Enquery form.php" class="btn btn-lg">
      <i class="fas fa-paper-plane me-2"></i>Send Enquiry
    </a>
  </div>
</section>

<!-- Footer -->
<?php include_once('includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Slideshow functionality
  let currentSlide = 0;
  const slides = document.querySelectorAll('.slide');
  const indicators = document.querySelectorAll('.indicator');
  let slideInterval;

  function showSlide(index) {
    if (index >= slides.length) currentSlide = 0;
    if (index < 0) currentSlide = slides.length - 1;
    slides.forEach(slide => slide.classList.remove('active'));
    indicators.forEach(indicator => indicator.classList.remove('active'));
    slides[currentSlide].classList.add('active');
    indicators[currentSlide].classList.add('active');
  }

  function changeSlide(direction) {
    currentSlide += direction;
    showSlide(currentSlide);
    resetInterval();
  }

  function goToSlide(index) {
    currentSlide = index;
    showSlide(currentSlide);
    resetInterval();
  }

  function resetInterval() {
    clearInterval(slideInterval);
    slideInterval = setInterval(() => changeSlide(1), 3000);
  }

  showSlide(currentSlide);
  slideInterval = setInterval(() => changeSlide(1), 3000);
</script>
<?php include 'chatbot.php'; ?>
</body>
</html>
