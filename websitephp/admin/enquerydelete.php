<?php
include("configpage.php");

$id = intval($_GET['id']);
$result = mysqli_query($mysqli, "DELETE FROM enqueryi WHERE id=$id");
header("Location: enquiries.php");
?>
