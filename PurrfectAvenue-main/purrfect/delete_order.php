<?php
    // Include database connection
    require_once "database.php";

    // Check if user is logged in as admin
    session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'yes' || !isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    // Check if user is admin
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT is_admin FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    if ($user['is_admin'] != 1) {
        header("Location: home.php"); // Redirect non-admin users
        exit();
    }

    // Check if orderid is provided in the URL
    if (!isset($_GET['orderid'])) {
        header("Location: view_orders.php");
        exit();
    }

    $orderid = $_GET['orderid'];

    // Delete related records from order_items table
    $sql_delete_order_items = "DELETE FROM order_items WHERE orderid = ?";
    $stmt_delete_order_items = mysqli_prepare($conn, $sql_delete_order_items);
    mysqli_stmt_bind_param($stmt_delete_order_items, "i", $orderid);
    mysqli_stmt_execute($stmt_delete_order_items);

    // Delete order from orders table
    $sql_delete_order = "DELETE FROM orders WHERE orderid = ?";
    $stmt_delete_order = mysqli_prepare($conn, $sql_delete_order);
    mysqli_stmt_bind_param($stmt_delete_order, "i", $orderid);
    mysqli_stmt_execute($stmt_delete_order);

    // Redirect to view_orders.php after deleting
    echo "Order deleted successfully.";
    echo "<a href='orders_list.php'>Back to View Orders</a>";
    exit();
?>