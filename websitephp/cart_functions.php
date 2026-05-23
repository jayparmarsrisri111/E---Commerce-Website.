<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($mysqli)) {
    include_once("configpage.php");
}

/**
 * Sync session-based cart items to database cart after successful login/signup.
 */
function syncCartAfterLogin($email, $mysqli) {
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $email_esc = mysqli_real_escape_string($mysqli, $email);
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $product_id = (int)$product_id;
            $quantity = (int)$quantity;
            
            // Check if product exists in DB cart
            $check = mysqli_query($mysqli, "SELECT * FROM cart WHERE email='$email_esc' AND product_id=$product_id");
            if (mysqli_num_rows($check) > 0) {
                // Update quantity
                mysqli_query($mysqli, "UPDATE cart SET quantity = quantity + $quantity WHERE email='$email_esc' AND product_id=$product_id");
            } else {
                // Insert
                mysqli_query($mysqli, "INSERT INTO cart (email, product_id, quantity) VALUES ('$email_esc', $product_id, $quantity)");
            }
        }
        // Clear session cart
        unset($_SESSION['cart']);
    }
}

/**
 * Get total quantity of items in the cart.
 */
function getCartCount($mysqli) {
    if (isset($_SESSION['email'])) {
        $email = mysqli_real_escape_string($mysqli, $_SESSION['email']);
        $res = mysqli_query($mysqli, "SELECT SUM(quantity) as total FROM cart WHERE email='$email'");
        if ($res) {
            $row = mysqli_fetch_assoc($res);
            return (int)($row['total'] ?? 0);
        }
    } else {
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            return (int)array_sum($_SESSION['cart']);
        }
    }
    return 0;
}
?>
