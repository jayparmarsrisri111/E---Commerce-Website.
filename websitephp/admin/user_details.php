<?php
include_once("configpage.php");

if (!isset($_GET['email'])) {
    header("Location: users.php");
    exit();
}

$email = $_GET['email'];

$userQuery = "SELECT * FROM login WHERE email = '$email' LIMIT 1";
$userResult = mysqli_query($mysqli, $userQuery);
$user = mysqli_fetch_assoc($userResult);

if (!$user) {
    die("User not found.");
}

$orderQuery = "SELECT * FROM orderss WHERE email = '$email' ORDER BY id DESC";
$orderResult = mysqli_query($mysqli, $orderQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details - MARINE TRADERS</title>
    <link rel="icon" href="../image/LOGO.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/orderdisplay.css">
    <style>
        .details-container {
            background: rgba(255, 255, 255, 0.98);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); /* Premium shadow */
            margin-bottom: 30px;
            text-align: center;
        }
        .details-container h3 {
            margin-top: 0;
            border-bottom: 2px solid #eef2f5;
            padding-bottom: 15px;
            margin-bottom: 25px;
            color: #2c3e50;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: center;
        }
        .info-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            text-align: center;
        }
        .info-item {
            margin-bottom: 10px;
            flex: 1 1 200px;
            background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
            padding: 15px;
            border-radius: 10px;
            box-shadow: inset 0 2px 5px rgba(0,0,0,0.02), 0 3px 10px rgba(0,0,0,0.05);
            border: 1px solid #eef2f5;
            transition: transform 0.3s ease;
        }
        .info-item:hover {
            transform: translateY(-3px);
            box-shadow: inset 0 2px 5px rgba(0,0,0,0.02), 0 5px 15px rgba(0,0,0,0.08);
        }
        .info-item strong {
            display: block;
            color: #7f8c8d;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .info-item span {
            font-size: 16px;
            color: #2c3e50;
            font-weight: 600;
        }
        .btn-back {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            text-decoration: none;
            border-radius: 30px;
            transition: all 0.3s ease;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(42, 82, 152, 0.4);
        }
        .btn-back:hover {
            background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(42, 82, 152, 0.6);
        }

        /* Modern Standardized Table Styles */
        table {
            width: 100%;
            border-collapse: separate !important;
            border-spacing: 0;
            overflow: hidden;
            border-radius: 12px;
            margin: 0;
        }
        th {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
            color: #ffffff !important;
            text-align: center !important;
            padding: 18px 15px !important;
            font-size: 14px;
            letter-spacing: 1px;
            border: none !important;
            text-transform: uppercase;
        }
        td {
            text-align: center !important;
            padding: 16px 15px !important;
            vertical-align: middle !important;
            font-size: 15px;
            color: #444;
            border-bottom: 1px solid #f0f4f8 !important;
        }
        tbody tr {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
            background: white;
        }
        tbody tr:hover {
            background-color: #f8fbff !important;
            transform: translateY(-2px) scale(1.002) !important;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1) !important;
            z-index: 10;
            position: relative;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <?php include_once('includes/sidebar.php'); ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php include_once('includes/top_nav.php'); ?>
        <a href="users.php" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Users</a>
        
        <div class="details-container">
            <h3><i class="fas fa-user-circle"></i> User Complete Details</h3>
            <div class="info-grid">
                <div class="info-item">
                    <strong>First Name</strong>
                    <span><?php echo htmlspecialchars($user['firstname'] ?: 'N/A'); ?></span>
                </div>
                <div class="info-item">
                    <strong>Last Name</strong>
                    <span><?php echo htmlspecialchars($user['lastname'] ?: 'N/A'); ?></span>
                </div>
                <div class="info-item">
                    <strong>Email Address</strong>
                    <span><?php echo htmlspecialchars($user['email']); ?></span>
                </div>
                <div class="info-item">
                    <strong>Phone Number</strong>
                    <span><?php echo htmlspecialchars($user['phone'] ?: 'N/A'); ?></span>
                </div>
                <div class="info-item">
                    <strong>Registered ID</strong>
                    <span>#<?php echo htmlspecialchars($user['id']); ?></span>
                </div>
            </div>
        </div>

        <div class="details-container" style="padding: 20px; overflow-x: auto; text-align: center;">
            <h3 style="margin-bottom: 20px; color: #333; text-align: center;"><i class="fas fa-shopping-cart"></i> Associated Order History</h3>
            <table style="width: 100%; text-align: center; margin: 0 auto;">
                <thead>
                    <tr>
                        <th style="text-align: center !important; vertical-align: middle;">Order ID</th>
                        <th style="text-align: center !important; vertical-align: middle;">Product Name</th>
                        <th style="text-align: center !important; vertical-align: middle;">Quantity</th>
                        <th style="text-align: center !important; vertical-align: middle;">Amount</th>
                        <th style="text-align: center !important; vertical-align: middle;">Shipping Address</th>
                        <th style="text-align: center !important; vertical-align: middle;">Payment</th>
                        <th style="text-align: center !important; vertical-align: middle;">Status</th>
                        <th style="text-align: center !important; vertical-align: middle;">Bill</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($orderResult) > 0) {
                        while ($order = mysqli_fetch_assoc($orderResult)) {
                            echo "<tr>";
                            echo "<td style='text-align: center !important; vertical-align: middle;'><strong>#".$order['id']."</strong></td>";
                            echo "<td style='text-align: center !important; vertical-align: middle;'>".htmlspecialchars($order['productname'])."</td>";
                            echo "<td style='text-align: center !important; vertical-align: middle;'>".$order['qunatity']."</td>";
                            echo "<td style='text-align: center !important; vertical-align: middle;'><strong style='color:#28a745;'>₹".htmlspecialchars($order['totalamount'])."</strong></td>";
                            
                            $shippingAddress = htmlspecialchars($order['address']);
                            if(!empty($order['city'])) $shippingAddress .= ", " . htmlspecialchars($order['city']);
                            if(!empty($order['state'])) $shippingAddress .= ", " . htmlspecialchars($order['state']);
                            if(!empty($order['pincode'])) $shippingAddress .= " - " . htmlspecialchars($order['pincode']);
                            if(!empty($order['country'])) $shippingAddress .= ", " . htmlspecialchars($order['country']);
                            if(empty(trim($shippingAddress))) $shippingAddress = "<em style='color:#999;'>Not Provided</em>";

                            echo "<td style='text-align: center !important; vertical-align: middle;'>".$shippingAddress."</td>";
                            
                            $payment = empty($order['payment']) ? "<em style='color:#999;'>N/A</em>" : "<span style='text-transform:uppercase;'>".htmlspecialchars($order['payment'])."</span>";
                            echo "<td style='text-align: center !important; vertical-align: middle;'>".$payment."</td>";
                            
                            $status = empty($order['orderstatus']) ? "Pending" : htmlspecialchars($order['orderstatus']);
                            $statusColor = ($status == 'delivered' || strtolower($status) == 'completed') ? '#28a745' : '#f39c12';
                            echo "<td style='text-align: center !important; vertical-align: middle;'><span class='status-badge' style='background: rgba(".($statusColor=='#28a745'?'40,167,69':'243,156,18').", 0.1); color:".$statusColor.";'>".ucfirst($status)."</span></td>";
                            
                            echo "<td style='text-align: center !important; vertical-align: middle;'><a href='../bill.php?id=".$order['id']."' target='_blank' style='background: linear-gradient(135deg, #00c6ff 0%, #0072ff 100%); color:white; border-radius:30px; padding:6px 16px; text-decoration:none; display: inline-flex; align-items: center; justify-content: center; gap: 6px; font-size: 13px; font-weight: 700; box-shadow: 0 4px 10px rgba(0, 114, 255, 0.3); transition: all 0.3s ease; white-space: nowrap; text-transform: uppercase; letter-spacing: 0.5px;' onmouseover='this.style.transform=\"translateY(-2px)\"; this.style.boxShadow=\"0 6px 15px rgba(0, 114, 255, 0.5)\"' onmouseout='this.style.transform=\"translateY(0)\"; this.style.boxShadow=\"0 4px 10px rgba(0, 114, 255, 0.3)\"'><i class='fas fa-file-pdf'></i> Bill</a></td>";
                            
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' style='text-align:center !important; padding: 30px; color: #888;'><em>No orders found for this user.</em></td></tr>";
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
