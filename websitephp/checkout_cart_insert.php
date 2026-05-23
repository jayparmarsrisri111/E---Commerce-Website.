<?php
session_start();
include_once("configpage.php");

// ── Login check ──
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['submit'])) {
    $firstname = mysqli_real_escape_string($mysqli, $_POST['firstname']);
    $lastname  = mysqli_real_escape_string($mysqli, $_POST['lastname']);
    $email     = mysqli_real_escape_string($mysqli, $_POST['email']);
    $phone     = mysqli_real_escape_string($mysqli, $_POST['phone']);
    $address   = mysqli_real_escape_string($mysqli, $_POST['address']);
    $city      = mysqli_real_escape_string($mysqli, $_POST['city']);
    $state     = mysqli_real_escape_string($mysqli, $_POST['state']);
    $pincode   = mysqli_real_escape_string($mysqli, $_POST['pincode']);
    $country   = mysqli_real_escape_string($mysqli, $_POST['country']);
    $payment   = mysqli_real_escape_string($mysqli, $_POST['payment']);
    $notes     = mysqli_real_escape_string($mysqli, $_POST['notes']);

    // Fetch cart items
    $cart_items = [];
    $cart_q = mysqli_query($mysqli, "SELECT c.*, p.title, p.saleprice, p.stock FROM cart c JOIN product p ON c.product_id = p.id WHERE c.email = '$email'");
    
    while ($row = mysqli_fetch_assoc($cart_q)) {
        $cart_items[] = $row;
    }

    if (empty($cart_items)) {
        $_SESSION['cart_error'] = "Your cart is empty!";
        header("Location: cart.php");
        exit();
    }

    // 1. Server-side stock validation for ALL items before placing any order
    foreach ($cart_items as $item) {
        $title_esc = mysqli_real_escape_string($mysqli, $item['title']);
        
        $stock_q = mysqli_query($mysqli, "SELECT SUM(qunatity) as total FROM orderss WHERE productname='$title_esc'");
        $ord_row = mysqli_fetch_assoc($stock_q);
        $ordered_s = $ord_row['total'] ?? 0;
        
        $available_stock = $item['stock'] - $ordered_s;
        
        if ($item['quantity'] > $available_stock) {
            $_SESSION['cart_error'] = "Sorry, only " . ($available_stock > 0 ? $available_stock : 0) . " units are available for " . $item['title'] . ". Please adjust quantity.";
            header("Location: cart.php");
            exit();
        }
    }

    // 2. Perform order placement for each item
    $total_combined_amount = 0;
    $last_order_id = 0;

    foreach ($cart_items as $item) {
        $productname = mysqli_real_escape_string($mysqli, $item['title']);
        $quantity = (int)$item['quantity'];
        $item_total = $item['saleprice'] * $quantity;
        $total_combined_amount += $item_total;
        
        $order_id = rand(10000, 99999);
        $last_order_id = $order_id; // Store to pass to confirmation page if COD

        $query = "INSERT INTO orderss
        (firstname, lastname, email, phone, address, city, state, pincode, country, productname, qunatity, payment, notes, productn, totalamount, orderstatus)
        VALUES
        ('$firstname', '$lastname', '$email', '$phone', '$address', '$city', '$state', '$pincode', '$country', '$productname', '$quantity', '$payment', '$notes', '$productname', '$item_total', 'pending')";
        
        mysqli_query($mysqli, $query);
    }

    // 3. Clear user's cart
    mysqli_query($mysqli, "DELETE FROM cart WHERE email = '$email'");

    // 4. Redirect based on payment type
    if ($payment == 'cod') {
        header("Location: confirmation.php?order_id=$last_order_id&saleprice=$total_combined_amount&payment=$payment");
    } else {
        header("Location: payment.php?amount=$total_combined_amount&customername=" . urlencode("$firstname $lastname") . "&email=$email&phone=$phone");
    }
    exit();
}

header("Location: cart.php");
exit();
?>
