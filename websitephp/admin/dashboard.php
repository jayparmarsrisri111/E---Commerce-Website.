<?php
    mysqli_report(MYSQLI_REPORT_OFF);
    $databaseHost = 'localhost';
    $databaseName = 'marinetraders';
    $databaseUsername = 'root';
    $databasePassword = '';

    $mysqli = @mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);
    
    if (!$mysqli) {
        die("<!DOCTYPE html><html><head><title>Database Error</title><style>body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8f9fa; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; } .error-container { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; max-width: 500px; } .error-icon { font-size: 50px; color: #dc3545; margin-bottom: 20px; } h2 { color: #343a40; margin-top: 0; } p { color: #6c757d; line-height: 1.5; } .btn-refresh { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; font-weight: 600; }</style></head><body><div class='error-container'><div class='error-icon'>&#9888;&#65039;</div><h2>Database Connection Error</h2><p>Our system could not connect to the database.</p><p><strong>Note for Admin</strong>: It seems the MySQL Server is not running. Please open your <strong>XAMPP Control Panel</strong> and start the <strong>MySQL</strong> module.</p><p style='font-size: 12px; margin-top: 15px;'>Technical Details: " . mysqli_connect_error() . "</p><a href='' class='btn-refresh'>Try Again</a></div></body></html>");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - MARINE TRADERS</title>
    <link rel="icon" href="../image/LOGO.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/recent_orders.css">
</head>

<body>
    <?php include_once("includes/sidebar.php"); ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php include_once("includes/top_nav.php"); ?>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card primary" onclick="window.location.href='displayform.php';" style="cursor: pointer;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <div class="stat-label" style="font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Total Products</div>
                        <?php $totalProducts=$mysqli->query("SELECT COUNT(*) AS total FROM product")->fetch_assoc()['total'];?>
                        <div class="stat-value" style="font-size: 34px; margin-top: 5px;"><?php echo $totalProducts;?></div>
                    </div>
                    <div class="stat-icon" style="margin-bottom: 0; box-shadow: 0 6px 12px rgba(102, 126, 234, 0.3);">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
                <div class="stat-change positive" style="margin-top: 15px; display: flex; align-items: center; gap: 6px; font-weight: 600;">
                    <i class="fas fa-arrow-up"></i> <span>Live Sync</span>
                </div>
            </div>

            <div class="stat-card success" onclick="window.location.href='orderdisplay.php';" style="cursor: pointer;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <div class="stat-label" style="font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Total Orders</div>
                        <?php $totalOrders=$mysqli->query("SELECT COUNT(*) AS total FROM orderss")->fetch_assoc()['total'];?>
                        <div class="stat-value" style="font-size: 34px; margin-top: 5px;"><?php echo $totalOrders;?></div>
                    </div>
                    <div class="stat-icon" style="margin-bottom: 0; box-shadow: 0 6px 12px rgba(40, 167, 69, 0.3);">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
                <div class="stat-change positive" style="margin-top: 15px; display: flex; align-items: center; gap: 6px; font-weight: 600;">
                    <i class="fas fa-arrow-up"></i> <span>Updated Tracking</span>
                </div>
            </div>

            <div class="stat-card warning" onclick="window.location.href='dashboard.php';" style="cursor: pointer;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <div class="stat-label" style="font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Total Revenue</div>
                        <?php $totalRevenue=$mysqli->query("SELECT SUM(totalamount) AS total FROM orderss")->fetch_assoc()['total'];?>
                        <div class="stat-value" style="font-size: 34px; margin-top: 5px;">₹<?php echo number_format($totalRevenue, 2);?></div>
                    </div>
                    <div class="stat-icon" style="margin-bottom: 0; box-shadow: 0 6px 12px rgba(255, 193, 7, 0.3);">
                        <i class="fas fa-rupee-sign"></i>
                    </div>
                </div>
                <div class="stat-change positive" style="margin-top: 15px; display: flex; align-items: center; gap: 6px; font-weight: 600;">
                    <i class="fas fa-arrow-up"></i> <span>Lifetime Total</span>
                </div>
            </div>
        </div>

        <?php
        // Fetch Data for Charts
        $orderCountQuery = "SELECT productname, COUNT(*) as count FROM orderss GROUP BY productname";
        $orderCountResult = mysqli_query($mysqli, $orderCountQuery);
        $productNamesCount = [];
        $orderCounts = [];
        if($orderCountResult){
            while($row = mysqli_fetch_assoc($orderCountResult)){
                $productNamesCount[] = $row['productname'] ? ucwords(strtolower($row['productname'])) : 'Unknown';
                $orderCounts[] = $row['count'];
            }
        }

        $revenueQuery = "SELECT productname, SUM(totalamount) as revenue FROM orderss GROUP BY productname";
        $revenueResult = mysqli_query($mysqli, $revenueQuery);
        $productNamesRev = [];
        $revenues = [];
        if($revenueResult){
            while($row = mysqli_fetch_assoc($revenueResult)){
                $productNamesRev[] = $row['productname'] ? ucwords(strtolower($row['productname'])) : 'Unknown';
                $revenues[] = $row['revenue'];
            }
        }
        ?>

        <!-- Charts Section -->
        <div class="charts-grid">
            <div class="chart-card" style="display: flex; flex-direction: column;">
                <h2 class="section-title">
                    <i class="fas fa-chart-pie me-2"></i>Orders by Product
                </h2>
                <div class="chart-container" style="height: 250px; flex: none;">
                    <canvas id="ordersChart"></canvas>
                </div>
                <div id="ordersLegend" class="chart-legend-custom" style="padding: 15px 0 0 0; max-height: 220px; overflow-y: auto;"></div>
            </div>
            <div class="chart-card" style="display: flex; flex-direction: column;">
                <h2 class="section-title">
                    <i class="fas fa-chart-bar me-2"></i>Revenue by Product
                </h2>
                <div class="chart-container" style="height: 250px; flex: none;">
                    <canvas id="revenueChart"></canvas>
                </div>
                <div id="revenueLegend" class="chart-legend-custom" style="padding: 15px 0 0 0; max-height: 220px; overflow-y: auto;"></div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h2 class="section-title">
                <i class="fas fa-bolt me-2"></i>Quick Actions
            </h2>
            <div class="action-buttons">
                <a href="form.php" class="action-btn primary">
                    <i class="fas fa-plus-circle"></i>
                    <span>Add New Product</span>
                </a>
                <a href="orderdisplay.php" class="action-btn success">
                    <i class="fas fa-eye"></i>
                    <span>View Orders</span>
                </a>
        </div>

        <!-- Recent Activity -->
        <div class="recent-activity">
            <h2 class="section-title">
                <i class="fas fa-clock me-2"></i>Recent Activity
            </h2>
           <?php
            $query = "SELECT * FROM orderss LIMIT 10";
            $result = mysqli_query($mysqli, $query);

            if (!$result) {
                die("Query Failed: " . mysqli_error($mysqli));
            }
            ?>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Phone</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($res = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>".htmlspecialchars($res['firstname'])."</td>";
                            echo "<td>".htmlspecialchars($res['lastname'])."</td>";
                            echo "<td>".htmlspecialchars($res['phone'])."</td>";
                            echo "<td>".htmlspecialchars($res['productname'])."</td>";
                            echo "<td>".htmlspecialchars($res['qunatity'])."</td>";
                            echo "<td>".htmlspecialchars($res['payment'])."</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
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

        // Chart render logic
        document.addEventListener("DOMContentLoaded", function () {
            // Data from PHP
            // Use json_encode safely to handle any special characters
            const productNamesCount = <?php echo json_encode($productNamesCount); ?> || [];
            const orderCounts = <?php echo json_encode($orderCounts); ?> || [];
            
            const productNamesRev = <?php echo json_encode($productNamesRev); ?> || [];
            const revenues = <?php echo json_encode($revenues); ?> || [];

            // Helper for dynamic colors
            function generateColors(count) {
                const colors = [];
                // Standard distinct pleasant colors for pie chart
                const baseColors = [
                    'rgba(102, 126, 234, 0.85)',
                    'rgba(118, 75, 162, 0.85)',
                    'rgba(40, 167, 69, 0.85)',
                    'rgba(255, 193, 7, 0.85)',
                    'rgba(23, 162, 184, 0.85)',
                    'rgba(220, 53, 69, 0.85)'
                ];
                
                for(let i = 0; i < count; i++) {
                    if (i < baseColors.length) {
                        colors.push(baseColors[i]);
                    } else {
                        const r = Math.floor(Math.random() * 150 + 50);
                        const g = Math.floor(Math.random() * 150 + 50);
                        const b = Math.floor(Math.random() * 150 + 50);
                        colors.push(`rgba(${r}, ${g}, ${b}, 0.85)`);
                    }
                }
                return colors;
            }

            const pieColors = generateColors(productNamesCount.length);

            // Orders Chart
            const ctxOrders = document.getElementById('ordersChart');
            let ordersChartInstance = null;
            if(ctxOrders) {
                ordersChartInstance = new Chart(ctxOrders.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: productNamesCount,
                        datasets: [{
                            label: 'Number of Orders',
                            data: orderCounts,
                            backgroundColor: pieColors,
                            borderWidth: 2,
                            borderColor: '#ffffff',
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            animateScale: true,
                            animateRotate: true,
                            duration: 1500,
                            easing: 'easeOutQuart'
                        },
                        layout: {
                            padding: { bottom: 0 }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                titleFont: { size: 14, family: "'Segoe UI', Tahoma, sans-serif" },
                                bodyFont: { size: 13, family: "'Segoe UI', Tahoma, sans-serif" },
                                padding: 10,
                                cornerRadius: 8
                            }
                        }
                    }
                });

                // Custom Legend Generator for Orders Chart
                const legendContainer = document.getElementById('ordersLegend');
                if (legendContainer) {
                    let legendHTML = '<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">';
                    productNamesCount.forEach((name, index) => {
                        const count = orderCounts[index];
                        legendHTML += `
                            <div class="custom-legend-item-orders" data-index="${index}" style="display: flex; align-items: center; justify-content: space-between; font-size: 13px; font-weight: 600; color: #212529; padding: 5px; background: rgba(102, 126, 234, 0.05); border-radius: 6px; cursor: pointer; transition: all 0.3s ease;">
                                <div style="display: flex; align-items: center; overflow: hidden;">
                                    <span style="min-width: 12px; height: 12px; background-color: ${pieColors[index]}; border-radius: 50%; display: inline-block; margin-right: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.2);"></span>
                                    <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 120px;" title="${name}">${name}</span>
                                </div>
                                <span style="color: #6c757d; font-size: 11px; margin-left: 5px; font-weight: 700;">${count}</span>
                            </div>
                        `;
                    });
                    legendHTML += '</div>';
                    legendContainer.innerHTML = legendHTML;

                    // Add dynamic interactions
                    document.querySelectorAll('.custom-legend-item-orders').forEach(item => {
                        item.addEventListener('mouseenter', (e) => {
                            const index = parseInt(e.currentTarget.getAttribute('data-index'));
                            ordersChartInstance.setActiveElements([{datasetIndex: 0, index: index}]);
                            ordersChartInstance.tooltip.setActiveElements([{datasetIndex: 0, index: index}]);
                            ordersChartInstance.update();
                            e.currentTarget.style.background = 'rgba(102, 126, 234, 0.2)';
                            e.currentTarget.style.transform = 'scale(1.02)';
                        });
                        item.addEventListener('mouseleave', (e) => {
                            ordersChartInstance.setActiveElements([]);
                            ordersChartInstance.tooltip.setActiveElements([]);
                            ordersChartInstance.update();
                            e.currentTarget.style.background = 'rgba(102, 126, 234, 0.05)';
                            e.currentTarget.style.transform = 'scale(1)';
                        });
                    });
                }
            }

            // Revenue Chart
            const ctxRevenue = document.getElementById('revenueChart');
            let revenueChartInstance = null;
            if (ctxRevenue) {
                revenueChartInstance = new Chart(ctxRevenue.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: productNamesRev,
                        datasets: [{
                            label: 'Revenue (₹)',
                            data: revenues,
                            backgroundColor: pieColors,
                            hoverBackgroundColor: pieColors.map(color => color.replace(/rgba\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*,[\s\d.]+\)/, (m, r, g, b) => `rgba(${Math.floor(r * 0.6)}, ${Math.floor(g * 0.6)}, ${Math.floor(b * 0.6)}, 1)`)),
                            borderRadius: 6,
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 1500,
                            easing: 'easeOutQuart'
                        },
                        layout: {
                            padding: { top: 10, bottom: 0 }
                        },
                        scales: {
                            x: {
                                ticks: { display: false },
                                border: { display: false },
                                grid: { display: false }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    font: {
                                        size: 11,
                                        family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif",
                                        weight: '500'
                                    },
                                    color: '#6c757d',
                                    callback: function(value) {
                                        return '₹' + value.toLocaleString('en-IN');
                                    }
                                },
                                border: { dash: [4, 4] },
                                grid: { color: '#e9ecef', drawBorder: false }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                titleFont: { size: 14, family: "'Segoe UI', Tahoma, sans-serif" },
                                bodyFont: { size: 13, family: "'Segoe UI', Tahoma, sans-serif", weight: 'bold' },
                                padding: 12,
                                cornerRadius: 8,
                                displayColors: false,
                                callbacks: {
                                    title: function(context) { return context[0].label; },
                                    label: function(context) {
                                        return 'Revenue: ₹' + parseFloat(context.raw).toLocaleString('en-IN');
                                    }
                                }
                            }
                        }
                    }
                });

                // Custom Legend Generator for Revenue Chart
                const revLegendContainer = document.getElementById('revenueLegend');
                if (revLegendContainer) {
                    let legendHTML = '<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">';
                    productNamesRev.forEach((name, index) => {
                        const amount = revenues[index];
                        const colorIndex = index % pieColors.length;
                        legendHTML += `
                            <div class="custom-legend-item-revenue" data-index="${index}" style="display: flex; align-items: center; justify-content: space-between; font-size: 13px; font-weight: 600; color: #212529; padding: 5px; background: rgba(102, 126, 234, 0.05); border-radius: 6px; cursor: pointer; transition: all 0.3s ease;">
                                <div style="display: flex; align-items: center; overflow: hidden;">
                                    <span style="min-width: 12px; height: 12px; background-color: ${pieColors[colorIndex]}; border-radius: 50%; display: inline-block; margin-right: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.2);"></span>
                                    <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 120px;" title="${name}">${name}</span>
                                </div>
                                <span style="color: #667eea; font-size: 11px; margin-left: 5px; font-weight: 700;">₹${parseFloat(amount).toLocaleString('en-IN')}</span>
                            </div>
                        `;
                    });
                    legendHTML += '</div>';
                    revLegendContainer.innerHTML = legendHTML;

                    // Add dynamic interactions
                    document.querySelectorAll('.custom-legend-item-revenue').forEach(item => {
                        item.addEventListener('mouseenter', (e) => {
                            const index = parseInt(e.currentTarget.getAttribute('data-index'));
                            revenueChartInstance.setActiveElements([{datasetIndex: 0, index: index}]);
                            revenueChartInstance.tooltip.setActiveElements([{datasetIndex: 0, index: index}]);
                            revenueChartInstance.update();
                            e.currentTarget.style.background = 'rgba(102, 126, 234, 0.2)';
                            e.currentTarget.style.transform = 'scale(1.02)';
                        });
                        item.addEventListener('mouseleave', (e) => {
                            revenueChartInstance.setActiveElements([]);
                            revenueChartInstance.tooltip.setActiveElements([]);
                            revenueChartInstance.update();
                            e.currentTarget.style.background = 'rgba(102, 126, 234, 0.05)';
                            e.currentTarget.style.transform = 'scale(1)';
                        });
                    });
                }
            }
        });
    </script>
</body>
</html>