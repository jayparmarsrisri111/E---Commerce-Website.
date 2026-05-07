<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Products - MARINE TRADERS</title>
    <link rel="icon" href="../image/LOGO.jpg">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="css/displayform.css">
</head>
<body>
    <?php include_once('includes/sidebar.php'); ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php include_once('includes/top_nav.php'); ?>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h2>
                        <i class="bi bi-grid-3x3-gap"></i>
                        Product Management - Display Products
                    </h2>
                </div>
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>MRP</th>
                                    <th>Sales Price</th>
                                    <th>Stock</th>
                                    <th>Category</th>
                                    <th colspan="2" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include("configpage.php");
                                $result = mysqli_query($mysqli, "SELECT * FROM product");
                                
                                if(mysqli_num_rows($result) > 0) {
                                    while($res = mysqli_fetch_array($result)) {
                                        echo "<tr>";
                                        echo "<td><strong>#".$res['id']."</strong></td>";
                                        echo "<td>".$res['title']."</td>";
                                        echo "<td><img src='".$res['img']."' class='product-img' alt='".$res['title']."'></td>";
                                        echo "<td><span class='price-mrp'>₹".$res['mrp']."</span></td>";
                                        echo "<td><span class='price-sale'>₹".$res['saleprice']."</span></td>";
                                        
                                        // Fetch ordered stock for this product
                                        $ptitle = mysqli_real_escape_string($mysqli, $res['title']);
                                        $stock_q = mysqli_query($mysqli, "SELECT SUM(qunatity) as total_ordered FROM orderss WHERE productname='$ptitle'");
                                        $stock_row = mysqli_fetch_assoc($stock_q);
                                        $ordered_stock = $stock_row['total_ordered'] ?? 0;
                                        
                                        $available_stock = $res['stock'] - $ordered_stock;
                                        if($available_stock < 0) $available_stock = 0;

                                        // Stock badge with color coding (Green if > 0, Red if 0)
                                        $stockClass = $available_stock > 0 ? 'bg-success' : 'bg-danger';
                                        echo "<td><span class='badge badge-stock ".$stockClass."'>".$available_stock." Available</span></td>";
                                        
                                        echo "<td><span class='badge-category'>".$res['category']."</span></td>";
                                        echo "<td><a href='formdelete.php?id=".$res['id']."' class='btn-action btn-delete' onclick=\"return confirm('Are you sure you want to delete this product?')\"><i class='bi bi-trash'></i> Delete</a></td>";
                                        echo "<td><a href='update.php?id=".$res['id']."' class='btn-action btn-update'><i class='bi bi-pencil-square'></i> Update</a></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='9' class='empty-state'>";
                                    echo "<i class='bi bi-inbox'></i>";
                                    echo "<h5>No Products Found</h5>";
                                    echo "<p>Start adding products to see them here.</p>";
                                    echo "</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            

        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
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