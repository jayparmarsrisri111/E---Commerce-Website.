<?php
session_start();
include("configpage.php");
if(isset($_POST['submit'])){
    
    $firstname = mysqli_real_escape_string($mysqli, trim($_POST['firstname']));
    $lastname = mysqli_real_escape_string($mysqli, trim($_POST['lastname']));
    $email = mysqli_real_escape_string($mysqli, trim($_POST['email']));
    $phone = mysqli_real_escape_string($mysqli, trim($_POST['phone']));
    $confirmpassword = password_hash($_POST['confirmpassword'], PASSWORD_DEFAULT);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if user already exists to prevent duplicate emails and failure in login
    $check_query = "SELECT * FROM login WHERE email='$email'";
    $check_result = mysqli_query($mysqli, $check_query);

    if(mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Email already exists! Please just login.'); window.location.href='login.php';</script>";
        exit();
    }

    $result = mysqli_query($mysqli, "INSERT INTO login(firstname, lastname, email, phone, confirmpassword, password) VALUES('$firstname', '$lastname', '$email', '$phone', '$confirmpassword', '$password')");
    if($result) {
        $_SESSION['email'] = $email;
        if(!isset($mysqli)) { include_once("configpage.php"); }
        include_once("cart_functions.php");
        syncCartAfterLogin($email, $mysqli);
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Error registering account. Please try again.'); window.location.href='signup.php';</script>";
        exit();
    }
}
?>