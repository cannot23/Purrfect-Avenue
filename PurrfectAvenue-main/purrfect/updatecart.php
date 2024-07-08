<?php
session_start();
include_once 'database.php';

if (isset($_POST['update']) && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Validate the quantity
    if (!is_numeric($quantity) || $quantity <= 0) {
        // Invalid quantity, redirect back to the shopping cart with an error message
        $_SESSION['error'] = 'Invalid quantity';
        header("Location: shoppingcart.php");
        exit();
    }

    // Update the quantity in the cart
    $_SESSION['cart'][$productId] = $quantity;

    // Redirect back to the shopping cart with a success message
    $_SESSION['success'] = 'Cart updated successfully';
    header("Location: shoppingcart.php");
    exit();
} else {
    // Invalid request, redirect back to the shopping cart with an error message
    $_SESSION['error'] = 'Invalid request';
    header("Location: shoppingcart.php");
    exit();
}
?>