<?php
    // Include database connection
    require_once "database.php";

    // Check if user is logged in as admin
    session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'yes' || !isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    // Check if user is admin
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT is_admin FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    if ($user['is_admin'] != 1) {
        header("Location: home.php"); // Redirect non-admin users
        exit();
    }

    // Check if orderid is provided in the URL
    if (!isset($_GET['orderid'])) {
        header("Location: view_orders.php");
        exit();
    }

    $orderid = $_GET['orderid'];

    // Fetch order details
    $sql = "SELECT * FROM orders WHERE orderid = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $orderid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $order = mysqli_fetch_assoc($result);

    // Check if order exists
    if (!$order) {
        header("Location: view_orders.php");
        exit();
    }

    // Update order
    if (isset($_POST['update'])) {
        // Get updated order details
        $name = $_POST['name'];
        $contact_num = $_POST['contact_num'];
        $address = $_POST['address'];
        $mode_of_payment = $_POST['mode_of_payment'];
        $total_price = $_POST['total_price'];
        $status = $_POST['status'];

        // Check if status is "Received" and set received_date accordingly
        if ($status == 'Received') {
            $received_date = date('Y-m-d H:i:s'); // Current date and time
        } else {
            $received_date = null; // Nullify received_date if status is not "Received"
        }

        // Update order in database
        $sql = "UPDATE orders SET name = ?, contact_num = ?, address = ?, mode_of_payment = ?, total_price = ?, status = ?, received_date = ? WHERE orderid = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssi", $name, $contact_num, $address, $mode_of_payment, $total_price, $status, $received_date, $orderid);
        mysqli_stmt_execute($stmt);

        // Redirect to view_orders.php after updating
        header("Location: orders_list.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function showAlert() {
            return confirm("Are you sure you want to update the order?");
        }
    </script>
</head>
<style>
    input[type="submit"][name="update"][value="Update"] {
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
<div class="container">
    <div class="form-container">
        <div class="form register">
            <h2>Update Order</h2>
            <form method="post" onsubmit="showAlert()">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $order['name']; ?>"><br>
        
            <label for="contact_num">Contact Number:</label>
            <input type="text" id="contact_num" name="contact_num" value="<?php echo $order['contact_num']; ?>"><br>
        
            <label for="address">Address:</label>
            <input type="address" id="address" name="address" value="<?php echo $order['address']; ?>"><br>
        
            <label for="mode_of_payment">Mode of Payment:</label>
            <input type="text" id="mode_of_payment" name="mode_of_payment" value="<?php echo $order['mode_of_payment']; ?>"><br>
        
            <label for="total_price">Total Price:</label>
            <input type="number" id="total_price" name="total_price" value="<?php echo $order['total_price']; ?>"><br>
        
            <label for="status">Status:</label>
            <input type="radio" id="received" name="status" value="Received" <?php echo ($order['status'] == 'Received') ? 'checked' : ''; ?>>
        
            <label for="received">Received</label><br>
            <input type="radio" id="NotReceived" name="status" value="NotReceived" <?php echo ($order['status'] == 'NotReceived') ? 'checked' : ''; ?>>
            <label for="notReceived">Not Received</label><br>
            
            <input type="submit" name="update" value="Update">
            </form>
        </div>
    </div>
</div>
</body>
</html>