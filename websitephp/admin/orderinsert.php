<?php
include "configpage.php";   // database connection file

if (isset($_POST['submit'])) {

    $firstname   = $_POST['firstname'];
    $lastname    = $_POST['lastname'];
    $email       = $_POST['email'];
    $phone       = $_POST['phone'];
    $address     = $_POST['address'];
    $city        = $_POST['city'];
    $state       = $_POST['state'];
    $pincode     = $_POST['pincode'];
    $country     = $_POST['country'];
    $productname = $_POST['productname'];
    $quantity    = $_POST['quantity'];
    $payment     = $_POST['payment'];
    $notes       = $_POST['notes'];
    $orderstatus  =$_POST['orderstatus'];

    $sql = "INSERT INTO orderss
    (firstname, lastname, email, phone, address, city, state, pincode, country, productname, quantity, payment, notes, orderstatus)
    VALUES
    ('$firstname','$lastname','$email','$phone','$address','$city','$state','$pincode','$country','$productname','$quantity','$payment','$notes')";

    if (mysqli_query($conn, $sql)) {
        header("Location: ordersuccess.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
