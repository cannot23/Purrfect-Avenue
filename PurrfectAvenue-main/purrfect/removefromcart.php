<?php
session_start();
include_once 'database.php';

if (isset($_POST['remove']) && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];

    // Check if the product exists in the cart
    if (isset($_SESSION['cart'][$productId])) {
        // Remove the product from the cart
        unset($_SESSION['cart'][$productId]);
        
        // Redirect back to the shopping cart with a success message
        $_SESSION['success'] = 'Product removed from cart successfully';
        header("Location: shoppingcart.php");
        exit();
    } else {
        // Product not found in the cart, redirect back to the shopping cart with an error message
        $_SESSION['error'] = 'Product not found in cart';
        header("Location: shoppingcart.php");
        exit();
    }
} else {
    // Invalid request, redirect back to the shopping cart with an error message
    $_SESSION['error'] = 'Invalid request';
    header("Location: shoppingcart.php");
    exit();
}
?>