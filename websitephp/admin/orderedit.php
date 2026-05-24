<?php
include("configpage.php");
if(isset($_POST['update'])) {

    $id = mysqli_real_escape_string($mysqli, $_POST['id']);
    $firstname = mysqli_real_escape_string($mysqli, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($mysqli, $_POST['lastname']);
    $phone = mysqli_real_escape_string($mysqli, $_POST['phone']);
    $productname = mysqli_real_escape_string($mysqli, $_POST['productname']);
    $qunatity = mysqli_real_escape_string($mysqli, $_POST['qunatity']);
    $payment = mysqli_real_escape_string($mysqli, $_POST['payment']);
    $orderstatus = mysqli_real_escape_string($mysqli, $_POST['orderstatus']);

    $result = mysqli_query($mysqli, "
        UPDATE orderss SET
        firstname='$firstname',
        lastname='$lastname',
        phone='$phone',
        productname='$productname',
        qunatity='$qunatity',
        payment='$payment',
        orderstatus='$orderstatus'
        WHERE id='$id'
    ");

    header("Location: orderdisplay.php");
    exit;
}
?>
<?php
$id = mysqli_real_escape_string($mysqli, $_GET['id']);
$result = mysqli_query($mysqli, "SELECT * FROM orderss WHERE id='$id'");
$res = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order - MARINE TRADERS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/orderedit.css">
    <style>
    .tracking-container { padding: 25px 10px; margin-top: 15px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0; }
    .tracking-timeline { display: flex; justify-content: space-between; position: relative; width: 100%; margin-bottom: 10px;}
    .tracking-timeline::before { content: ''; position: absolute; top: 15px; left: 10%; right: 10%; height: 4px; background: #e2e8f0; z-index: 1; }
    .tracking-step { position: relative; z-index: 2; text-align: center; width: 25%; }
    .tracking-icon { width: 34px; height: 34px; border-radius: 50%; background: #e2e8f0; color: #94a3b8; line-height: 28px; margin: 0 auto 10px; font-size: 14px; border: 3px solid #fff; transition: all 0.3s; display:flex; align-items:center; justify-content:center;}
    .tracking-step.completed .tracking-icon { background: #10b981; color: #fff; }
    .tracking-step.current .tracking-icon { background: #3b82f6; color: #fff; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2); }
    .tracking-step.cancelled .tracking-icon { background: #ef4444; color: #fff; }
    .tracking-label { font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
    .tracking-step.completed .tracking-label, .tracking-step.current .tracking-label { color: #0f172a; }
    .tracking-step.cancelled .tracking-label { color: #ef4444; }
    .tracking-bar { position: absolute; top: 15px; left: 10%; height: 4px; background: #10b981; z-index: 1; transition: width 0.4s ease; }
    .tracking-bar.cancelled { background: #ef4444; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-ship"></i> MARINE TRADERS
            </a>
            <div class="ms-auto">
                <a href="orderdisplay.php" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back to Orders
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-main">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-edit"></i> Update Order</h2>
            </div>
            <div class="card-body">
                <form name="update_order" method="post" action="orderedit.php">
                    
                    <input type="hidden" name="id" value="<?php echo $res['id']; ?>">

                    <!-- Customer Information -->
                    <h5 class="mb-3" style="color: #667eea; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px;">
                        <i class="fas fa-user"></i> Customer Information
                    </h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" 
                                   value="<?php echo $res['firstname']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" 
                                   value="<?php echo $res['lastname']; ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" 
                               value="<?php echo $res['phone']; ?>" required>
                    </div>

                    <!-- Order Details -->
                    <h5 class="mb-3 mt-4" style="color: #667eea; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px;">
                        <i class="fas fa-shopping-cart"></i> Order Details
                    </h5>

                    <div class="mb-3">
                        <label for="productname" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="productname" name="productname" 
                               value="<?php echo $res['productname']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="qunatity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="qunatity" name="qunatity" 
                               value="<?php echo $res['qunatity']; ?>" min="1" required>
                    </div>

                    <h5 class="mb-3 mt-4" style="color: #667eea; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px;">
                        <i class="fas fa-route"></i> Live Tracking Status
                    </h5>
                    <?php
                    $status_low = strtolower($res['orderstatus']);
                    if($status_low == 'select') $status_low = 'pending';
                    $p_width = '0%';
                    $s1 = $s2 = $s3 = $s4 = '';
                    $bar_class = '';

                    if ($status_low == 'cancelled') {
                        $s1 = 'cancelled'; $bar_class = 'cancelled'; $p_width = '100%';
                    } else {
                        if($status_low == 'pending' || $status_low == '') {
                            $s1 = 'current'; $p_width = '0%';
                        } else if($status_low == 'processing') {
                            $s1 = 'completed'; $s2 = 'current'; $p_width = '33%';
                        } else if($status_low == 'shipped') {
                            $s1 = 'completed'; $s2 = 'completed'; $s3 = 'current'; $p_width = '66%';
                        } else if($status_low == 'delivered') {
                            $s1 = 'completed'; $s2 = 'completed'; $s3 = 'completed'; $s4 = 'completed'; $p_width = '100%';
                        }
                    }
                    ?>
                    <div class='tracking-container'>
                        <div class='tracking-timeline'>
                            <div class='tracking-bar <?php echo $bar_class; ?>' style='width: <?php echo $p_width; ?>;'></div>
                            <div class='tracking-step <?php echo $s1; ?>'>
                                <div class='tracking-icon'><i class='fas fa-clipboard-list'></i></div>
                                <div class='tracking-label'><?php echo ($status_low=='cancelled'?'Cancelled':'Placed'); ?></div>
                            </div>
                            <div class='tracking-step <?php echo $s2; ?>' style='display: <?php echo ($status_low=='cancelled'?'none':'block'); ?>;'>
                                <div class='tracking-icon'><i class='fas fa-box-open'></i></div>
                                <div class='tracking-label'>Processing</div>
                            </div>
                            <div class='tracking-step <?php echo $s3; ?>' style='display: <?php echo ($status_low=='cancelled'?'none':'block'); ?>;'>
                                <div class='tracking-icon'><i class='fas fa-shipping-fast'></i></div>
                                <div class='tracking-label'>Shipped</div>
                            </div>
                            <div class='tracking-step <?php echo $s4; ?>' style='display: <?php echo ($status_low=='cancelled'?'none':'block'); ?>;'>
                                <div class='tracking-icon'><i class='fas fa-home'></i></div>
                                <div class='tracking-label'>Delivered</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 mt-4">
                        <label for="productstatus" class="form-label fw-bold text-secondary">Update Tracking Step</label>
                        <select class="form-select" name="orderstatus">
                            <option value="pending" <?php if($status_low=='pending') echo 'selected'; ?>>Pending (Placed)</option>
                            <option value="processing" <?php if($status_low=='processing') echo 'selected'; ?>>Processing</option>
                            <option value="shipped" <?php if($status_low=='shipped') echo 'selected'; ?>>Shipped</option>
                            <option value="delivered" <?php if($status_low=='delivered') echo 'selected'; ?>>Delivered</option>
                            <option value="cancelled" <?php if($status_low=='cancelled') echo 'selected'; ?>>Cancelled</option>
                        </select>
                    </div>



                    <!-- Payment Information -->
                    <h5 class="mb-3 mt-4" style="color: #667eea; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px;">
                        <i class="fas fa-credit-card"></i> Payment Information
                    </h5>

                    <div class="mb-3">
                        <label for="payment" class="form-label">Payment Method</label>
                        <input type="text" class="form-control" id="payment" name="payment" 
                               value="<?php echo $res['payment']; ?>" required>
                    </div>

                    <!-- Buttons -->
                    <div class="text-center mt-4">
                        <button type="submit" name="update" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Order
                        </button>
                        <a href="orderdisplay.php" class="btn btn-secondary ms-2">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>