<?php
include("configpage.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($mysqli, $_POST['id']);
    $title = mysqli_real_escape_string($mysqli, $_POST['title']);
    $mrp = mysqli_real_escape_string($mysqli, $_POST['mrp']);
    $saleprice = mysqli_real_escape_string($mysqli, $_POST['saleprice']);
    $stock = mysqli_real_escape_string($mysqli, $_POST['stock']);
    $category = mysqli_real_escape_string($mysqli, $_POST['category']);
    // IMAGE HANDLING
    if (!empty($_FILES['img']['name'])) {
        $img_name = $_FILES['img']['name'];
        $img_tmp = $_FILES['img']['tmp_name'];
        $img_path = "../image/" . $img_name;
        move_uploaded_file($img_tmp, $img_path);
        $result = mysqli_query($mysqli, "
            UPDATE product SET
            img='$img_path',
            title='$title',
            mrp='$mrp',
            saleprice='$saleprice',
            stock='$stock',
            category='$category'
            WHERE id='$id'
        ");
    } else {
        // If image not changed
        $result = mysqli_query($mysqli, "
            UPDATE product SET
            title='$title',
            mrp='$mrp',
            saleprice='$saleprice',
            stock='$stock',
            category='$category'
            WHERE id='$id'
        ");
    }
    header("Location: displayform.php");
    exit;
}
?>
<?php
$id = mysqli_real_escape_string($mysqli, $_GET['id']);
$result = mysqli_query($mysqli, "SELECT * FROM product WHERE id='$id'");
$res = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product - MARINE TRADERS</title>
    <link rel="icon" href="../image/LOGO.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/update.css">
</head>

<body>
    <?php include_once('includes/sidebar.php'); ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php include_once('includes/top_nav.php'); ?>
        <div class="form-container">
            <div class="form-card">
                <div class="form-header">
                    <i class="fas fa-edit fa-3x mb-3"></i>
                    <h2>MARINE TRADERS</h2>
                    <p>Product Management</p>
                    <span class="admin-badge">
                        <i class="fas fa-edit"></i> Update Product
                    </span>
                </div>
                
                <div class="form-body">
                    <form action="update.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="id" class="form-label">
                                <i class="fas fa-hashtag me-2"></i>Product ID
                            </label>
                            <div class="input-icon">
                                <i class="fas fa-barcode"></i>
                                <input type="number" name="id" class="form-control" 
                                       value="<?php echo $res['id']; ?>" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="img" class="form-label">
                                <i class="fas fa-image me-2"></i>Product Image
                            </label>
                            <div class="current-image">
                                <img src="<?php echo $res['img']; ?>" alt="Current Product Image">
                                <p><i class="fas fa-info-circle"></i> Current image (upload new to replace)</p>
                            </div>
                            <input type="file" name="img" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">
                                <i class="fas fa-tag me-2"></i>Product Title
                            </label>
                            <div class="input-icon">
                                <i class="fas fa-pen"></i>
                                <input type="text" name="title" class="form-control" 
                                       placeholder="Enter product title" 
                                       value="<?php echo $res['title']; ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="mrp" class="form-label">
                                <i class="fas fa-dollar-sign me-2"></i>MRP (Maximum Retail Price)
                            </label>
                            <div class="input-icon">
                                <i class="fas fa-money-bill-wave"></i>
                                <input type="number" name="mrp" class="form-control" 
                                       placeholder="Enter MRP" 
                                       value="<?php echo $res['mrp']; ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="saleprice" class="form-label">
                                <i class="fas fa-tags me-2"></i>Sales Price
                            </label>
                            <div class="input-icon">
                                <i class="fas fa-rupee-sign"></i>
                                <input type="number" name="saleprice" class="form-control" 
                                       placeholder="Enter sales price" 
                                       value="<?php echo $res['saleprice']; ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="stock" class="form-label">
                                <i class="fas fa-warehouse me-2"></i>Stock Quantity
                            </label>
                            <div class="input-icon">
                                <i class="fas fa-boxes"></i>
                                <input type="number" name="stock" class="form-control" 
                                       placeholder="Enter stock quantity" 
                                       value="<?php echo $res['stock']; ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">
                                <i class="fas fa-list me-2"></i>Category
                            </label>
                            <div class="input-icon">
                                <i class="fas fa-folder"></i>
                                <input type="text" name="category" class="form-control" 
                                       placeholder="Enter product category" 
                                       value="<?php echo $res['category']; ?>" required>
                            </div>
                        </div>

                        <button type="submit" name="update" class="btn btn-submit">
                            <i class="fas fa-save me-2"></i>Update Product
                        </button>
                    </form>
                </div>
            </div>


        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-toggle');
            
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });
    </script>
</body>
</html>