<?php
include("configpage.php");

// Ensure the table exists dynamically
$tableQuery = "CREATE TABLE IF NOT EXISTS contact_us (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    mono VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($mysqli, $tableQuery);

if(isset($_POST['name'])){
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $mono = mysqli_real_escape_string($mysqli, $_POST['mono']);
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);

    $query = "INSERT INTO contact_us(name, mono, email) VALUES('$name', '$mono', '$email')";
    mysqli_query($mysqli, $query);
    
    echo "<script>alert('Your message has been sent successfully! Our team will contact you soon.'); window.location.href = 'contact us.php';</script>";
} else {
    header("Location: contact us.php");
}
?>
