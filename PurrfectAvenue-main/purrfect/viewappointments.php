<?php
session_start();
require_once("database.php");

// Database connection settings
$host = 'localhost: 3307';
$dbname = 'purrfect';
$username = 'root';
$password = '';


// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch available times
$times_sql = "SELECT * FROM available_times ORDER BY time_slot ASC";
$times_stmt = $pdo->query($times_sql);
$available_times = $times_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Available Time Slots</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style1.css">
</head>
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
<body>
<div class="container-4">
<a href="schedule_appointments.php" class="back-listbtn">Schedule Appointments</a>
<a href="archive_appointments.php" class="back-listbtn">Archived Appointments</a>
    <h2>Available Time Slots</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Time Slot</th>
            <th>Max Clients</th>
            <th>Current Clients</th>
        </tr>
        <?php foreach ($available_times as $time): ?>
        <tr>
            <td><?php echo htmlspecialchars($time['id']); ?></td>
            <td><?php echo htmlspecialchars($time['time_slot']); ?></td>
            <td><?php echo htmlspecialchars($time['max_clients']); ?></td>
            <td><?php echo htmlspecialchars($time['current_clients']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    </div>
    <script src = "app.js"></script>
</body>
</html>