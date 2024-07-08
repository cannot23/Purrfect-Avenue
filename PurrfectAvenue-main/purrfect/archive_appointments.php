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

// Fetch the archived appointments
$sql = "SELECT * FROM grooming_appointments WHERE status IN ('done', 'cancelled') ORDER BY appointment_time ASC";
$stmt = $pdo->query($sql);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Archived Appointments</title>
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
    <div class='container-4'>
    <a href="viewappointments.php" class="back-listbtn">Appointment Time Slots</a>
    <a href="schedule_appointments.php" class="back-listbtn">Schedule Appointments</a>
    
    <h2>Archived Appointments</h2>
    
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Customer Name</th>
            <th>Pet Name</th>
            <th>Service Type</th>
            <th>Appointment Time</th>
            <th>Status</th>
        </tr>
        <?php foreach ($appointments as $appointment): ?>
        <tr>
            <td><?php echo htmlspecialchars($appointment['id']); ?></td>
            <td><?php echo htmlspecialchars($appointment['customer_name']); ?></td>
            <td><?php echo htmlspecialchars($appointment['pet_name']); ?></td>
            <td><?php echo htmlspecialchars($appointment['service_type']); ?></td>
            <td><?php echo htmlspecialchars($appointment['appointment_time']); ?></td>
            <td><?php echo htmlspecialchars($appointment['status']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    </div>
    <script src = "app.js"></script>
</body>
</html>