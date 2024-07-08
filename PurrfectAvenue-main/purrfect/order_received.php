<?php
session_start();
include_once 'database.php';

if (isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];

    // Update the order status to 'Received' and set the received date to the current date
    $updateStmt = $conn->prepare("UPDATE orders SET status = 'Received', received_date = CURRENT_TIMESTAMP WHERE orderid = ?");
    $updateStmt->bind_param("i", $orderId);
    $updateStmt->execute();
    $updateStmt->close();
    // Retrieve the order details from the database
    $stmt = $conn->prepare("SELECT productid, quantity FROM order_items WHERE orderid = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Update product inventory for each item in the order
    while ($row = $result->fetch_assoc()) {
        $productId = $row['productid'];
        $quantityReceived = $row['quantity'];

        // Check if the updated stock quantity would be negative
        $checkStmt = $conn->prepare("SELECT quantity FROM stocks WHERE product_id = ?");
        $checkStmt->bind_param("i", $productId);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        $currentQuantity = $checkResult->fetch_assoc()['quantity'];

        if ($currentQuantity < $quantityReceived) {
            // Display an alert and redirect to orders page if the quantity would become negative
            echo "<script>alert('Error: Insufficient stock quantity.'); window.location.href = 'orderspage.php';</script>";
            exit();
        }

        // Update product inventory by subtracting the received quantity
        $updateStockStmt = $conn->prepare("UPDATE stocks SET quantity = quantity - ? WHERE product_id = ?");
        $updateStockStmt->bind_param("ii", $quantityReceived, $productId);
        $updateStockStmt->execute();
        $updateStockStmt->close();
        
        // Close the checkStmt within the loop
        $checkStmt->close();
    }

    // Close the prepared statements
    $stmt->close();

    // Redirect the user back to the orders page or any other page as needed
    header("Location: orderspage.php");
    exit();
} else {
    // If the order ID is not provided, redirect the user back to the orders page
    header("Location: orderspage.php");
    exit();
}
?>

