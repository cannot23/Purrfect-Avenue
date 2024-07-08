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
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="style.css"> 
	<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script> 
</head> 
<body> 
	<section>
		<header>
			<a href="home.php"><img src="images/Background/logo.png" class="logo"></a> 
			<div class="nav-bar">
				<div class="toggle"></div>
				<ul class="navigation"> 
					<li><a href="home.php">Home</a></li> 
					<li><a href="products.php">Products</a></li> 
					<li><a href="bookappointment.php">Book an Appointment</a></li> 
					<li><a href="userviewappointment.php">My Appointment</a></li> 

					<li><a href="settings.php">User Settings</a></li>
					<li><a href="aboutus.php">About Us</a></li> 	
					<li><a href="#" onclick="logoutAlert()">Log Out</a></li> 
				</ul> 
			</div>
		</header> 
	<div class="content">
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
						echo "<h4>Pets Thrive, <span-1>We Provide.</span-1></h4>";
						echo "<p>Welcome, {$user['firstName']} {$user['lastName']}! Explore top-tier pet love at \"Purrfect Pet Store,\" your ultimate online destination for pet products. 
						We provide an extensive selection of high-quality accessories, food, and cages to cater to all your pet needs.</p>";
				}
			}
			?>
			<a href="products.php">Buy Now</a> 
		</div> 
		<div class="imgBox"> 
			<div class="swiper mySwiper">
				<div class="swiper-wrapper">
					<div class="swiper-slide"><img src="./images/Background/icedcoffee1.png"/></div> 
					<div class="swiper-slide"><img src="./images/Background/icedcoffee2.png"/></div> 
					<div class="swiper-slide"><img src="./images/Background/icedcoffee3.png"/></div>
					<div class="swiper-slide"><img src="./images/Background/icedcoffee4.png"/></div> 
					<div class="swiper-slide"><img src="./images/Background/cappuccino.png"/></div>
					<div class="swiper-slide"><img src="./images/Background/regularcoffee.png"/></div>
				</div>
			</div>
		</div>
	</div>
	<ul class="sci"> 
		<li><a href="aboutus.php"><i class='bx bxl-facebook' ></i></li>
		<li><a href="aboutus.php"><i class='bx bxl-twitter' ></i></li>
		<li><a href="aboutus.php"><i class='bx bxl-instagram' ></i></li>
	</ul> 
	<div class="footer"> 
		<p>Copyright 2024 | WebDev | Group 5</p>
	</div>
	<script src = "app.js"></script>
	</section> 
</body> 
</html> 