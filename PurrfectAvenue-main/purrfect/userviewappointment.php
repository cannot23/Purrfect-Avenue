<?php
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

// Fetch the appointments
$sql = "SELECT * FROM grooming_appointments ORDER BY appointment_time ASC";
$stmt = $pdo->query($sql);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Appointments</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style1.css">
</head>
<header>
    <a href="home.php"><img src="images/Background/logo.png" class="logo"></a> 
    <div class="nav-bar">
        <div class="toggle"></div>
        <ul class="navigation"> 
        <?php 
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            $itemCnt = array_sum($_SESSION['cart']);
            
            if (isset($_SESSION['user_id'])): ?>
            <?php
               echo "<li><a href='shoppingcart.php'><img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAAA60lEQVR4nO3WsQpBURjA8VsmKwNG5Q1MJoOFlFmKJ7BY5QHkJZTJG9ydYrPZhZXBoAh/XX1ic45z7pH4z1/n11nOdzzvJwPGPFoA1U/AQScg4wS/BwxuNHQ8lwEVgaeu4SiwB85AwjXuy60bruEm4TR6BadDglcqt56HAPdV4F4IcE0FzltGL0BSBY4AG4vw7CX6hA8twl0duG4RLujAMVkYpu2DF1EZFnxiAfa1UIHbFuDWO3AK2BmgWyCuDQueC9YkcNQAD/LByL6F/m5AGVgHGwYomc4pJwfdW5rOfQVckkOXQNF07p/nqit4etkTHpfOQQAAAABJRU5ErkJggg=='><span id='itemCount'>$itemCnt</span></a></li>";
                ?>
                <li><a href="orderspage.php">My Orders</a></li>
                <li><a href="orderhistory.php">Order History</a></li>
                <li><a href="home.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="settings.php">User Settings</a></li>
                <li><a href="bookappointment.php">Book an Appointment</a></li> 
					<li><a href="userviewappointment.php">My Appointments</a></li> 
                <li><a href="#" onclick="logoutAlert()">Log Out</a></li>
            <?php else: ?>
                <?php
               echo "<li><a href='shoppingcart.php'><img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAAA60lEQVR4nO3WsQpBURjA8VsmKwNG5Q1MJoOFlFmKJ7BY5QHkJZTJG9ydYrPZhZXBoAh/XX1ic45z7pH4z1/n11nOdzzvJwPGPFoA1U/AQScg4wS/BwxuNHQ8lwEVgaeu4SiwB85AwjXuy60bruEm4TR6BadDglcqt56HAPdV4F4IcE0FzltGL0BSBY4AG4vw7CX6hA8twl0duG4RLujAMVkYpu2DF1EZFnxiAfa1UIHbFuDWO3AK2BmgWyCuDQueC9YkcNQAD/LByL6F/m5AGVgHGwYomc4pJwfdW5rOfQVckkOXQNF07p/nqit4etkTHpfOQQAAAABJRU5ErkJggg=='><span id='itemCount'>$itemCnt</span></a></li>";
                ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="registration.php">Sign Up</a></li>
            <?php endif; ?>
        </ul> 
    </div>
</header>
<body>
    <div class='container-4'>
    <h2>My Appointments</h2>
    
    <table border="1">
        <tr>
            <th>Customer Name</th>
            <th>Pet Name</th>
            <th>Service Type</th>
            <th>Appointment Time</th>
            <th>Status</th>
        </tr>
        <?php foreach ($appointments as $appointment): ?>
        <tr>
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