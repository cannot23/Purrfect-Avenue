<?php
session_start();
require_once 'database.php'; // Adjust the path as necessary

// Check if the user is logged in and if the form was submitted
if (!isset($_SESSION['user']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

// Extract and validate the product_id from the form data
$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : null;

// Proceed with deletion if a valid product_id is provided
if ($product_id) {
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    
    if ($stmt->execute()) {
        // Check if rows were affected to determine success
        if ($stmt->affected_rows > 0) {
            // Redirect or inform the user of success
            header('Location: productsadmin.php?delete=success');
            exit; // Exit after redirect
        } else {
            // Product not found or already deleted
            echo "Error: Product not found or already deleted.";
        }
    } else {
        // Handle errors
        echo "Error deleting record: " . $conn->error;
    }
} else {
    // Handle invalid or missing product_id
    echo "Invalid or missing product ID.";
}

$stmt->close();
$conn->close();
?>
