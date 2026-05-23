<?php
include("configpage.php");
if(isset($_POST['submit'])){
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = mysqli_query($mysqli, "INSERT INTO login(email, password) VALUES('$email', '$password')");
   header("Location: index.php");
   
    }
    ?>