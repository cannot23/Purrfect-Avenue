<?php
session_start(); // Start the session if not already started

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // The user is logged in
    $user_id = $_SESSION['user_id'];

    // Include the database connection file
    include_once 'database.php';

    // Fetch user's registered address from the database
    $sql = "SELECT address FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($registered_address);
    $stmt->fetch();
    $stmt->close();
} else {
    // Redirect to the login page or handle unauthorized access
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posting Page</title>
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
        margin-bottom: 20px; 
        width: 100%;
        margin-top: 10px;
        border-radius: 4px; 
    }
</style>
<body>
<header>
	<a href="shoppingcart.php"><img src="images/Background/back-arrow.png" class="logo" onclick="ExitPostAlert()"></a> 
</header> 
<div class="container">
    <div class="form-container">
    <div class="form register">
    <form method="post" action="checkoutprocess.php" onsubmit="return PostAlert()">
    
    <label for="address">Choose Address:</label>
    <br><select name="address_option" id="address_option">
        <option value="registered" selected>Use Registered Address</option>
        <option value="new">Use New Address</option>
    </select>
    
    <div id="new_address" style="display: none;">
        <label for="new_address">New Address</label>
        <input type="text" name="new_address">
    </div>

    <label for="paymentMode">Payment Mode:</label>
    <div class="payment-mode">
    <select name="paymentMode" id="paymentMode">
    <option value="CashonDelivery">Cash on Delivery</option>
    </select>
    </div>

    <button type="submit">Checkout</button>
</form>
</div>
</div>
</div>
<script src="script.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('address_option').addEventListener('change', function() {
        var selected_option = this.value;
        if (selected_option === 'new') {
            document.getElementById('new_address').style.display = 'block';
        } else {
            document.getElementById('new_address').style.display = 'none';
        }
    });
});
</script>
</body>
</html>