<?php
    $databaseHost = 'localhost';
    $databaseName = 'marinetraders';
    $databaseUsername = 'root';
    $databasePassword = '';

    $mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

    if ($mysqli) {
        $createCartTable = "CREATE TABLE IF NOT EXISTS `cart` (
          `id` INT AUTO_INCREMENT PRIMARY KEY,
          `email` VARCHAR(250) NOT NULL,
          `product_id` INT NOT NULL,
          `quantity` INT NOT NULL DEFAULT 1,
          `added_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          FOREIGN KEY (`product_id`) REFERENCES `product`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        mysqli_query($mysqli, $createCartTable);
    }
?>