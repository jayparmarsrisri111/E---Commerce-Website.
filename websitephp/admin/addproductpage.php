<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
</head>
<body>
    <?php
    include("configpage.php");

    if(isset($_POST['submit'])){
    
    $id = $_POST['id'];
    $title = $_POST['title'];
    $mrp = $_POST['mrp'];
    $saleprice = $_POST['saleprice'];
    $stock = $_POST['stock'];
    $category = $_POST['category'];
    $filename = $_FILES['img']['name'];
    $tempname = $_FILES['img']['tmp_name']; // temporary file name on server
    $folder = "../image/".$filename;
    move_uploaded_file($tempname, $folder);

    $result = mysqli_query($mysqli, "INSERT INTO product(id, img, title, mrp, saleprice, stock, category) VALUES('$id', '$folder', '$title', '$mrp', '$saleprice', '$stock', '$category')");
   header("Location: displayform.php");
   
    }
    ?>
</body>
</html>