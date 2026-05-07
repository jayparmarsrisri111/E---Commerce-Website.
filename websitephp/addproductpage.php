<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
</head>
<body>
    <?php
    include("configpage.php");

    if(isset($_POST['submit'])){

    $id=$_POST['id'];
    $img=$_POST['img'];
    $title=$_POST['title'];
    $mrp=$_POST['mrp'];
    $salesprice=$_POST['salesprice'];
    $stock=$_POST['stock'];

    $filename = $_FILES['img']['name'];
    $tempname = $_FILES['img']['tmp_name'];
    $folder = "../image/".$filename;
    move_uploaded_file($tempname, $folder);

    $result=mysqli_query($mysqli,"INSERT INTO product(id, img, title, mrp, salesprice, stock)VALUES('$id','$filename','$title','$mrp','$salesprice','$stock')");
    echo"<font color='green'>data added successfully.</font>";
    
    }
    ?>
<?php include 'chatbot.php'; ?>
</body>
</html>
