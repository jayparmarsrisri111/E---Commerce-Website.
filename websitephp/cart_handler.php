<?php
session_start();
include_once("configpage.php");

$action = $_GET['action'] ?? '';
$product_id = (int)($_GET['product_id'] ?? 0);
$quantity = (int)($_GET['quantity'] ?? 1);
if ($quantity < 1) $quantity = 1;

// Get referring URL for redirecting back if needed
$referrer = $_SERVER['HTTP_REFERER'] ?? 'pr.php';

// Avoid circular redirections to cart.php
if (strpos($referrer, 'cart.php') !== false) {
    $referrer = 'pr.php';
}

if ($action == 'add' && $product_id > 0) {
    // Check if product exists in DB and is in stock
    $prod_q = mysqli_query($mysqli, "SELECT * FROM product WHERE id = $product_id");
    $product = mysqli_fetch_assoc($prod_q);
    
    if ($product) {
        // Stock check
        $ptitle = $product['title'];
        $stock_q = mysqli_query($mysqli, "SELECT SUM(qunatity) AS total FROM orderss WHERE productname='$ptitle'");
        $ordered_stock = 0;
        if ($stock_q && mysqli_num_rows($stock_q) > 0) {
            $ordered_stock = mysqli_fetch_assoc($stock_q)['total'] ?? 0;
        }
        $available_stock = $product['stock'] - $ordered_stock;
        
        if ($available_stock <= 0) {
            $_SESSION['cart_error'] = "Sorry, " . $product['title'] . " is currently out of stock!";
            header("Location: " . $referrer);
            exit();
        }

        // If logged in, save to DB
        if (isset($_SESSION['email'])) {
            $email = mysqli_real_escape_string($mysqli, $_SESSION['email']);
            
            // Check if already in cart
            $check = mysqli_query($mysqli, "SELECT * FROM cart WHERE email='$email' AND product_id=$product_id");
            if (mysqli_num_rows($check) > 0) {
                $cart_item = mysqli_fetch_assoc($check);
                $new_qty = $cart_item['quantity'] + $quantity;
                if ($new_qty > $available_stock) {
                    $new_qty = $available_stock;
                    $_SESSION['cart_error'] = "You've reached the maximum available stock for " . htmlspecialchars($product['title']) . ".";
                    $_SESSION['cart_success'] = null; // Clear success if error
                } else {
                    $_SESSION['cart_success'] = "Added " . htmlspecialchars($product['title']) . " to cart successfully!";
                }
                mysqli_query($mysqli, "UPDATE cart SET quantity = $new_qty WHERE email='$email' AND product_id=$product_id");
            } else {
                if ($quantity > $available_stock) {
                    $quantity = $available_stock;
                    $_SESSION['cart_error'] = "Only " . $available_stock . " available in stock.";
                } else {
                    $_SESSION['cart_success'] = "Added " . htmlspecialchars($product['title']) . " to cart successfully!";
                }
                mysqli_query($mysqli, "INSERT INTO cart (email, product_id, quantity) VALUES ('$email', $product_id, $quantity)");
            }
        } else {
            // Save to session cart
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
            }
            if (isset($_SESSION['cart'][$product_id])) {
                $new_qty = $_SESSION['cart'][$product_id] + $quantity;
                if ($new_qty > $available_stock) {
                    $_SESSION['cart'][$product_id] = $available_stock;
                    $_SESSION['cart_error'] = "You've reached the maximum available stock for " . htmlspecialchars($product['title']) . ".";
                } else {
                    $_SESSION['cart'][$product_id] = $new_qty;
                    $_SESSION['cart_success'] = "Added " . htmlspecialchars($product['title']) . " to cart successfully!";
                }
            } else {
                if ($quantity > $available_stock) {
                    $_SESSION['cart'][$product_id] = $available_stock;
                    $_SESSION['cart_error'] = "Only " . $available_stock . " available in stock.";
                } else {
                    $_SESSION['cart'][$product_id] = $quantity;
                    $_SESSION['cart_success'] = "Added " . htmlspecialchars($product['title']) . " to cart successfully!";
                }
            }
        }
    }
    header("Location: cart.php");
    exit();
}

if ($action == 'update' && $product_id > 0) {
    // Get available stock
    $prod_q = mysqli_query($mysqli, "SELECT * FROM product WHERE id = $product_id");
    $product = mysqli_fetch_assoc($prod_q);
    
    if ($product) {
        $ptitle = $product['title'];
        $stock_q = mysqli_query($mysqli, "SELECT SUM(qunatity) AS total FROM orderss WHERE productname='$ptitle'");
        $ordered_stock = mysqli_fetch_assoc($stock_q)['total'] ?? 0;
        $available_stock = $product['stock'] - $ordered_stock;
        
        if ($quantity > $available_stock) {
            $quantity = $available_stock;
            $_SESSION['cart_error'] = "Only " . $available_stock . " units are available for " . $product['title'];
        }
        
        if (isset($_SESSION['email'])) {
            $email = mysqli_real_escape_string($mysqli, $_SESSION['email']);
            if ($quantity <= 0) {
                mysqli_query($mysqli, "DELETE FROM cart WHERE email='$email' AND product_id=$product_id");
            } else {
                mysqli_query($mysqli, "UPDATE cart SET quantity = $quantity WHERE email='$email' AND product_id=$product_id");
            }
        } else {
            if ($quantity <= 0) {
                unset($_SESSION['cart'][$product_id]);
            } else {
                $_SESSION['cart'][$product_id] = $quantity;
            }
        }
    }
    header("Location: cart.php");
    exit();
}

if ($action == 'remove' && $product_id > 0) {
    if (isset($_SESSION['email'])) {
        $email = mysqli_real_escape_string($mysqli, $_SESSION['email']);
        mysqli_query($mysqli, "DELETE FROM cart WHERE email='$email' AND product_id=$product_id");
    } else {
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
    }
    $_SESSION['cart_success'] = "Item removed from cart.";
    header("Location: cart.php");
    exit();
}

if ($action == 'clear') {
    if (isset($_SESSION['email'])) {
        $email = mysqli_real_escape_string($mysqli, $_SESSION['email']);
        mysqli_query($mysqli, "DELETE FROM cart WHERE email='$email'");
    } else {
        unset($_SESSION['cart']);
    }
    $_SESSION['cart_success'] = "Cart cleared.";
    header("Location: cart.php");
    exit();
}

header("Location: pr.php");
exit();
?>
