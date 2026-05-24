<?php
session_start();

// â”€â”€ Login check: agar user logged in nahi hai toh login page pe bhejo â”€â”€
if (!isset($_SESSION['email'])) {
    $redirect = urlencode('orderpage.php?' . http_build_query($_GET));
    header("Location: login.php?redirect=" . $redirect);
    exit();
}

$accno = $_GET['accno'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Place Order | MARINE TRADERS</title>
  <link rel="icon" href="image/LOGO.jpg" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="css/orderpage.css">
  <link rel="stylesheet" href="css/navbar-common.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="css/page-header.css?v=<?php echo time(); ?>">
</head>
<body>
<?php include_once('includes/navbar.php'); ?>

<div class="page-header">
  <div class="container text-center">
    <h1>Place Order</h1>
    <p>Complete your purchase with secure checkout and fast delivery.</p>
  </div>
</div>

<?php
$title = $_GET['title'] ?? '';
$saleprice = $_GET['saleprice'] ?? '';

// Fetch available stock
include("configpage.php");
$title_esc = mysqli_real_escape_string($mysqli, $title);
$query = "SELECT stock FROM product WHERE title = '$title_esc'";
$result = mysqli_query($mysqli, $query);
$product_data = mysqli_fetch_assoc($result);
$total_stock = $product_data['stock'] ?? 0;

$stock_query = "SELECT SUM(qunatity) AS total FROM orderss WHERE productname='$title_esc'";
$orderstock_result = mysqli_query($mysqli, $stock_query);
$orderstock_data = mysqli_fetch_assoc($orderstock_result);
$ordered_stock = $orderstock_data['total'] ?? 0;

$available_stock = $total_stock - $ordered_stock;
if($available_stock < 0) $available_stock = 0;

// â”€â”€ Logged-in user ka data fetch karo â”€â”€
$user_email = $_SESSION['email'];
$user_email_esc = mysqli_real_escape_string($mysqli, $user_email);
$user_query = "SELECT firstname, lastname, email, phone FROM login WHERE email='$user_email_esc'";
$user_result = mysqli_query($mysqli, $user_query);
$user_data = mysqli_fetch_assoc($user_result);

$u_firstname = htmlspecialchars($user_data['firstname'] ?? '');
$u_lastname  = htmlspecialchars($user_data['lastname']  ?? '');
$u_email     = htmlspecialchars($user_data['email']     ?? $user_email);
$u_phone     = htmlspecialchars($user_data['phone']     ?? '');
?>

<!-- Main Content -->
<div class="main-content">
  <div class="container">
    <div class="order-container">
      <div class="order-form">
        <h2 class="form-title">
          <i class="fas fa-shopping-cart"></i>
          Place Your Order
        </h2>
        
        <div class="info-box">
          <i class="fas fa-info-circle"></i>
          <strong>Secure Checkout:</strong> Fill in your details below to complete your order. All information is kept confidential.
        </div>
        

        <form action="orderinsert.php" method="POST">
          <!-- Personal Information Section -->
          <div class="section-header">
            <i class="fas fa-user"></i>
            Personal Information
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="firstname" class="form-label">
                <i class="fas fa-user"></i>
                First Name *
              </label>
              <input type="text" class="form-control" id="firstName" name="firstname" placeholder="Enter first name" value="<?php echo $u_firstname; ?>" required>
            </div>

            <div class="form-group">
              <label for="lastname" class="form-label">
                <i class="fas fa-user"></i>
                Last Name *
              </label>
              <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter last name" value="<?php echo $u_lastname; ?>" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="email" class="form-label">
                <i class="fas fa-envelope"></i>
                Email Address *
              </label>
              <input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" value="<?php echo $u_email; ?>" required>
            </div>

            <div class="form-group">
              <label for="phone" class="form-label">
                <i class="fas fa-phone"></i>
                Phone Number *
              </label>
              <input type="tel" class="form-control" id="phone" name="phone" placeholder="e.g. +91 9876543210" pattern="[0-9+\s\-()]*" value="<?php echo $u_phone; ?>" required> 
            </div>
          </div>

          <!-- Shipping Address Section -->
          <div class="section-header">
            <i class="fas fa-map-marker-alt"></i>
            Shipping Address
          </div>

          <div class="form-group">
            <label for="address" class="form-label">
              <i class="fas fa-home"></i>
              Street Address *
            </label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Enter your street address" required>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="city" class="form-label">
                <i class="fas fa-city"></i>
                City *
              </label>
              <input type="text" class="form-control" id="city" name="city" placeholder="Enter city" required>
            </div>

            <div class="form-group">
              <label for="state" class="form-label">
                <i class="fas fa-map"></i>
                State *
              </label>
              <input type="text" class="form-control" id="state" name="state" placeholder="Enter state" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="pincode" class="form-label">
                <i class="fas fa-mail-bulk"></i>
                PIN Code *
              </label>
              <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Enter PIN code" pattern="[0-9]{6}" required>
            </div>

            <div class="form-group">
              <label for="country" class="form-label">
                <i class="fas fa-globe"></i>
                Country *
              </label>
              <input type="text" class="form-control" id="country" name="country" value="India" >
            </div>
          </div>

          <!-- Product Details Section -->
          <div class="section-header">
            <i class="fas fa-box"></i>
            Product Details
          </div>

          <div class="form-group">
            <label for="product" class="form-label">
              <i class="fas fa-box-open"></i>
              Product Name *
            </label>
            <input type="text" value="<?php echo $title; ?>" class="form-control" id="product" name="product" placeholder="Enter product name" readonly >
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="quantity" class="form-label">
                <i class="fas fa-sort-numeric-up"></i>
                Quantity *
              </label>
              <input type="number" class="form-control" id="quantity" oninput="mul(); checkStock(this);" name="quantity" placeholder="Enter quantity" min="1" max="<?php echo $available_stock; ?>" value="1" required>
            </div>

            <div class="form-group">
              <label for="payment" class="form-label">
                <i class="fas fa-credit-card"></i>
                Payment Method *
              </label>
              <select class="form-select" id="payment" name="payment" >
                <option value="select">Select payment method</option>
                <option value="cod">Cash on Delivery</option>
                <option value="online">Online Payment</option>

              </select>
            </div>
          </div>


          <div class="form-group">
            <label for="notes" class="form-label">
              <i class="fas fa-comment-dots"></i>
              Additional Notes (Optional)
            </label>
            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Any special instructions or requirements..."></textarea>
          </div>
          <!-- Order Summary -->
          <div class="order-summary">
            <h4 style="color: #1e293b; font-weight: 700; margin-bottom: 15px;">
              <i class="fas fa-receipt" style="color: #3b82f6; margin-right: 10px;"></i>
              Order Summary
            </h4>
            <div class="summary-row">
              <span>Product Name:</span>
              <input type="text" value="<?php echo $title; ?>" name="productn" readonly>
            </div>
            <div class="summary-row total">
              <span>Total Amount:</span>
             <input id="c" type="number" name="totalamount"   value="<?php echo $saleprice; ?>" readonly>
            </div>

            <input  readonly oninput="mul()" id="totalamount" style="display:none;" type="number" value="<?php echo $saleprice; ?>">

          </div>
  <button type="submit" name="submit" class="btn btn-submit">
            <span>Place Order</span>
            <i class="fas fa-arrow-right"></i>
            <div class="loading"></div>
</button>

        </form>
      </div>
    </div>
  </div>
</div>

<script>
function mul(){
  c.value = totalamount.value * quantity.value;
}
function checkStock(input) {
  var max = parseInt(input.getAttribute('max'));
  if (parseInt(input.value) > max) {
    alert('Sorry, only ' + max + ' items are available in stock!');
    input.value = max;
    mul();
  }
}
</script>

<!-- Footer -->
<?php include_once('includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'chatbot.php'; ?>
</body>
</html>
