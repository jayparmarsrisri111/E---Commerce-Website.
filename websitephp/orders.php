<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}
include('configpage.php');
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Orders | MARINE TRADERS</title>
  <link rel="icon" href="image/LOGO.jpg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="css/orders.css?v=<?php echo time(); ?>">
</head>
<body>

<?php include_once('includes/navbar.php'); ?>

<div class="main-content">
  <div class="container">
    <div class="orders-container">
      <div class="orders-card shadow-lg">
        <h2 class="page-title text-center mb-4">
          <i class="fas fa-shopping-bag me-3"></i>My Order History
        </h2>
        
        <div class="info-box mb-4">
          <i class="fas fa-info-circle me-2"></i>
          Below is the list of all orders placed using <strong><?php echo htmlspecialchars($email); ?></strong>.
        </div>

        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th style="text-align: center; vertical-align: middle;">Order ID</th>
                <th style="text-align: left; vertical-align: middle;">Product</th>
                <th style="text-align: center; vertical-align: middle;">Quantity</th>
                <th style="text-align: center; vertical-align: middle;">Total Amount</th>
                <th style="text-align: center; vertical-align: middle;">Status</th>
                <th style="text-align: center; vertical-align: middle;">Details</th>
                <th style="text-align: center; vertical-align: middle;">Bill</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $orders_q = mysqli_query($mysqli, "SELECT * FROM orderss WHERE email='$email' ORDER BY id DESC");
              $modals_html = "";
              if(mysqli_num_rows($orders_q) > 0){
                while($ord = mysqli_fetch_assoc($orders_q)){
                  $status = !empty($ord['orderstatus']) ? $ord['orderstatus'] : 'Pending';
                  $status_class = 'status-pending';
                  if(strtolower($status) == 'delivered') $status_class = 'status-success';
                  if(strtolower($status) == 'cancelled') $status_class = 'status-danger';
                  
                  echo "<tr>";
                  echo "<td style='text-align: center; vertical-align: middle; font-weight: 600; color: #475569;'>#MT-".str_pad($ord['id'], 5, '0', STR_PAD_LEFT)."</td>";
                  echo "<td style='text-align: left; vertical-align: middle;'><span class='fw-bold text-dark'>".htmlspecialchars($ord['productname'])."</span></td>";
                  echo "<td style='text-align: center; vertical-align: middle; font-weight: 500;'>".htmlspecialchars($ord['qunatity'])."</td>";
                  echo "<td style='text-align: center; vertical-align: middle;'><span class='price-text'>₹".htmlspecialchars($ord['totalamount'])."</span></td>";
                  echo "<td style='text-align: center; vertical-align: middle;'><span class='status-badge ".$status_class."'>".ucfirst(htmlspecialchars($status))."</span></td>";
                  echo "<td style='text-align: center; vertical-align: middle;'><a href='#' class='btn btn-sm btn-outline-info' data-bs-toggle='modal' data-bs-target='#orderModal".$ord['id']."' style='border-radius: 8px; padding: 5px 12px;'><i class='fas fa-eye'></i></a></td>";
                  echo "<td style='text-align: center; vertical-align: middle;'><a href='bill.php?id=".$ord['id']."' target='_blank' style='background: linear-gradient(135deg, #00c6ff 0%, #0072ff 100%); color:white; border-radius:30px; padding:6px 16px; text-decoration:none; display: inline-flex; align-items: center; justify-content: center; gap: 6px; font-size: 13px; font-weight: 700; box-shadow: 0 4px 10px rgba(0, 114, 255, 0.3); transition: all 0.3s ease; white-space: nowrap; text-transform: uppercase; letter-spacing: 0.5px;' onmouseover='this.style.transform=\"translateY(-2px)\"; this.style.boxShadow=\"0 6px 15px rgba(0, 114, 255, 0.5)\"' onmouseout='this.style.transform=\"translateY(0)\"; this.style.boxShadow=\"0 4px 10px rgba(0, 114, 255, 0.3)\"'><i class='fas fa-file-pdf'></i> Bill</a></td>";
                  echo "</tr>";
                  
                  $modals_html .= "
                  <div class='modal fade text-dark' id='orderModal".$ord['id']."' tabindex='-1' aria-labelledby='orderModalLabel".$ord['id']."' aria-hidden='true'>
                    <div class='modal-dialog modal-lg modal-dialog-centered'>
                      <div class='modal-content' style='border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2); text-align: left;'>
                        <div class='modal-header' style='background: #f8fafc; border-bottom: 1px solid #e2e8f0; border-top-left-radius: 16px; border-top-right-radius: 16px; padding: 1.5rem;'>
                          <h5 class='modal-title fw-bold' id='orderModalLabel".$ord['id']."' style='color:#1e3a8a;'><i class='fas fa-shopping-bag me-2' style='color:#3b82f6;'></i>Order Details #MT-".str_pad($ord['id'], 5, '0', STR_PAD_LEFT)."</h5>
                          <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body p-4'>
                          <div class='row g-4'>
                            <div class='col-md-6'>
                              <div style='background: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem; border-radius: 8px; height: 100%;'>
                                <h6 class='fw-bold text-success mb-3 text-uppercase' style='letter-spacing: 0.5px;'><i class='fas fa-map-marker-alt me-2'></i>Shipping To</h6>
                                <p class='mb-2'><strong>".htmlspecialchars($ord['firstname']." ".$ord['lastname'])."</strong></p>
                                <p class='mb-1'><i class='fas fa-envelope text-muted me-2'></i>".htmlspecialchars($ord['email'])."</p>
                                <p class='mb-1'><i class='fas fa-phone text-muted me-2'></i>".htmlspecialchars($ord['phone'])."</p>
                                <p class='mb-0 mt-2 text-muted' style='font-size: 0.9rem; line-height: 1.5;'>
                                  ".htmlspecialchars($ord['address'])."<br>
                                  ".htmlspecialchars($ord['city']).", ".htmlspecialchars($ord['state'])." - ".htmlspecialchars($ord['pincode'])."<br>
                                  ".htmlspecialchars($ord['country'])."
                                </p>
                              </div>
                            </div>
                            <div class='col-md-6'>
                              <div style='background: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem; border-radius: 8px; height: 100%;'>
                                <h6 class='fw-bold text-primary mb-3 text-uppercase' style='letter-spacing: 0.5px;'><i class='fas fa-info-circle me-2'></i>Order Info</h6>
                                <p class='mb-2 d-flex justify-content-between border-bottom pb-2'>
                                  <span class='text-muted'>Product</span>
                                  <span class='fw-bold text-end'>".htmlspecialchars($ord['productname'])."</span>
                                </p>
                                <p class='mb-2 d-flex justify-content-between border-bottom pb-2'>
                                  <span class='text-muted'>Product ID</span>
                                  <span class='fw-semibold'>".htmlspecialchars($ord['productn'])."</span>
                                </p>
                                <p class='mb-2 d-flex justify-content-between border-bottom pb-2'>
                                  <span class='text-muted'>Quantity</span>
                                  <span class='badge bg-secondary rounded-pill'>".htmlspecialchars($ord['qunatity'])." Unit(s)</span>
                                </p>
                                <p class='mb-2 d-flex justify-content-between border-bottom pb-2'>
                                  <span class='text-muted'>Payment Mode</span>
                                  <span class='fw-semibold text-uppercase'>".htmlspecialchars($ord['payment'])."</span>
                                </p>
                                <p class='mb-0 mt-3 d-flex justify-content-between align-items-center'>
                                  <span class='fw-bold text-dark fs-5'>Total Paid</span>
                                  <span class='fw-bold fs-4' style='color:#10b981;'>₹".htmlspecialchars($ord['totalamount'])."</span>
                                </p>
                              </div>
                            </div>
                          </div>
                          ".(!empty($ord['notes']) ? "<div class='mt-4 p-3' style='background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px;'><h6 class='fw-bold text-warning-emphasis mb-2'><i class='fas fa-comment-dots me-2'></i>Order Notes:</h6><p class='mb-0 text-muted fst-italic'>\"".htmlspecialchars($ord['notes'])."\"</p></div>" : "")."
                        </div>
                        <div class='modal-footer' style='border-top: 1px solid #e2e8f0; padding: 1rem 1.5rem; justify-content: space-between;'>
                          <div>
                            <span class='text-muted me-2'>Current Status:</span>
                            <span class='status-badge ".$status_class."'>".ucfirst(htmlspecialchars($status))."</span>
                          </div>
                          <button type='button' class='btn btn-secondary px-4' data-bs-dismiss='modal'>Close</button>
                        </div>
                      </div>
                    </div>
                  </div>";
                }
              } else {
                echo "<tr><td colspan='6' class='text-center py-5'><i class='fas fa-box-open fa-3x mb-3 text-muted'></i><p>No orders found yet. <a href='pr.php'>Start Shopping</a></p></td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php echo $modals_html; ?>

<!-- Footer -->
<?php include_once('includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'chatbot.php'; ?>
</body>
</html>
