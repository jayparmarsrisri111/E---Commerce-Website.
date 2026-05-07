<?php
  $current_page = basename($_SERVER['PHP_SELF']);
?>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark" id="mainNav">
  <div class="container">
    <a class="navbar-brand" href="HOME PAGE WEBSITE.php">
      <img src="image/LOGO.jpg" alt="Logo" width="35" height="35" class="me-2">
      MARINE TRADERS
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link <?php echo $current_page == 'HOME PAGE WEBSITE.php' ? 'active' : ''; ?>" href="HOME PAGE WEBSITE.php"><i class="fas fa-home"></i> Home</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $current_page == 'About.php' ? 'active' : ''; ?>" href="About.php"><i class="fas fa-info-circle"></i> About</a></li>
        <li class="nav-item"><a class="nav-link <?php echo ($current_page == 'pr.php' || $current_page == 'product_detail.php') ? 'active' : ''; ?>" href="pr.php"><i class="fas fa-box"></i> Products</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $current_page == 'Enquery form.php' ? 'active' : ''; ?>" href="Enquery form.php"><i class="fas fa-envelope"></i> Enquiry</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $current_page == 'contact us.php' ? 'active' : ''; ?>" href="contact us.php"><i class="fas fa-phone"></i> Contact</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $current_page == 'orderpage.php' ? 'active' : ''; ?>" href="orderpage.php"><i class="fas fa-shopping-cart"></i> Order Page</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $current_page == 'orders.php' ? 'active' : ''; ?>" href="orders.php"><i class="fas fa-history"></i> Order History</a></li>
<?php if(isset($_SESSION['email'])): ?>
<?php
  if(!isset($mysqli)){ include_once("configpage.php"); }
  $email = $_SESSION['email'];
  $user_q = mysqli_query($mysqli, "SELECT * FROM login WHERE email='$email' LIMIT 1");
  $user_d = mysqli_fetch_assoc($user_q);
  
  $d_firstname = $user_d['firstname'];
  $d_lastname = $user_d['lastname'];
  $d_phone = $user_d['phone'];
  
  $address = "Not Provided Yet";
  $addr_q = mysqli_query($mysqli, "SELECT * FROM orderss WHERE email='$email' ORDER BY id DESC");
  
  if(mysqli_num_rows($addr_q) > 0){
    $addr_d = mysqli_fetch_assoc($addr_q);
    $address = htmlspecialchars($addr_d['address'] . ", " . $addr_d['city'] . ", " . $addr_d['state'] . " - " . $addr_d['pincode']);
    
    // Fallback for old users
    if(empty(trim($d_firstname))) {
        $d_firstname = !empty($addr_d['firstname']) ? $addr_d['firstname'] : '';
        $d_lastname = !empty($addr_d['lastname']) ? $addr_d['lastname'] : '';
        $d_phone = !empty($addr_d['phone']) ? $addr_d['phone'] : '';
    }
  }
  
  $firstname = !empty(trim($d_firstname)) ? $d_firstname : "User";
  $lastname = !empty(trim($d_lastname)) ? $d_lastname : "";
  $phone = !empty(trim($d_phone)) ? $d_phone : "Not Provided";
?>
<li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle user-profile-btn" href="#" id="navbarUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    <div class="user-avatar-mini">
        <span class="user-initial"><?php echo strtoupper(substr($firstname, 0, 1)); ?></span>
    </div>
    <span class="user-name-text"><?php echo htmlspecialchars($firstname); ?></span>
  </a>
  <ul class="dropdown-menu dropdown-menu-end profile-menu shadow-lg" aria-labelledby="navbarUser" style="width: 350px;">
    <div class="profile-header">
      <div class="profile-avatar-large">
        <span class="user-initial-large"><?php echo strtoupper(substr($firstname, 0, 1)); ?></span>
      </div>
      <h6 class="profile-name"><?php echo htmlspecialchars(trim($firstname . ' ' . $lastname)); ?></h6>
    </div>
    
    <div class="profile-body" style="max-height: 480px; overflow-y: auto;">
      <div class="profile-detail-item">
        <div class="detail-icon" style="color: #6366f1; background: #e0e7ff;"><i class="fas fa-envelope"></i></div>
        <div class="detail-content w-100">
          <span class="detail-label">Email Address</span>
          <span class="detail-value" style="font-size: 13px; word-break: break-all;"><?php echo htmlspecialchars($email); ?></span>
        </div>
      </div>
      <div class="profile-detail-item">
        <div class="detail-icon"><i class="fas fa-phone-alt"></i></div>
        <div class="detail-content">
          <span class="detail-label">Phone Number</span>
          <span class="detail-value"><?php echo htmlspecialchars($phone); ?></span>
        </div>
      </div>

      <div class="profile-detail-item">
        <div class="detail-icon"><i class="fas fa-map-marker-alt"></i></div>
        <div class="detail-content w-100">
          <span class="detail-label">Last Known Address</span>
          <span class="detail-value" style="font-size: 13px; line-height: 1.4; word-wrap: break-word;"><?php echo $address; ?></span>
        </div>
      </div>
    </div>
    
    <div class="profile-footer">
      <a class="btn-logout" href="logoutmain.php">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
    </div>
  </ul>
</li>
<?php else: ?>
  <li class="nav-item"><a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
<?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
