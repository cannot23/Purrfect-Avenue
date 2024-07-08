<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Calculate total number of items in cart
$totalItems = array_sum($_SESSION['cart']);

echo json_encode(array('numberOfItems' => $totalItems));
?>