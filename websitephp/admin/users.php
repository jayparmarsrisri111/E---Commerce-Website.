<?php
include_once("configpage.php");

$query = "SELECT * FROM login ORDER BY id DESC";
$result = mysqli_query($mysqli, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($mysqli));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users - MARINE TRADERS</title>
    <link rel="icon" href="../image/LOGO.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/orderdisplay.css">
    <style>
        /* Modern Premium Table Styling for Users Page */
        .main-content h2 {
            text-align: center;
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 30px !important;
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .table-responsive {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 40px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: separate !important;
            border-spacing: 0;
            overflow: hidden;
            border-radius: 12px;
        }

        th {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
            color: #ffffff !important;
            text-align: center !important;
            padding: 18px 15px !important;
            font-size: 14px;
            letter-spacing: 1px;
            border: none !important;
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
        }

        tbody tr:hover {
            background-color: #f8fbff !important;
            transform: translateY(-2px) scale(1.005) !important;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1) !important;
            z-index: 10;
            position: relative;
        }

        /* View Orders Button Premium Styling */
        .btn-view {
            padding: 8px 16px;
            background: linear-gradient(135deg, #00c6ff 0%, #0072ff 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 114, 255, 0.3);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-view:hover {
            background: linear-gradient(135deg, #0072ff 0%, #00c6ff 100%);
            box-shadow: 0 6px 20px rgba(0, 114, 255, 0.5);
            transform: translateY(-2px);
            color: white;
        }

        /* details card inside row */
        .details-card {
            background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 12px;
            padding: 25px;
            box-shadow: inset 0 2px 10px rgba(0,0,0,0.02), 0 5px 20px rgba(0,0,0,0.05);
            margin: 10px 0;
            border: 1px solid #eef2f5;
        }

        .details-card h4 {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #eef2f5;
            padding-bottom: 10px;
            text-align: left;
        }

        .details-badge {
            background: linear-gradient(45deg, #11998e, #38ef7d);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 13px;
            box-shadow: 0 2px 8px rgba(56, 239, 125, 0.3);
        }

        .sub-table th {
            background: #f1f4f8 !important;
            color: #444 !important;
        }
        .sub-table td {
            background: #ffffff !important;
        }

        /* Mobile Card Layout */
        @media (max-width: 576px) {
            .table-responsive { overflow-x: hidden; border: none; background: transparent; box-shadow: none; padding: 0;}
            table { display: block; border: none; background: transparent; box-shadow: none; }
            table thead { display: none; }
            table tbody { display: block; width: 100%; }
            table tbody tr {
                display: flex;
                flex-direction: column;
                margin-bottom: 20px;
                background: #fff;
                border: 1px solid rgba(226, 232, 240, 0.8);
                box-shadow: 0 4px 12px rgba(0,0,0,0.05);
                border-radius: 12px;
                padding: 10px 15px;
            }
            table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border: none !important;
                padding: 10px 0 !important;
                text-align: right !important;
                border-bottom: 1px dashed #e2e8f0 !important;
                font-size: 0.85rem;
            }
            table td:last-child { border-bottom: none !important; }
            table td::before {
                content: attr(data-label);
                font-weight: 700;
                color: #64748b;
                text-align: left;
                text-transform: uppercase;
                font-size: 0.8rem;
                flex-basis: 40%;
            }
            table td > * {
                flex-basis: 60%;
                text-align: right;
            }
            .btn-view { padding: 6px 12px; font-size: 0.75rem; display: inline-flex; }
        }
    </style>
</head>
<body>
    <?php include_once("includes/sidebar.php"); ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php include_once("includes/top_nav.php"); ?>
        <div class="table-responsive">
        <h2 style="margin-bottom: 20px; color: #333;"><i class="fas fa-users"></i> All Users Details</h2>
        <table style="min-width: 1000px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email Address</th>
                    <th>Phone</th>
                    <th>Password</th>
                    <th>Total Orders</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($res = mysqli_fetch_assoc($result)) {
                    $userEmail = mysqli_real_escape_string($mysqli, $res['email']);
                    
                    // Fetch orders for this user
                    $orderQuery = "SELECT * FROM orderss WHERE email = '$userEmail' ORDER BY id DESC";
                    $orderResult = mysqli_query($mysqli, $orderQuery);
                    $orderCount = mysqli_num_rows($orderResult);

                    // Reconstruct missing details from orders for "old login" users
                    $d_firstname = $res['firstname'];
                    $d_lastname = $res['lastname'];
                    $d_phone = $res['phone'];
                    if (empty(trim($d_firstname)) && $orderCount > 0) {
                        // Grab details from the most recent order
                        mysqli_data_seek($orderResult, 0); // Reset pointer
                        $latest_order = mysqli_fetch_assoc($orderResult);
                        $d_firstname = !empty($latest_order['firstname']) ? $latest_order['firstname'] : '';
                        $d_lastname = !empty($latest_order['lastname']) ? $latest_order['lastname'] : '';
                        $d_phone = !empty($latest_order['phone']) ? $latest_order['phone'] : '';
                        mysqli_data_seek($orderResult, 0); // Reset pointer again for the orders loop below
                    }

                    $d_firstname_display = !empty(trim($d_firstname)) ? htmlspecialchars($d_firstname) : "<em style='color:#999'>N/A</em>";
                    $d_lastname_display = !empty(trim($d_lastname)) ? htmlspecialchars($d_lastname) : "<em style='color:#999'>N/A</em>";
                    $d_phone_display = !empty(trim($d_phone)) ? htmlspecialchars($d_phone) : "<em style='color:#999'>N/A</em>";

                    echo "<tr>";
                    echo "<td data-label='ID'>".$res['id']."</td>";
                    echo "<td data-label='First Name'>".$d_firstname_display."</td>";
                    echo "<td data-label='Last Name'>".$d_lastname_display."</td>";
                    echo "<td data-label='Email Address'>".htmlspecialchars($res['email'])."</td>";
                    echo "<td data-label='Phone'>".$d_phone_display."</td>";
                    echo "<td data-label='Password'>".htmlspecialchars($res['password'])."</td>";
                    echo "<td data-label='Total Orders'><span class='details-badge'>".$orderCount."</span></td>";
                    echo "<td data-label='Action'>";
                    echo "<a href='user_details.php?email=".urlencode($res['email'])."' class='btn-view'><i class='fas fa-eye'></i> View Orders</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                if (mysqli_num_rows($result) == 0) {
                    echo "<tr><td colspan='8' style='text-align:center; padding: 20px;'>No users found</td></tr>";
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
