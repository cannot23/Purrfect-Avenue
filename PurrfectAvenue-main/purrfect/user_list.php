<?php
// Start the session
session_start();

// Include your database connection script
require_once 'database.php';

// Fetch users from the database
$query = "SELECT user_id, firstName, lastName FROM users ORDER BY lastName, firstName";
$result = mysqli_query($conn, $query);

// Check for errors or empty result
if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="style.css"> 
    <title>User's Profile</title>
</head>
<style>
    /* USER_LIST.PHP */ 
.user_list {
	font-family: Arial, sans-serif;
	margin: 0;
	padding: 20px;
}
table {
	width: 100%;
	border-collapse: collapse;
}
table, th {
	border: 1px solid #ddd;
	padding: 8px;
	text-align: left;
} 
.container-4 {
	position: relative;
	margin-top: 100px; 
}
.button {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}
td {
	border: 1px solid #ddd;
	padding: 8px;
	text-align: left;
	display: flex;
	justify-content: space-between;
	align-items: center;
}
th {
	background-color: #f2f2f2;
}
tr:nth-child(even) {background-color: #f9f9f9;}
.view-btn {
	padding: 5px 10px;
	color: #222;
}

</style>
<body class="user_list">
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
    <h2>User's Profile List</h2>
    <table>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                // Combining first name and last name for full name display
                $fullName = htmlspecialchars($row["firstName"]) . " " . htmlspecialchars($row["lastName"]);
                echo "<tr>";
                echo "<td>" . $fullName . " <a href='view_user.php?user_id=" . htmlspecialchars($row["user_id"]) . "' class='view-btn'>View Profile</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table> 
    </div>
    <div class="button">
        <a href="home.php" class="home-btn">Back to home page</a>
        <a href="create_user.php" class="home-btn">Create a new user</a>
    </div>
    <?php
    // Free the result and close the database connection
    mysqli_free_result($result);
    mysqli_close($conn);
    ?>
    <script src="app.js"></script>
</body>
</html>
