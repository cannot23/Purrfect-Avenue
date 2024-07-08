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

// Create new user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstName'];
    $lastname = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $is_admin = $_POST['is_admin'];

    // Encrypt password
    $encrypted_password = encryptPassword($password);

    // Insert new user into database
    $sql = "INSERT INTO users (firstName, lastName, email, password, is_admin) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $firstname, $lastname, $email, $encrypted_password, $is_admin);

    if ($stmt->execute()) {
        // Redirect to user list page after successful creation
        header("Location: user_list.php");
        exit();
    } else {
        // Handle creation failure
        echo "Error creating user: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
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
        margin-bottom: 20px; 
        width: 100%;
        margin-top: 10px;
        border-radius: 4px; 
    }
</style>
<body>
<div class="container">
<div class="form-container">
<div class="form register">
    <h2>Create User</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="firstName">First Name:</label><br>
        <input type="text" id="firstName" name="firstName"><br>
        
        <label for="lastName">Last Name:</label><br>
        <input type="text" id="lastName" name="lastName"><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br>
        
        <label for="is_admin">Is Admin:</label><br>
        <select id="is_admin" name="is_admin">
            <option value="0">No</option>
            <option value="1">Yes</option>
        </select><br><br>
        
        <button type="submit">Create User</button>
    </form>
</div>
</div>
</div>
</body>
</html>

<?php
$conn->close();
?>