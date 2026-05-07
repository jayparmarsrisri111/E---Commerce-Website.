<?php
session_start();
  if(!isset($mysqli)){ include('configpage.php'); }
  $nav = $_GET['nav'] ?? 'product'; // 'product' or 'order'
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="image/LOGO.jpg">
  <title>Products | MARINE TRADERS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="css/pr.css?v=<?php echo time(); ?>">
</head>
<body>
  <!-- Navigation -->
  <?php include_once('includes/navbar.php'); ?>

  <!-- Page Header -->
  <div class="page-header">
    <div class="container text-center">
      <h1><i class="fas fa-ship me-3"></i>Marine Products</h1>
      <p>Premium Ship Parts & Marine Machinery Solutions</p>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="container pb-5">
      
      <!-- SHIP PARTS Section -->
      <div class="section-header">
        <h2><i class="fas fa-bolt me-2"></i>Marine Electrical and Machinery Parts</h2>
      </div>

      <div class="row mb-4">
        <div class="col-md-6 mx-auto">
          <form method="GET" class="d-flex">
            <input 
              type="text" 
              name="search" 
              class="form-control me-2"
              placeholder="Search products..."
              value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>"
            >
            <button class="btn btn-primary">
              <i class="fas fa-search"></i>
            </button>
          </form>
        </div>
      </div>

<?php
$conn = mysqli_connect("localhost","root","","marinetraders");
$search = "";
if(isset($_GET['search'])){
    $search = $_GET['search'];
}
$query = "SELECT * FROM product WHERE title LIKE '%$search%' OR category LIKE '%$search%'";
$result = mysqli_query($conn, $query);
?>

      <div class="row g-4">
<?php while($row = mysqli_fetch_assoc($result)) 
{ 
$mrp = $row['mrp'];
$sale = $row['saleprice'];
$discount = round((($mrp - $sale) / $mrp) * 100);
$ptitle = $row['title'];
$stock = $row['stock'];
$orderstock_q = $mysqli->query("SELECT SUM(qunatity) AS total FROM orderss where productname='$ptitle'");
$orderstock = ($orderstock_q && $orderstock_q->num_rows > 0) ? $orderstock_q->fetch_assoc()['total'] : 0;
?>
        <div class="col-lg-3 col-md-6">
          <div class="product-card">
            <div class="product-img-container">
              <img src="admin/<?php echo $row['img']; ?>" class="product-img">
              <span class="stock-badge" <?php if($orderstock >= $row['stock'] || $stock <= 0) echo 'style="background: linear-gradient(135deg, #ef4444, #dc2626); box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);"'; ?>>
                <?php
                if($orderstock >= $row['stock'] || $stock <= 0) { 
                  echo"<span style='color:white'><b>OUT OF STOCK</b></span>";
                } else { 
                  echo "IN STOCK";
                } ?>
              </span>
            </div>

            <div class="product-content">
              <div class="product-title">
                <?php echo $row['title']; ?>
              </div>

              <div class="price-section">
                <span class="original-price">₹<?php echo $mrp; ?></span>
                <span class="sale-price">₹<?php echo $sale; ?></span>
                <span class="discount-badge"><?php echo $discount; ?>% OFF</span>
              </div>

              <div class="stock-meter-container">
                <div class="stock-label">
                  <span><i class="fas fa-boxes me-2"></i>Stock Level</span>
                  <span class="stock-count">
                    <?php echo (int)$orderstock; echo"/";?> <?php echo $row['stock']; ?>
                  </span>
                </div>
                <meter value="<?php echo $row['stock']; ?>" min="0" max="10" optimum="8"></meter>
              </div>

              <?php if($orderstock >= $row['stock'] || $stock <= 0) { 
                echo'<div class="d-flex gap-2 mt-auto pt-3">';
                echo'<a href="product_detail.php?id='.$row['id'].'" class="btn btn-outline-primary flex-grow-1"><i class="fas fa-eye me-1"></i> View</a>';
                echo'<button class="btn btn-secondary flex-grow-1" disabled><i class="fas fa-times-circle me-1"></i> Out of Stock</button>';
                echo'</div>';
              } else {
                // Order Now link - login check
                $orderUrl = 'orderpage.php?title=' . urlencode($row['title']) . '&saleprice=' . urlencode($row['saleprice']);
                if (isset($_SESSION['email'])) {
                    $orderLink = $orderUrl;
                } else {
                    $orderLink = 'login.php?redirect=' . urlencode($orderUrl);
                }
                echo'<div class="d-flex gap-2 mt-auto pt-3">';
                echo'<a href="product_detail.php?id='.$row['id'].'" class="btn btn-outline-primary flex-grow-1"><i class="fas fa-eye me-1"></i> View</a>';
                echo'<a href="'.$orderLink.'" class="btn btn-primary flex-grow-1"><i class="fas fa-shopping-cart me-1"></i> Order Now</a>';
                echo'</div>';
              } ?>
            </div>
          </div>
        </div>
<?php } ?>
      </div><!-- /.row -->
    </div><!-- /.container -->
  </div><!-- /.main-content -->

  <!-- Footer -->
<?php include_once('includes/footer.php'); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'chatbot.php'; ?>
</body>
</html>
