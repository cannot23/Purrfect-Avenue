<?php
session_start();
include_once 'database.php';

// Check if user is logged in as admin
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'yes' || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if user is admin
$user_id = $_SESSION['user_id'];
$sql = "SELECT is_admin FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if ($user['is_admin'] != 1) {
    header("Location: home.php"); // Redirect non-admin users
    exit();
}

// Delete user
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        // Redirect to user list page after successful deletion
        header("Location: user_list.php");
        exit();
    } else {
        // Handle deletion failure
        echo "Error deleting user: " . $stmt->error;
    }

    $stmt->close();
} else {
    // If user_id is not provided, redirect to user list page
    header("Location: user_list.php");
    exit();
}
?>