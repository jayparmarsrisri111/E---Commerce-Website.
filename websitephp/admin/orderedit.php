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
                        <i class="fas fa-shopping-cart"></i> Order Status
                    </h5>
                    <div class="mb-3">
                        <label for="productstatus" class="form-label">Product Status</label>
                        <select class="form-select"  name="orderstatus" >
                <option value="select">Select Status</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
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