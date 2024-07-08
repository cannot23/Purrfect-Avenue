<?php
session_start();
require_once 'database.php'; // Adjust the path as necessary

// Check if the user is logged in and if the form was submitted
if (!isset($_SESSION['user']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

// Extract and validate form data
$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : null;
$imgurl = filter_input(INPUT_POST, 'imgurl', FILTER_SANITIZE_URL);
$productName = filter_input(INPUT_POST, 'productName', FILTER_SANITIZE_STRING);
$productPrice = filter_input(INPUT_POST, 'productPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$productDesc = filter_input(INPUT_POST, 'productDesc', FILTER_SANITIZE_STRING);
$productGroup = filter_input(INPUT_POST, 'productGroup', FILTER_SANITIZE_STRING);
$stockQuantity = isset($_POST['stockQuantity']) ? (int)$_POST['stockQuantity'] : null;

// Update the product in the database
if ($product_id && $imgurl && $productName && $productPrice && $productDesc && $productGroup && $stockQuantity !== null) {
    // Begin a transaction for atomicity
    $conn->begin_transaction();

    $updateProductQuery = "UPDATE products SET image_url=?, product_name=?, product_price=?, product_desc=?, product_group=? WHERE product_id=?";
    $stmt = $conn->prepare($updateProductQuery);
    $stmt->bind_param("ssdssi", $imgurl, $productName, $productPrice, $productDesc, $productGroup, $product_id);

    if ($stmt->execute()) {
        // Update the stock quantity
        $updateStockQuery = "UPDATE stocks SET quantity=? WHERE product_id=?";
        $stmt = $conn->prepare($updateStockQuery);
        $stmt->bind_param("ii", $stockQuantity, $product_id);

        if ($stmt->execute()) {
            // Commit the transaction if both updates are successful
            $conn->commit();
            header('Location: productsadmin.php?update=success');
            exit;
        } else {
            // Rollback the transaction if the stock update fails
            $conn->rollback();
            echo "Error updating stock quantity: " . $conn->error;
        }
    } else {
        // Handle errors
        echo "Error updating product: " . $conn->error;
    }
} else {
    // Handle invalid form data
    echo "Invalid data provided.";
}

$conn->close();
?>
