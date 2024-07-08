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

// Function to fetch active orders sorted by descending order
function fetchActiveOrders($conn) {
    $sql = "SELECT * FROM orders WHERE status = 'NotReceived' ORDER BY order_date DESC";
    $result = mysqli_query($conn, $sql);
    $orders = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }
    return $orders;
}

// Fetch active orders sorted by descending order
$orders = fetchActiveOrders($conn);

// Display active orders
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style1.css">
    <title>View Active Orders</title>
</head>
<body>
<header>
    <a href="home.php"><img src="images/Background/logo.png" class="logo"></a> 
    <div class="nav-bar">
        <div class="toggle"></div>
        <ul class="navigation"> 
            <li><a href="user_list.php">Users</a></li> 
            <li><a href="orders_list.php">Active Orders</a></li>
            <li><a href="orderhistoryadmin.php">Completed Orders</a>
            <li><a href="productsadmin.php">Products</a>
            <li><a href="orderreport.php">Order Report</a></li>
            <li><a href="viewappointments.php">Appointments</a></li> 
            <li><a href="home.php">Admin Panel</a></li> 
            <li><a href="#" onclick="logoutAlert()">Log Out</a></li>
        </ul> 
    </div>
</header>    
    <div class="container-4">
    <h2>Active Orders</h2>
    <table>
        <tr>
            <th>Order ID</th>
            <th>User ID</th>
            <th>Name</th>
            <th>Contact Num</th>
            <th>Address</th>
            <th>Mode of Payment</th>
            <th>Total Price</th>
            <th>Order Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo $order['orderid']; ?></td>
                <td><?php echo $order['userid']; ?></td>
                <td><?php echo $order['name']; ?></td>
                <td><?php echo $order['contact_num']; ?></td>
                <td><?php echo $order['address']; ?></td>
                <td><?php echo $order['mode_of_payment']; ?></td>
                <td>₱<?php echo $order['total_price']; ?></td>
                <td><?php echo $order['order_date']; ?></td>
                <td><?php echo $order['status']; ?></td>
                <td>
                    <a href="update_order.php?orderid=<?php echo $order['orderid']; ?>" class="update">Update</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    </div>
    <div class="button">
    <a href="home.php" class="back-listbtn">Back to Home</a>
    </div>
    <script src="app.js"></script>
</body>
</html>
