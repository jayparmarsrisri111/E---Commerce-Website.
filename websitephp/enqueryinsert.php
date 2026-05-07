<?php
include("configpage.php");
if(isset($_POST['submit'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $product=$_POST['product'];
    $message=$_POST['message'];

    $result = mysqli_query($mysqli, "INSERT INTO enqueryi(name, email, phone, product, message) VALUES('$name', '$email', '$phone', '$product', '$message')");
   header("Location: Enquery form.php");

    }
?>