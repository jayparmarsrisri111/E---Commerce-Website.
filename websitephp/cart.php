<?php
session_start();
include_once("configpage.php");
include_once("cart_functions.php");

// Fetch products details in cart
$cart_items = [];
$total_mrp = 0;
$total_sale = 0;

if (isset($_SESSION['email'])) {
    $email = mysqli_real_escape_string($mysqli, $_SESSION['email']);
    $query = "SELECT c.*, p.title, p.img, p.mrp, p.saleprice, p.category, p.stock FROM cart c JOIN product p ON c.product_id = p.id WHERE c.email = '$email' ORDER BY c.id DESC";
    $result = mysqli_query($mysqli, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        // Stock check
        $ptitle = $row['title'];
        $stock_q = mysqli_query($mysqli, "SELECT SUM(qunatity) AS total FROM orderss WHERE productname='$ptitle'");
        $ordered_stock = mysqli_fetch_assoc($stock_q)['total'] ?? 0;
        $available_stock = $row['stock'] - $ordered_stock;
        
        $row['available_stock'] = $available_stock > 0 ? $available_stock : 0;
        $cart_items[] = $row;
        
        $total_mrp += $row['mrp'] * $row['quantity'];
        $total_sale += $row['saleprice'] * $row['quantity'];
    }
} else {
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product_id => $qty) {
            $product_id = (int)$product_id;
            $prod_q = mysqli_query($mysqli, "SELECT * FROM product WHERE id = $product_id");
            $product = mysqli_fetch_assoc($prod_q);
            
            if ($product) {
                $ptitle = $product['title'];
                $stock_q = mysqli_query($mysqli, "SELECT SUM(qunatity) AS total FROM orderss WHERE productname='$ptitle'");
                $ordered_stock = mysqli_fetch_assoc($stock_q)['total'] ?? 0;
                $available_stock = $product['stock'] - $ordered_stock;
                
                $product['quantity'] = $qty;
                $product['available_stock'] = $available_stock > 0 ? $available_stock : 0;
                $cart_items[] = $product;
                
                $total_mrp += $product['mrp'] * $qty;
                $total_sale += $product['saleprice'] * $qty;
            }
        }
    }
}

$savings = $total_mrp - $total_sale;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="image/LOGO.jpg">
  <title>Shopping Cart | MARINE TRADERS</title>
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
      <h1><i class="fas fa-shopping-basket me-3"></i>Your Shopping Cart</h1>
      <p>Manage your premium marine solutions before final order placement</p>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="container">
      
      <!-- Notifications -->
      <?php if(isset($_SESSION['cart_success'])): ?>
        <div class="alert alert-cart alert-cart-success alert-dismissible fade show" role="alert">
          <i class="fas fa-check-circle me-2"></i> <?php echo $_SESSION['cart_success']; unset($_SESSION['cart_success']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>
      
      <?php if(isset($_SESSION['cart_error'])): ?>
        <div class="alert alert-cart alert-cart-error alert-dismissible fade show" role="alert">
          <i class="fas fa-exclamation-circle me-2"></i> <?php echo $_SESSION['cart_error']; unset($_SESSION['cart_error']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if (empty($cart_items)): ?>
        <div class="cart-container">
          <div class="empty-cart-state">
            <div class="empty-cart-icon">
              <i class="fas fa-shopping-cart"></i>
            </div>
            <h2>Your Cart is Empty</h2>
            <p class="text-muted mb-4">You have no items in your shopping cart. Start exploring our premium parts catalogs now.</p>
            <a href="pr.php" class="btn btn-primary btn-lg" style="border-radius: 12px; padding: 12px 30px;">
              <i class="fas fa-store me-2"></i>Browse Products
            </a>
          </div>
        </div>
      <?php else: ?>
        <div class="row g-4">
          
          <!-- Left side: Cart Items -->
          <div class="col-lg-8">
            <div class="cart-container">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="m-0 text-darkfw-bold"><i class="fas fa-list-ul me-2 text-primary"></i>Items Listing</h3>
                <a href="cart_handler.php?action=clear" class="btn-clear-cart" onclick="return confirm('Are you sure you want to empty your cart?')">
                  <i class="fas fa-trash-alt"></i> Empty Cart
                </a>
              </div>
              
              <div class="cart-items-list">
                <?php foreach ($cart_items as $item): ?>
                  <div class="cart-item-card">
                    <!-- Product Image -->
                    <img src="admin/<?php echo $item['img']; ?>" class="cart-item-img" alt="<?php echo htmlspecialchars($item['title']); ?>">
                    
                    <!-- Product Info -->
                    <div class="cart-item-info">
                      <a href="product_detail.php?id=<?php echo $item['product_id'] ?? $item['id']; ?>" class="cart-item-name">
                        <?php echo htmlspecialchars($item['title']); ?>
                      </a>
                      <span class="cart-item-category"><?php echo htmlspecialchars($item['category']); ?></span>
                    </div>
                    
                    <!-- Pricing -->
                    <div class="cart-item-price-block">
                      <span class="cart-item-price">₹<?php echo $item['saleprice']; ?></span>
                      <span class="cart-item-mrp">₹<?php echo $item['mrp']; ?></span>
                    </div>
                    
                    <!-- Quantity Control -->
                    <div class="quantity-control">
                      <button class="btn-qty" onclick="changeQty(<?php echo $item['product_id'] ?? $item['id']; ?>, -1)">-</button>
                      <input 
                        type="number" 
                        class="qty-input" 
                        id="qty-<?php echo $item['product_id'] ?? $item['id']; ?>" 
                        value="<?php echo $item['quantity']; ?>" 
                        min="1" 
                        max="<?php echo $item['available_stock']; ?>"
                        onchange="updateQty(<?php echo $item['product_id'] ?? $item['id']; ?>, this.value)"
                      >
                      <button class="btn-qty" onclick="changeQty(<?php echo $item['product_id'] ?? $item['id']; ?>, 1, <?php echo $item['available_stock']; ?>)">+</button>
                    </div>
                    
                    <!-- Subtotal & Remove -->
                    <div class="d-flex align-items-center justify-content-between gap-3">
                      <div class="cart-item-subtotal">
                        ₹<?php echo $item['saleprice'] * $item['quantity']; ?>
                      </div>
                      <a href="cart_handler.php?action=remove&product_id=<?php echo $item['product_id'] ?? $item['id']; ?>" class="btn-remove-item" title="Remove Item">
                        <i class="fas fa-trash"></i>
                      </a>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
              
              <div class="mt-4">
                <a href="pr.php" class="btn btn-outline-primary" style="border-radius: 10px;">
                  <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                </a>
              </div>
            </div>
          </div>
          
          <!-- Right side: Order Summary -->
          <div class="col-lg-4">
            <div class="cart-summary-card shadow-lg">
              <h4 class="summary-header">Order Summary</h4>
              
              <div class="summary-row">
                <span>Items Total Qty:</span>
                <span class="fw-bold"><?php echo array_sum(array_column($cart_items, 'quantity')); ?> Units</span>
              </div>
              
              <div class="summary-row">
                <span>Items Base Price:</span>
                <span>₹<?php echo $total_mrp; ?></span>
              </div>
              
              <div class="summary-row text-success">
                <span>Catalog Discount:</span>
                <span class="fw-bold">- ₹<?php echo $savings; ?></span>
              </div>
              
              <div class="summary-row">
                <span>Shipping Charges:</span>
                <span class="text-success fw-bold">FREE SHIPPING</span>
              </div>
              
              <div class="summary-row total">
                <span>Total Amount:</span>
                <span class="text-success">₹<?php echo $total_sale; ?></span>
              </div>
              
              <a href="checkout_cart.php" class="btn-checkout">
                <i class="fas fa-credit-card"></i> Proceed to Order Checkout
              </a>
              
              <p class="text-center text-muted small mt-3 mb-0">
                <i class="fas fa-shield-alt text-success me-1"></i> 100% Secure Checkout Guarantee.
              </p>
            </div>
          </div>

        </div>
      <?php endif; ?>

    </div>
  </div>

  <!-- Footer -->
  <?php include_once('includes/footer.php'); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    function changeQty(prodId, delta, maxStock = 999) {
      const input = document.getElementById('qty-' + prodId);
      let currentVal = parseInt(input.value);
      let newVal = currentVal + delta;
      
      if (newVal < 1) newVal = 1;
      if (newVal > maxStock) {
        alert("Sorry, only " + maxStock + " items are available in stock!");
        newVal = maxStock;
      }
      
      input.value = newVal;
      updateQty(prodId, newVal);
    }
    
    function updateQty(prodId, value) {
      window.location.href = `cart_handler.php?action=update&product_id=${prodId}&quantity=${value}`;
    }
  </script>
  
  <?php include 'chatbot.php'; ?>
</body>
</html>
