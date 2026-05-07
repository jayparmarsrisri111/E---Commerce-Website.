<?php
// Fix adminlogin.php
$admin_file = 'd:/XAMPP/htdocs/Jay Parmar Project Backup/websitephp/admin/adminlogin.php';
$admin_content = file_get_contents($admin_file);

$admin_old = '<div class="mb-3 text-end">
                            <a href="forgot_password.php" class="text-decoration-none" style="color:#003366; font-weight:600; font-size:14px;">Forgot Password?</a>
                        </div>
                        <button type="submit" class="btn btn-login mb-4">Login</button>';

$admin_new = '<button type="submit" class="btn btn-login mb-3">Login</button>
                        <div class="text-center mb-4">
                            <a href="forgot_password.php" class="text-decoration-none" style="color:#003366; font-weight:600; font-size:14px;"><i class="fas fa-lock me-1"></i> Forgot Password?</a>
                        </div>';

$admin_content = str_replace($admin_old, $admin_new, $admin_content);
file_put_contents($admin_file, $admin_content);

// Fix login.php
$login_file = 'd:/XAMPP/htdocs/Jay Parmar Project Backup/websitephp/login.php';
$login_content = file_get_contents($login_file);

// Replace form-options placement
$login_old_block = '          <div class="form-options">
            <a href="forgot_password.php" class="forgot-link">Forgot Password?</a>
          </div>

          <button type="submit" name="submit" class="btn btn-submit">
            <span>Login</span>
            <div class="loading"></div>
          </button>';

$login_new_block = '          <button type="submit" name="submit" class="btn btn-submit mb-3">
            <span>Login</span>
            <div class="loading"></div>
          </button>
          
          <div class="form-options text-center" style="display: block; margin-top: 15px;">
            <a href="forgot_password.php" class="forgot-link"><i class="fas fa-lock me-1"></i> Forgot Password?</a>
          </div>';

$login_content = str_replace($login_old_block, $login_new_block, $login_content);
// Also try replacing with \r\n
$login_old_block_rn = str_replace("\n", "\r\n", $login_old_block);
$login_content = str_replace($login_old_block_rn, $login_new_block, $login_content);

file_put_contents($login_file, $login_content);

echo "Done";
?>
