<?php
session_start();

// ── Login check ──
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

use const Dom\HIERARCHY_REQUEST_ERR;

$databaseHost = 'localhost';
$databaseName = 'marinetraders';
$databaseUsername = 'root';
$databasePassword = '';

$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

if (!$mysqli) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {

    $firstname = $_POST['firstname'];
    $lastname  = $_POST['lastname'];
    $email     = $_POST['email'];
    $phone     = $_POST['phone'];
    $address   = $_POST['address'];
    $city      = $_POST['city'];
    $state     = $_POST['state'];
    $pincode   = $_POST['pincode'];
    $country   = $_POST['country'];
    $product   = $_POST['product'];
    $quantity  = $_POST['quantity'];
    
    // Server-side stock validation
    $title_esc = mysqli_real_escape_string($mysqli, $product);
    $q1 = mysqli_query($mysqli, "SELECT stock FROM product WHERE title='$title_esc'");
    $stock_row = mysqli_fetch_assoc($q1);
    $total_s = $stock_row['stock'] ?? 0;
    
    $q2 = mysqli_query($mysqli, "SELECT SUM(qunatity) as total FROM orderss WHERE productname='$title_esc'");
    $ord_row = mysqli_fetch_assoc($q2);
    $ordered_s = $ord_row['total'] ?? 0;
    
    $avail = $total_s - $ordered_s;
    if($quantity > $avail) {
        echo "<script>alert('Sorry, only " . $avail . " items are available in stock!'); window.history.back();</script>";
        exit;
    }
    $payment   = $_POST['payment'];
    $notes     = $_POST['notes'];
    $productn =$_POST['productn'];
    $totalamount =$_POST['totalamount'];
    $order_id = rand(10000, 99999);

    $query = "INSERT INTO orderss
    (firstname, lastname, email, phone, address, city, state, pincode, country, productname, qunatity, payment, notes,productn,totalamount)
    VALUES
    ('$firstname', '$lastname', '$email', '$phone', '$address', '$city', '$state', '$pincode', '$country', '$product', '$quantity', '$payment', '$notes','$productn','$totalamount')";

    if (mysqli_query($mysqli, $query)) {
    }
    $payment   = $_POST['payment'];
    $notes     = $_POST['notes'];
    $productn =$_POST['productn'];
    $totalamount =$_POST['totalamount'];
    $order_id = rand(10000, 99999);

    $query = "INSERT INTO orderss
    (firstname, lastname, email, phone, address, city, state, pincode, country, productname, qunatity, payment, notes,productn,totalamount)
    VALUES
    ('$firstname', '$lastname', '$email', '$phone', '$address', '$city', '$state', '$pincode', '$country', '$product', '$quantity', '$payment', '$notes','$productn','$totalamount')";

    if (mysqli_query($mysqli, $query)) {
        echo "<script>alert('Order placed successfully');</script>";
    } else {
        echo "Error: " . mysqli_error($mysqli);
    }
    
    if($payment == 'cod'){
        // Ensure proper redirection for COD
        header("Location: confirmation.php?order_id=$order_id&saleprice=$totalamount&payment=$payment");
    }
    else{
        // Properly encode parameters for redirect
        $customername = trim($firstname . ' ' . $lastname);
        $redirectUrl = 'payment.php?amount=' . urlencode($totalamount) . '&customername=' . urlencode($customername) . '&email=' . urlencode($email) . '&phone=' . urlencode($phone);
        header("Location: $redirectUrl");
    }
}
?>
