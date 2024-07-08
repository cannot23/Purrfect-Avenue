<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Include the database connection file
include_once 'database.php';

// Get the user ID
$user_id = $_SESSION['user_id'];

// Fetch the user's information from the database
$stmt = $conn->prepare("SELECT firstName, lastName, email, contact_num, address FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($firstName, $lastName, $email, $contact_num, $address);
$stmt->fetch();
$stmt->close();

// Handle form submission for updating user information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract user input
    $newFirstName = $_POST['firstName'];
    $newLastName = $_POST['lastName'];
    $newEmail = $_POST['email'];
    $newContactNum = $_POST['contact_num'];
    $newAddress = $_POST['address'];

    // Prepare and execute SQL statement to update user information
    $stmt = $conn->prepare("UPDATE users SET firstName = ?, lastName = ?, email = ?, contact_num = ?, address = ? WHERE user_id = ?");
    $stmt->bind_param("sssssi", $newFirstName, $newLastName, $newEmail, $newContactNum, $newAddress, $user_id);
    $stmt->execute();
    $stmt->close();

    // Redirect back to settings page with a query parameter indicating success
    header("Location: settings.php?success=true");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Settings</title>
    <link rel="stylesheet" href="style.css">
    <script>
        // Function to display a success alert
        function displaySuccessAlert() {
            alert("Your information has been updated successfully.");
        }
    </script>
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
</style>
<body>
<header>
    <a href="#" onclick="goBack()" class="logo"><img src="images/Background/back-arrow.png" class="logo"></a>
</header>
    <div class="container">
    <div class="form-container">
    <div class="form register">
        <h2>User Settings</h2>
        <?php if (isset($_GET['success']) && $_GET['success'] === 'true'): ?>
            <script>displaySuccessAlert();</script>
        <?php endif; ?>
        <form method="post" action="settings.php">
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>" required>
            
            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" value="<?php echo $lastName; ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
            
            <label for="contact_num">Contact Number:</label>
            <input type="text" id="contact_num" name="contact_num" value="<?php echo $contact_num; ?>" required>
            
            <label for="address">Address:</label>
            <input type="address" id="address" name="address" value="<?php echo $address; ?>" required>
            
            <button type="update">Update Information</button>
        </form>
    </div>
    </div>
    </div>
</body>
<script>
    function goBack() {
        window.history.back();
    }
</script>
</html>
