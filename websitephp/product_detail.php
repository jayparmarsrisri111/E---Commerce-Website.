<?php
session_start();
include('configpage.php');

$id = $_GET['id'] ?? '';
$nav = 'product';

// Fetch product details
$query = "SELECT * FROM product WHERE id = '$id'";
$result = mysqli_query($mysqli, $query);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "Product not found.";
    exit;
}

$mrp = $product['mrp'];
$sale = $product['saleprice'];
$discount = round((($mrp - $sale) / $mrp) * 100);

// Fetch order stock
$ptitle = $product['title'];
$stock_query = "SELECT SUM(qunatity) AS total FROM orderss WHERE productname='$ptitle'";
$orderstock_result = $mysqli->query($stock_query)->fetch_assoc();
$orderstock = $orderstock_result['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="image/LOGO.jpg">
  <title><?php echo $product['title']; ?> | MARINE TRADERS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <!-- Use standard pr.css for navbar/footer styles and custom for details -->
  <link rel="stylesheet" href="css/pr.css">
  <link rel="stylesheet" href="css/product_detail.css">
</head>
<body>
  <!-- Navigation (Same as pr.php) -->
  <?php include_once('includes/navbar.php'); ?>

  <!-- Main Detail Content -->
  <div class="main-content">
    <div class="container my-5 flex-grow-1">
      <div class="my-3">
          <a href="pr.php" class="btn btn-light shadow-sm"><i class="fas fa-arrow-left text-primary me-2"></i> Back to Products</a>
      </div>
      
      <div class="detail-card">
        <div class="row align-items-center">
          
          <!-- Product Image -->
          <div class="col-md-5 text-center">
              <div class="detail-img-container">
                  <img src="admin/<?php echo $product['img']; ?>" class="detail-img img-fluid" alt="<?php echo $product['title']; ?>">
              </div>
          </div>
          
          <!-- Product Specs -->
          <div class="col-md-7 px-4 py-4">
              <div class="detail-category mb-2">
                  <i class="fas fa-folder me-1"></i> <?php echo htmlspecialchars($product['category']); ?>
              </div>
              
              <h1 class="detail-title"><?php echo htmlspecialchars($product['title']); ?></h1>
              
              <div class="detail-price-box my-4">
                  <span class="d-mrp">MRP: ₹<?php echo $mrp; ?></span>
                  <span class="d-sale ms-3">₹<?php echo $sale; ?></span>
                  <span class="d-discount ms-3"><?php echo $discount; ?>% OFF</span>
              </div>
              
              <div class="detail-stock-box mb-4">
                  <h5 class="mb-3"><i class="fas fa-boxes me-2 text-primary"></i>Stock Status</h5>
                  <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="text-secondary fw-bold">Available / Total</span>
                      <span class="fw-bold fs-5 text-dark">
                          <span class="text-primary"><?php echo ($product['stock'] - $orderstock); ?></span> / <?php echo $product['stock']; ?>
                      </span>
                  </div>
                  <meter class="w-100" value="<?php echo ($product['stock'] - $orderstock); ?>" min="0" max="<?php echo $product['stock']; ?>" optimum="<?php echo ($product['stock'] * 0.8); ?>"></meter>
              </div>
              
              <div class="detail-actions mt-4 pt-3 border-top border-light">
                  <?php if($orderstock >= $product['stock']) { ?>
                      <div class="alert alert-danger" role="alert">
                          <i class="fas fa-exclamation-circle me-2"></i> Currently out of stock
                      </div>
                  <?php } else {
                      // Login check for order
                      $orderUrl = 'orderpage.php?title=' . urlencode($product['title']) . '&saleprice=' . urlencode($product['saleprice']);
                      if (isset($_SESSION['email'])) {
                          $orderLink = $orderUrl;
                      } else {
                          $orderLink = 'login.php?redirect=' . urlencode($orderUrl);
                      }
                  ?>
                      <a href="<?php echo $orderLink; ?>" class="btn d-btn-order btn-lg w-100 shadow-lg mb-4">
                          <i class="fas fa-shopping-cart fa-lg ms-2 me-2"></i> Proceed to Order Now
                      </a>
                  <?php } ?>
              </div>

              <!-- Added Full Product Details Section -->
              <div class="product-full-details mt-4 p-4 rounded bg-light border">
                  <h5 class="mb-3 text-dark border-bottom pb-2"><i class="fas fa-info-circle text-primary me-2"></i>Product Details</h5>
                  <table class="table table-borderless table-sm mb-0">
                      <tbody>
                          <tr>
                              <th class="text-muted w-25">Product Code:</th>
                              <td class="fw-bold text-dark">PRD-<?php echo str_pad($product['id'], 5, '0', STR_PAD_LEFT); ?></td>
                          </tr>
                          <tr>
                              <th class="text-muted">Category:</th>
                              <td class="fw-bold text-dark"><?php echo htmlspecialchars($product['category']); ?></td>
                          </tr>
                          <tr>
                              <th class="text-muted">Availability:</th>
                              <td class="fw-bold text-success">
                                <?php echo (($product['stock'] - $orderstock) > 0) ? 'In Stock (' . ($product['stock'] - $orderstock) . ' Units)' : 'Out of Stock'; ?>
                              </td>
                          </tr>
                          <tr>
                              <th class="text-muted">Dispatch:</th>
                              <td class="text-dark">Usually dispatches within 24-48 hours.</td>
                          </tr>
                          <tr>
                              <th class="text-muted">Shipping:</th>
                              <td class="text-dark">Available across India. Standard rates apply.</td>
                          </tr>
                          <tr>
                              <th class="text-muted">Warranty:</th>
                              <td class="text-dark">1 Year Manufacturer Warranty on applicable parts.</td>
                          </tr>
                      </tbody>
                  </table>
                  <p class="mt-3 text-muted small"><i class="fas fa-shield-alt text-success me-1"></i> 100% Genuine Product Guarantee from MARINE TRADERS.</p>
              </div>

          </div>
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
