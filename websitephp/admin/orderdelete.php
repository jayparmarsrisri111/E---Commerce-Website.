<?php
include("configpage.php");

$id=$_GET['id'];
$result=mysqli_query($mysqli,"DELETE FROM orderss WHERE id=$id");
header("Location: orderdisplay.php");
?>