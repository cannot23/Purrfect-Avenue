<?php //code so that user dashboard cannot be accessed without login
session_start();
if (!isset($_SESSION['user'])){
    header("Location: login.php");
}

?>

<!DOCTYPE html> 
<html> 
<head> 
	<meta charset="UTF-8"> 
	<title>Purrfect Pet Services</title> 
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="style.css"> 
</head> 
<body> 
	<section>
		<header>
			<a href="home.php"><img src="images/Background/logo.png" class="logo"></a> 
			<div class="nav-bar">
				<div class="toggle"></div>
				<ul class="navigation"> 
					<li><a href="home.php">Admin Panel</a></li> 	
					<li><a href="#" onclick="logoutAlert()">Log Out</a></li> 
				</ul> 
			</div>
		</header> 
	<div class="content3">
		<div class="textBox">
			<?php
			if (isset($_SESSION['user_id'])) {
				require_once 'database.php';
			
				$user_id = $_SESSION['user_id'];
			
				$sql = "SELECT firstName, lastName FROM users WHERE user_id = $user_id";
				$result = mysqli_query($conn, $sql);
			
				// Check if the query was successful
				if ($result) {
					$user = mysqli_fetch_array($result, MYSQLI_ASSOC);
						echo "<h2>Welcome, <span-1>{$user['firstName']} {$user['lastName']}!</span-1></h2><br>";

				}
			}
			?>
			<h2>Admin Panel</h2> 
			<a href="user_list.php">View Users</a>
			<a href="orders_list.php">View Active Orders</a>
			<a href="orderhistoryadmin.php">View Completed Orders</a>
            <a href="productsadmin.php">View Products</a>
			<a href="orderreport.php">View Order Report</a>
			<a href="viewappointments.php">View Appointments</a>
		</div> 
	</div>
	<div class="footer"> 
		<p>Copyright 2024 | Group 6</p>
	</div>
	<script src = "app.js"></script>
	</section> 
</body> 
</html> 