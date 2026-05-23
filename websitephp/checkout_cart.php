<?php
session_start();
include_once("configpage.php");
include_once("cart_functions.php");

// ── Login check ──
if (!isset($_SESSION['email'])) {
    header("Location: login.php?redirect=checkout_cart.php");
    exit();
}

$email = mysqli_real_escape_string($mysqli, $_SESSION['email']);

// Fetch user info for pre-filling
$user_q = mysqli_query($mysqli, "SELECT * FROM login WHERE email='$email' LIMIT 1");
$user_data = mysqli_fetch_assoc($user_q);

$u_firstname = htmlspecialchars($user_data['firstname'] ?? '');
$u_lastname  = htmlspecialchars($user_data['lastname']  ?? '');
$u_phone     = htmlspecialchars($user_data['phone']     ?? '');

// Fetch cart items
$cart_items = [];
$total_amount = 0;
$query = "SELECT c.*, p.title, p.img, p.saleprice, p.category, p.stock FROM cart c JOIN product p ON c.product_id = p.id WHERE c.email = '$email' ORDER BY c.id DESC";
$result = mysqli_query($mysqli, $query);

while ($row = mysqli_fetch_assoc($result)) {
    // Available stock check
    $ptitle = $row['title'];
    $stock_q = mysqli_query($mysqli, "SELECT SUM(qunatity) AS total FROM orderss WHERE productname='$ptitle'");
    $ordered_stock = mysqli_fetch_assoc($stock_q)['total'] ?? 0;
    $available_stock = $row['stock'] - $ordered_stock;
    
    if ($row['quantity'] > $available_stock) {
        $row['quantity'] = $available_stock > 0 ? $available_stock : 0;
    }
    
    if ($row['quantity'] > 0) {
        $cart_items[] = $row;
        $total_amount += $row['saleprice'] * $row['quantity'];
    }
}

// Redirect back to cart if it's empty
if (empty($cart_items)) {
    $_SESSION['cart_error'] = "Please add items to your cart before proceeding to checkout.";
    header("Location: cart.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="image/LOGO.jpg">
  <title>Checkout Cart | MARINE TRADERS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="css/pr.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="css/cart.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="css/navbar-common.css?v=<?php echo time(); ?>">
</head>
<body>
  <!-- Navigation -->
  <?php include_once('includes/navbar.php'); ?>

  <!-- Page Header -->
  <div class="page-header">
    <div class="container text-center">
      <h1><i class="fas fa-shopping-cart me-3"></i>Complete Your Order</h1>
      <p>Fill in your details below to place orders for all cart items</p>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="container">
      
      <div class="checkout-container">
        <h2 class="checkout-title"><i class="fas fa-shipping-fast"></i>Secure Checkout</h2>
        
        <form action="checkout_cart_insert.php" method="POST">
          <div class="checkout-grid">
            
            <!-- Left Panel: Delivery Information -->
            <div>
              <div class="checkout-section-title">
                <i class="fas fa-user-circle text-primary"></i> Personal Details
              </div>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group-custom">
                    <label class="form-label-custom">First Name *</label>
                    <input type="text" class="form-control-custom" name="firstname" value="<?php echo $u_firstname; ?>" required placeholder="Enter first name">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group-custom">
                    <label class="form-label-custom">Last Name *</label>
                    <input type="text" class="form-control-custom" name="lastname" value="<?php echo $u_lastname; ?>" required placeholder="Enter last name">
                  </div>
                </div>
              </div>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group-custom">
                    <label class="form-label-custom">Email Address *</label>
                    <input type="email" class="form-control-custom" name="email" value="<?php echo htmlspecialchars($email); ?>" required readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group-custom">
                    <label class="form-label-custom">Phone Number *</label>
                    <input type="tel" class="form-control-custom" name="phone" value="<?php echo $u_phone; ?>" required placeholder="Enter phone number">
                  </div>
                </div>
              </div>

              <div class="checkout-section-title mt-4">
                <i class="fas fa-map-marker-alt text-primary"></i> Shipping Address
              </div>
              
              <div class="form-group-custom">
                <label class="form-label-custom">Street Address *</label>
                <input type="text" class="form-control-custom" name="address" required placeholder="Apartment, suite, unit, building, street, etc.">
              </div>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group-custom">
                    <label class="form-label-custom">City *</label>
                    <input type="text" class="form-control-custom" name="city" required placeholder="Enter city">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group-custom">
                    <label class="form-label-custom">State *</label>
                    <input type="text" class="form-control-custom" name="state" required placeholder="Enter state">
                  </div>
                </div>
              </div>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group-custom">
                    <label class="form-label-custom">PIN Code *</label>
                    <input type="text" class="form-control-custom" name="pincode" pattern="\d{6}" required placeholder="6 digit code">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group-custom">
                    <label class="form-label-custom">Country *</label>
                    <input type="text" class="form-control-custom" name="country" value="India" required>
                  </div>
                </div>
              </div>

              <div class="checkout-section-title mt-4">
                <i class="fas fa-credit-card text-primary"></i> Payment details
              </div>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group-custom">
                    <label class="form-label-custom">Payment Method *</label>
                    <select class="form-select-custom" name="payment" required>
                      <option value="cod">Cash on Delivery</option>
                      <option value="online">Online Payment</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group-custom">
                    <label class="form-label-custom">Order Notes (Optional)</label>
                    <textarea class="form-control-custom" name="notes" rows="1" placeholder="Any instruction for shipping..."></textarea>
                  </div>
                </div>
              </div>

            </div>
            
            <!-- Right Panel: Order Summary Items -->
            <div>
              <div class="cart-summary-card">
                <h4 class="summary-header">Items in Order</h4>
                
                <div class="summary-checkout-items mb-4" style="max-height: 280px; overflow-y: auto;">
                  <?php foreach ($cart_items as $item): ?>
                    <div class="summary-checkout-item">
                      <img src="admin/<?php echo $item['img']; ?>" class="summary-checkout-img" alt="<?php echo htmlspecialchars($item['title']); ?>">
                      <div class="summary-checkout-name">
                        <?php echo htmlspecialchars($item['title']); ?>
                      </div>
                      <div class="summary-checkout-qty-price">
                        <div>Qty: <?php echo $item['quantity']; ?></div>
                        <div class="fw-bold text-dark">₹<?php echo $item['saleprice'] * $item['quantity']; ?></div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>

                <div class="summary-row">
                  <span>Shipping:</span>
                  <span class="text-success fw-bold">FREE SHIPPING</span>
                </div>
                
                <div class="summary-row total">
                  <span>Total Amount:</span>
                  <span class="text-success">₹<?php echo $total_amount; ?></span>
                </div>
                
                <button type="submit" name="submit" class="btn-checkout">
                  <i class="fas fa-shopping-bag"></i> Place Order Now
                </button>
                
                <a href="cart.php" class="btn btn-outline-secondary w-100 mt-3" style="border-radius: 12px; padding: 12px;">
                  <i class="fas fa-arrow-left"></i> Back to Cart
                </a>
              </div>
            </div>

          </div>
        </form>
      </div>

    </div>
  </div>

  <!-- Footer -->
  <?php include_once('includes/footer.php'); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <?php include 'chatbot.php'; ?>
</body>
</html>
