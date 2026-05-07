<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - MARINE TRADERS</title>
    <link rel="icon" href="../image/LOGO.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/form.css">
</head>

<body>
    <?php include_once('includes/sidebar.php'); ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php include_once('includes/top_nav.php'); ?>
        <div class="form-container">
            <div class="form-card">
                <div class="form-header">
                    <i class="fas fa-box-open fa-3x mb-3"></i>
                    <h2>MARINE TRADERS</h2>
                    <p>Product Management</p>
                    <span class="admin-badge">
                        <i class="fas fa-plus-circle"></i> Add New Product
                    </span>
                </div>
                
                <div class="form-body">
                    <form action="addproductpage.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="id" class="form-label">
                                <i class="fas fa-hashtag me-2"></i>Product ID
                            </label>
                            <div class="input-icon">
                                <i class="fas fa-barcode"></i>
                                <input type="text" name="id" class="form-control" 
                                       placeholder="Enter product ID" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="img" class="form-label">
                                <i class="fas fa-image me-2"></i>Product Image
                            </label>
                            <input type="file" name="img" class="form-control" 
                                   accept="image/*" required>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">
                                <i class="fas fa-tag me-2"></i>Product Title
                            </label>
                            <div class="input-icon">
                                <i class="fas fa-pen"></i>
                                <input type="text" name="title" class="form-control" 
                                       placeholder="Enter product title" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="mrp" class="form-label">
                                <i class="fas fa-dollar-sign me-2"></i>MRP (Maximum Retail Price)
                            </label>
                            <div class="input-icon">
                                <i class="fas fa-money-bill-wave"></i>
                                <input type="text" name="mrp" class="form-control" 
                                       placeholder="Enter MRP" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="saleprice" class="form-label">
                                <i class="fas fa-tags me-2"></i>Sales Price
                            </label>
                            <div class="input-icon">
                                <i class="fas fa-rupee-sign"></i>
                                <input type="text" name="saleprice" class="form-control" 
                                       placeholder="Enter sales price" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="stock" class="form-label">
                                <i class="fas fa-warehouse me-2"></i>Stock Quantity
                            </label>
                            <div class="input-icon">
                                <i class="fas fa-boxes"></i>
                                <input type="text" name="stock" class="form-control" 
                                       placeholder="Enter stock quantity" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">
                                <i class="fas fa-list me-2"></i>Category
                            </label>
                            <div class="input-icon">
                                <i class="fas fa-folder"></i>
                                <input type="text" name="category" class="form-control" 
                                       placeholder="Enter product category" required>
                            </div>
                        </div>

                        <button type="submit" name="submit" class="btn btn-submit">
                            <i class="fas fa-plus-circle me-2"></i>Add Product
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