<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!-- Mobile Toggle -->
<button class="mobile-toggle" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <i class="fas fa-anchor fa-2x mb-2"></i>
        <h3>MARINE TRADERS</h3>
        <p>Admin Dashboard</p>
    </div>
    
    <div class="sidebar-menu">
        <a href="dashboard.php" class="menu-item <?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a href="displayform.php" class="menu-item <?php echo $current_page == 'displayform.php' ? 'active' : ''; ?>">
            <i class="fas fa-box"></i>
            <span>Products</span>
        </a>
        <a href="form.php" class="menu-item <?php echo $current_page == 'form.php' ? 'active' : ''; ?>">
            <i class="fas fa-plus-circle"></i>
            <span>Add Product</span>
        </a>
        <a href="orderdisplay.php" class="menu-item <?php echo $current_page == 'orderdisplay.php' ? 'active' : ''; ?>">
            <i class="fas fa-shopping-cart"></i>
            <span>Orders</span>
        </a>
        <a href="users.php" class="menu-item <?php echo ($current_page == 'users.php' || $current_page == 'user_details.php') ? 'active' : ''; ?>">
            <i class="fas fa-users"></i>
            <span>Users</span>
        </a>
        <a href="enquiries.php" class="menu-item <?php echo $current_page == 'enquiries.php' ? 'active' : ''; ?>">
            <i class="fas fa-envelope"></i>
            <span>Enquiry</span>
        </a>
        <a href="contact_messages.php" class="menu-item <?php echo $current_page == 'contact_messages.php' ? 'active' : ''; ?>">
            <i class="fas fa-comments"></i>
            <span>Contact Message</span>
        </a>
        <a href="adminlogout.php" class="menu-item">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
</div>
