<?php
include("configpage.php");

$id = intval($_GET['id']);
$result = mysqli_query($mysqli, "DELETE FROM contact_us WHERE id=$id");
header("Location: contact_messages.php");
?>
