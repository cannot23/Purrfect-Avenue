<?php
// Include database connection
include_once 'database.php';

// Check if the user is logged in and is an admin
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'yes' || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Retrieve order history for received orders, ordered by received date
$sql = "SELECT orders.*, CONCAT(users.firstName, ' ', users.lastName) AS fullName 
        FROM orders 
        INNER JOIN users ON orders.userid = users.user_id 
        WHERE orders.status = 'Received' 
        ORDER BY received_date DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History (Admin)</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style1.css">
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
    <h2>Order History</h2>
    <table>
        <tr>
            <th>Order ID</th>
            <th>User</th>
            <th>Total Price</th>
            <th>Order Date</th>
            <th>Received Date</th>
            <th>Status</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["orderid"] . "</td>";
                echo "<td>" . $row["fullName"] . "</td>";
                echo "<td> ₱" . $row["total_price"] . "</td>";
                echo "<td>" . $row["order_date"] . "</td>";
                echo "<td>" . $row["received_date"] . "</td>"; // Include received date
                echo "<td>" . $row["status"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No orders found.</td></tr>";
        }
        ?>
    </table>
    </div>
    <div class="button">
    <a href="home.php" class="back-listbtn">Back to Home</a>
    </div>
    <script src="app.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
