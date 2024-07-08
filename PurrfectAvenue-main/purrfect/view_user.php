<?php
// Start the session
session_start();

// Include your database connection script
require_once 'database.php';

// Check if the user_id is provided in the URL
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Prepare a SELECT statement to fetch the user's details
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // Handle case where no user is found
        echo "No user found.";
        exit;
    } else {
        // Fetch the user's details
        $user = $result->fetch_assoc();
    }
} else {
    // Redirect back or show an error if no user_id is specified
    echo "No user specified.";
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="style.css"> 
    <meta charset="UTF-8">
    <title>User Profile</title>
</head>
<style>
    .update-btn, .delete-btn {
        display: inline-block;
        background-color: #bebcbc;
        color: #000;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 10px;
        margin-top: 20px;
    } 
</style>
<body class="view_user">
    <header>
		<a href="dashboard.php"><img src="images/Background/logo.png" class="logo"></a> 
		<div class="nav-bar">
			<div class="toggle"></div>
			<ul class="navigation"> 
                <li><a href="user_list.php">Users</a></li> 
				<li><a href="home.php">Admin Panel</a></li> 
			</ul> 
		</div>
	</header> 
    <?php if (isset($user)): ?>
    <div class="container-5">
        <div class="user-profile">
        <h2>User Profile</h2>
        <p><strong>First Name:</strong> <?php echo htmlspecialchars($user['firstName']); ?></p>
        <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user['lastName']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <!-- Add more user details as needed -->
        <p><strong>Password:</strong> <?php echo htmlspecialchars($user['password']); ?></p>
        <p><strong>Role:</strong>
            <?php 
            $roles = []; 
            if ($user['is_admin']) $roles[] = 'Admin'; 
            echo htmlspecialchars(implode(', ', $roles)) ?: 'User'; 
            ?> 
        </p>
        <a href="update_user.php?user_id=<?php echo $user['user_id']; ?>" class="update-btn">Update</a>
        <a href="delete_user.php?user_id=<?php echo $user['user_id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
        </div>
    </div>
    <?php else: ?>
    <p>User not found.</p>
    <?php endif; ?>
    <div class="user-container">
        <a href="user_list.php" class="back-listbtn">Back to user's list</a>
    </div> 
    <script src = "app.js"></script>
</body>
</html>
