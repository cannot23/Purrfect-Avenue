<?php
session_start();
include_once 'database.php';

// Check if user is logged in as admin
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'yes' || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if user is admin
$user_id = $_SESSION['user_id'];
$sql = "SELECT is_admin FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if ($user['is_admin'] != 1) {
    header("Location: home.php"); // Redirect non-admin users
    exit();
}

// Function to encrypt password
function encryptPassword($password) {
    // You can use any suitable encryption method here, for example:
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    return $hashed_password;
}

// Update user information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $firstname = $_POST['firstName'];
    $lastname = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $is_admin = $_POST['is_admin'];

    // Check if password field is not empty
    if (!empty($password)) {
        $encrypted_password = encryptPassword($password);
        $sql = "UPDATE users SET firstName=?, lastName=?, email=?, password=?, is_admin=? WHERE user_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $firstname, $lastname, $email, $encrypted_password, $is_admin, $user_id);
    } else {
        // If password field is empty, update without changing the password
        $sql = "UPDATE users SET firstName=?, lastName=?, email=?, is_admin=? WHERE user_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $firstname, $lastname, $email, $is_admin, $user_id);
    }

    if ($stmt->execute()) {
        // Redirect to user list page after successful update
        header("Location: user_list.php");
        exit();
    } else {
        // Handle update failure
        echo "Error updating user: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch user details
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
} else {
    // If user_id is not provided, redirect to user list page
    header("Location: user_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
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
<body>
<div class="container"> 
<div class="form-container">
<div class="form register">
    <h2>Update User</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
        
        <label for="firstName">First Name:</label><br>
        <input type="text" id="firstName" name="firstName" value="<?php echo $user['firstName']; ?>"><br>

        <label for="lastName">Last Name:</label><br>
        <input type="text" id="lastName" name="lastName" value="<?php echo $user['lastName']; ?>"><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>"><br>
        
        <label for="password">New Password:</label><br>
        <input type="password" id="password" name="password"><br>

        <label for="is_admin">Is Admin:</label><br>
        <select id="is_admin" name="is_admin">
            <option value="0" <?php if ($user['is_admin'] == 0) echo 'selected'; ?>>No</option>
            <option value="1" <?php if ($user['is_admin'] == 1) echo 'selected'; ?>>Yes</option>
        </select><br><br>
        
        <button type="submit">Update</button>
    </form>
</style>
</div>
</div>
</body>
</html>

<?php
$conn->close();
?>