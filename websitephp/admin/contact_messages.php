<?php
include_once("configpage.php");

// Ensure table exists safely from admin panel side just in case
$tableQuery = "CREATE TABLE IF NOT EXISTS contact_us (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    mono VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($mysqli, $tableQuery);

$query = "SELECT * FROM contact_us ORDER BY id DESC";
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
    <title>Contact Messages - MARINE TRADERS</title>
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
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Mobile No</th>
                    <th>Email Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($res = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>".$res['id']."</td>";
                    echo "<td>".htmlspecialchars($res['name'])."</td>";
                    echo "<td>".htmlspecialchars($res['mono'])."</td>";
                    echo "<td>".htmlspecialchars($res['email'])."</td>";
                    echo "<td><a href='contactdelete.php?id=".$res['id']."' class='btn-action btn-delete' onclick=\"return confirm('Are you sure you want to delete this contact message?')\"><i class='bi bi-trash'></i> Delete</a></td>";
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
