<?php
session_start();
include "database.php";
if (isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = 1;
    } else {
        $_SESSION['cart'][$productId]++;
    }

    echo json_encode(array('message' => 'Product added to cart successfully', 'numberOfItems' => count($_SESSION['cart'])));
} else {
    echo json_encode(array('message' => 'Error adding product to cart'));
}
?>
