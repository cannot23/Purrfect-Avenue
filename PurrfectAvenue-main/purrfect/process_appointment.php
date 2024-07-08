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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointment_id = $_POST['appointment_id'];
    $status = $_POST['status'];

    // Update the appointment status
    $sql = "UPDATE grooming_appointments SET status = :status WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['status' => $status, 'id' => $appointment_id]);

    // If the status is changed to done or cancelled, update the available times
    if ($status == 'done' || $status == 'cancelled') {
        $appointment_sql = "SELECT appointment_time FROM grooming_appointments WHERE id = :id";
        $appointment_stmt = $pdo->prepare($appointment_sql);
        $appointment_stmt->execute(['id' => $appointment_id]);
        $appointment = $appointment_stmt->fetch(PDO::FETCH_ASSOC);
        
        $update_sql = "UPDATE available_times SET current_clients = current_clients - 1 WHERE time_slot = :appointment_time";
        $update_stmt = $pdo->prepare($update_sql);
        $update_stmt->execute(['appointment_time' => $appointment['appointment_time']]);
    }
    
    header('Location: schedule_appointments.php');
    exit;
}
?>