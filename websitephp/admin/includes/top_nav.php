<?php
  // Fetch details dynamically for Admin panel
  @session_start();
  if(!isset($mysqli)){ include_once("../configpage.php"); }
  if(!isset($mysqli)){ include_once("configpage.php"); } // Fallback for some pages
  
  $admin_email = isset($_SESSION['email']) ? $_SESSION['email'] : 'admin@marinetraders.com';
  
  $u_q = mysqli_query($mysqli, "SELECT * FROM adminlo WHERE email='$admin_email' AND (firstname != '' OR lastname != '') LIMIT 1");
  $u_firstname = "";
  $u_lastname = "";
  $u_phone = "+91 9712334903";
  if($u_q && mysqli_num_rows($u_q) > 0){
      $u_d = mysqli_fetch_assoc($u_q);
      $u_firstname = isset($u_d['firstname']) ? trim($u_d['firstname']) : "";
      $u_lastname = isset($u_d['lastname']) ? trim($u_d['lastname']) : "";
  }
  
  // If still empty in adminlo, try login table as fallback searching for non-empty names
  if(empty($u_firstname) && empty($u_lastname)){
      $l_q = mysqli_query($mysqli, "SELECT * FROM login WHERE email='$admin_email' AND (firstname != '' OR lastname != '') ORDER BY id DESC LIMIT 1");
      if($l_q && mysqli_num_rows($l_q) > 0){
          $l_d = mysqli_fetch_assoc($l_q);
          $u_firstname = $l_d['firstname'];
          $u_lastname = $l_d['lastname'];
          $u_phone = $l_d['phone'];
      }
  }
  
  // Final fallback if both tables have no name
  if(empty($u_firstname) && empty($u_lastname)){
      $u_firstname = "System";
      $u_lastname = "Admin";
  }
  
  $u_address = "Main Admin Office, Marine Traders, Bhavnagar, Gujarat";
  $a_q = mysqli_query($mysqli, "SELECT address, city, state, pincode FROM orderss WHERE email='$admin_email' ORDER BY id DESC LIMIT 1");
  if($a_q && mysqli_num_rows($a_q) > 0){
      $a_d = mysqli_fetch_assoc($a_q);
      $u_address = htmlspecialchars($a_d['address'] . ", " . $a_d['city'] . ", " . $a_d['state'] . " - " . $a_d['pincode']);
  }
?>
<!-- Top Navigation -->
<?php if(basename($_SERVER['PHP_SELF']) == 'dashboard.php'): ?>
<div class="top-nav">
    <div class="welcome-text">
        <h1>Welcome Back, <?php echo htmlspecialchars($u_firstname . ' ' . $u_lastname); ?>!</h1>
        <p>Here's what's happening with your store today</p>
    </div>

    <div class="user-info dropdown" style="list-style: none;">
        <a class="nav-link dropdown-toggle user-profile-btn" href="#" id="adminNavbarUser" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="display: flex; align-items: center; gap: 10px; text-decoration: none; padding: 5px 15px; border-radius: 30px; background: rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.1); outline: none;">
            <div class="user-avatar-mini" style="width: 32px; height: 32px; background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                <span><?php echo strtoupper(substr($u_firstname, 0, 1)); ?></span>
            </div>
            <span class="user-name-text" style="font-weight: 600; color: #333; margin-right: 5px;"><?php echo htmlspecialchars($u_firstname); ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end profile-menu shadow-lg" aria-labelledby="adminNavbarUser" style="width: 350px; border-radius: 12px; padding: 0; overflow: hidden; border: none; margin-top: 15px; background: #fff;">
            <div class="profile-header" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); padding: 30px 20px 20px; text-align: center; color: white;">
                <div class="profile-avatar-large" style="width: 80px; height: 80px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
                    <span class="user-initial-large" style="font-size: 36px; font-weight: 800; background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?php echo strtoupper(substr($u_firstname, 0, 1)); ?></span>
                </div>
                <h6 class="profile-name" style="font-size: 18px; font-weight: 700; margin-bottom: 5px; color: white;"><?php echo htmlspecialchars($u_firstname . ' ' . $u_lastname); ?></h6>
            </div>
            
            <div class="profile-body" style="padding: 15px 20px; background: #f8fafc; max-height: 480px; overflow-y: auto;">
                <div class="profile-detail-item" style="display: flex; align-items: center; padding: 12px; background: white; border-radius: 10px; margin-bottom: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.02); border: 1px solid #e2e8f0;">
                    <div class="detail-icon" style="width: 35px; height: 35px; background: #e0e7ff; color: #6366f1; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px; margin-right: 15px;"><i class="fas fa-envelope"></i></div>
                    <div class="detail-content" style="flex: 1;">
                        <span class="detail-label" style="display: block; font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase;">Email Address</span>
                        <span class="detail-value" style="font-size: 13px; font-weight: 600; color: #334155; word-break: break-all;"><?php echo htmlspecialchars($admin_email); ?></span>
                    </div>
                </div>

                <div class="profile-detail-item" style="display: flex; align-items: center; padding: 12px; background: white; border-radius: 10px; margin-bottom: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.02); border: 1px solid #e2e8f0;">
                    <div class="detail-icon" style="width: 35px; height: 35px; background: #eff6ff; color: #3b82f6; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px; margin-right: 15px;"><i class="fas fa-phone-alt"></i></div>
                    <div class="detail-content" style="flex: 1;">
                        <span class="detail-label" style="display: block; font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase;">Phone Number</span>
                        <span class="detail-value" style="font-size: 14px; font-weight: 600; color: #334155;"><?php echo htmlspecialchars($u_phone); ?></span>
                    </div>
                </div>

                <div class="profile-detail-item" style="display: flex; align-items: flex-start; padding: 12px; background: white; border-radius: 10px; margin-bottom: 0px; box-shadow: 0 2px 5px rgba(0,0,0,0.02); border: 1px solid #e2e8f0;">
                    <div class="detail-icon" style="width: 35px; height: 35px; background: #eff6ff; color: #3b82f6; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px; margin-right: 15px;"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="detail-content" style="flex: 1;">
                        <span class="detail-label" style="display: block; font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase;">Registered Address</span>
                        <span class="detail-value" style="font-size: 13px; line-height: 1.4; color: #334155; font-weight: 600; display: block; margin-top: 2px;"><?php echo htmlspecialchars($u_address); ?></span>
                    </div>
                </div>
            </div>
            
            <div class="profile-footer" style="padding: 15px; background: white; border-top: 1px solid #e2e8f0; text-align: center;">
                <a class="btn-logout" href="adminlogout.php" style="display: inline-block; width: 100%; padding: 10px; background: #fee2e2; color: #ef4444; border-radius: 8px; text-decoration: none; font-weight: 600; text-transform: uppercase; font-size: 14px; transition: all 0.2s;">
                    <i class="fas fa-sign-out-alt" style="margin-right: 5px;"></i> Log Out
                </a>
            </div>
        </ul>
    </div>
</div>
<?php endif; ?>
