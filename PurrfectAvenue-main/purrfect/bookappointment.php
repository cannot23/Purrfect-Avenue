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

// Function to add a new appointment
function addAppointment($pdo, $customer_name, $pet_name, $service_type, $appointment_time) {
    $sql = "INSERT INTO grooming_appointments (customer_name, pet_name, service_type, appointment_time, status)
            VALUES (:customer_name, :pet_name, :service_type, :appointment_time, 'scheduled')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'customer_name' => $customer_name,
        'pet_name' => $pet_name,
        'service_type' => $service_type,
        'appointment_time' => $appointment_time
    ]);
    
    $update_sql = "UPDATE available_times SET current_clients = current_clients + 1 WHERE time_slot = :appointment_time";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->execute(['appointment_time' => $appointment_time]);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = $_POST['customer_name'];
    $pet_name = $_POST['pet_name'];
    $service_type = $_POST['service_type'];
    $appointment_time = $_POST['appointment_time'];
    
    // Check if the selected time slot is available
    $check_sql = "SELECT current_clients, max_clients FROM available_times WHERE time_slot = :appointment_time";
    $check_stmt = $pdo->prepare($check_sql);
    $check_stmt->execute(['appointment_time' => $appointment_time]);
    $slot = $check_stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($slot && $slot['current_clients'] < $slot['max_clients']) {
        addAppointment($pdo, $customer_name, $pet_name, $service_type, $appointment_time);
    } else {
        echo "Selected time slot is fully booked. Please choose another time.";
    }
}

// Fetch available times
$times_sql = "SELECT time_slot FROM available_times WHERE current_clients < max_clients ORDER BY time_slot ASC";
$times_stmt = $pdo->query($times_sql);
$available_times = $times_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Grooming Appointment</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head> 
<style>
    
    button {
        width: 100%;
        padding: 15px 15px;
        border: none;
        font-size: 16px;
        font-weight: 600;
        border-radius: 6px;
        background: #C55A11;
        margin: 8px 0;
        color: #eee;
    }
    select {
        padding: 10px; 
        font-size: 16px; 
        margin-bottom: 40px; 
        width: 100%;
        margin-top: 10px;
        border-radius: 4px; 
    }
</style>
<header>
	<a href="home.php"><img src="images/Background/back-arrow.png" class="logo" onclick="ExitPostAlert()"></a> 
</header>
<body>

<div class="container">
    <div class="form-container">
    <div class="form register">
    <h2>Book Grooming Appointment</h2>
    
    <form method="post" action="">
        <label for="customer_name">Customer Name:</label>
        <input type="text" id="customer_name" name="customer_name" required><br>
        
        <label for="pet_name">Pet Name:</label>
        <input type="text" id="pet_name" name="pet_name" required><br>
        
        <label for="service_type">Service Type:</label>
        <input type="text" id="service_type" name="service_type" required><br>
        
        <label for="appointment_time">Appointment Time:</label><br>
        <select id="appointment_time" name="appointment_time" required>
            <?php foreach ($available_times as $time): ?>
            <option value="<?php echo htmlspecialchars($time['time_slot']); ?>">
                <?php echo htmlspecialchars($time['time_slot']); ?>
            </option>
            <?php endforeach; ?>
        </select><br>
        
        <button type="submit">Book Appointment</button>
    </form>
    </div>
    </div>
    </div>
    
</body>
</html>