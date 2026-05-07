<?php
include_once("configpage.php");

$query = "SELECT * FROM orderss";
$result = mysqli_query($mysqli, $query);

// Query check
if (!$result) {
    die("Query Failed: " . mysqli_error($mysqli));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Display - MARINE TRADERS</title>
    <link rel="icon" href="../image/LOGO.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/orderdisplay.css">
</head>
<body>
    <?php include_once('includes/sidebar.php'); ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php include_once('includes/top_nav.php'); ?>
        <div style="overflow-x: auto;">
        <table style="width: 100%; min-width: 1200px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Phone</th>
                    <th>Product Name</th>
                    <th>Qty</th>
                    <th>Total Amt</th>
                    <th>Full Address</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($res = mysqli_fetch_assoc($result)) {
                    $fullName = htmlspecialchars($res['firstname'] . " " . $res['lastname']);
                    $address = htmlspecialchars($res['address']);
                    if(!empty($res['city'])) $address .= ", " . htmlspecialchars($res['city']);
                    if(!empty($res['state'])) $address .= ", " . htmlspecialchars($res['state']);
                    if(!empty($res['pincode'])) $address .= " - " . htmlspecialchars($res['pincode']);
                    
                    echo "<tr>";
                    echo "<td>".$res['id']."</td>";
                    echo "<td>".$fullName."</td>";
                    echo "<td>".htmlspecialchars($res['phone'])."</td>";
                    echo "<td>".htmlspecialchars($res['productname'])."</td>";
                    echo "<td>".$res['qunatity']."</td>";
                    echo "<td><strong style='color:#28a745;'>₹".htmlspecialchars($res['totalamount'])."</strong></td>";
                    echo "<td>".$address."</td>";
                    echo "<td><span style='text-transform:uppercase;'>".htmlspecialchars($res['payment'])."</span></td>";
                    
                    $statusColor = ($res['orderstatus'] == 'delivered') ? 'green' : (($res['orderstatus'] == 'pending' || empty($res['orderstatus'])) ? 'orange' : 'black');
                    $statusText = empty($res['orderstatus']) ? 'Pending' : ucfirst($res['orderstatus']);
                    echo "<td style='color:".$statusColor."; font-weight:bold;'>".$statusText."</td>";
                    
                    echo "<td><a href='orderedit.php?id=".$res['id']."' class='btn-action btn-update'><i class='bi bi-pencil-square'></i> Edit</a></td>";
                    echo "<td><a href='orderdelete.php?id=".$res['id']."' class='btn-action btn-delete' onclick=\"return confirm('Are you sure you want to delete?')\"><i class='bi bi-trash'></i> Delete</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        </div>
    </div>

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