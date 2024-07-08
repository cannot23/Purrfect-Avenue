<?php
include "database.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $role = $_POST["role"];
    $is_approved_default = false;
    // Prepare SQL statement to insert data into the database
    $sql = "INSERT INTO role_requests (name, email, role, is_approved) VALUES (?, ?, ?, ?)";
    
    // Create a prepared statement
    $stmt = $conn->prepare($sql);
    
    // Bind parameters to the prepared statement
    $stmt->bind_param("sssi", $name, $email, $role, $is_approved_default);
    
    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "Your request has been submitted successfully.";
    } else {
        echo "Error: Unable to submit your request. Please try again later.";
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>