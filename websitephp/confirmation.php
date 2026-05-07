<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Order Confirmation | MARINE TRADERS</title>
  <link rel="icon" href="image/LOGO.jpg" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="css/confirmation.css?v=<?php echo time(); ?>">
</head>
<body>
  <div class="content-wrapper">
    <div class="confirmation-container">
      <div class="success-icon">
        <i class="fas fa-check"></i>
      </div>

      <h1>Order Confirmed!</h1>
      <p class="order-number">
        Order #MT-<?php echo str_pad($_GET['order_id'] ?? '0', 5, '0', STR_PAD_LEFT); ?>
      </p>
      
      <p class="message">
        Thank you for your order! We've received your request and will process it shortly. 
      </p>

      <div class="info-box">
        <div class="info-row">
          <span class="info-label">Order Date:</span>
          <span class="info-value"><?php echo date('d M Y'); ?></span>
        </div>
      
        <div class="info-row">
          <span class="info-label">Total Amount:</span>
          <span class="info-value">&#8377;<?php echo htmlspecialchars($_GET['saleprice'] ?? '0.00'); ?></span>
        </div>
        <div class="info-row">
          <span class="info-label">Payment Method:</span>
          <span class="info-value">
            <?php
              $pay = $_GET['payment'] ?? '';
              echo ($pay == 'cod') ? 'Cash on Delivery' : 'Online Payment';
            ?>
          </span>
        </div>
      </div>

      <div class="btn-group">
        <a href="HOME PAGE WEBSITE.php" class="btn btn-primary">
          <i class="fas fa-home"></i>
          Back to Home
        </a>
        <a href="pr.php" class="btn btn-secondary">
          <i class="fas fa-shopping-bag"></i>
          New Order
        </a>
        <a href="bill.php" class="btn btn-info text-white" target="_blank" style="background-color: #0dcaf0; border-color: #0dcaf0;">
          <i class="fas fa-file-invoice"></i>
          Bill
        </a>
      </div>
    </div>
  </div>

  <!-- Footer -->
<?php include_once('includes/footer.php'); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'chatbot.php'; ?>
</body>
</html>

