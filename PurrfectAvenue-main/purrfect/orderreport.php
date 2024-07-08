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

    // Initialize variables for summary statistics
    
    $totalOrders = 0;
    $totalRevenue = 0; 
    $averageOrderValue = 0;

    // Initialize variables for date range
    $dateFrom = $_POST['date_from'] ?? '';
    $dateTo = $_POST['date_to'] ?? '';

    // Function to fetch orders based on date range
    function fetchOrders($conn, $dateFrom, $dateTo) {
        $sql = "SELECT * FROM orders WHERE status = 'Received'";
        if (!empty($dateFrom)) {
            $sql .= " AND received_date >= '$dateFrom'";
        }
        if (!empty($dateTo)) {
            $sql .= " AND received_date <= '$dateTo'";
        }
        $sql .= " ORDER BY received_date DESC";
        $result = mysqli_query($conn, $sql);
        $orders = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $orders[] = $row;
        }
        return $orders;
    }

    // Fetch orders based on date range
    $orders = fetchOrders($conn, $dateFrom, $dateTo);

    // Calculate summary statistics
    foreach ($orders as $order) {
        // Calculate summary statistics
    $totalOrders = count($orders);
    $totalRevenue = array_sum(array_column($orders, 'total_price'));
    $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="style1.css">
    <title>Order Report</title>
</head>
<body>
<header>
    <a href="home.php"><img src="images/Background/logo.png" class="logo"></a> 
    <div class="nav-bar">
        <div class="toggle"></div>
        <ul class="navigation"> 
            <li><a href="user_list.php">Users</a></li> 
            <li><a href="orders_list.php">Active Orders</a></li>
            <li><a href="orderhistoryadmin.php">Completed Orders</a>
            <li><a href="productsadmin.php">Products</a>
            <li><a href="orderreport.php">Order Report</a></li>
            <li><a href="viewappointments.php">Appointments</a></li> 
            <li><a href="home.php">Admin Panel</a></li> 
            <li><a href="#" onclick="logoutAlert()">Log Out</a></li>
        </ul> 
    </div>
</header>    

    <div class="container-4">
        <h2>Order Report</h2>
        <form method="post" action="#" class="date">
            <label for="date_from">From:</label>
            <input type="datetime-local" id="date_from" name="date_from" value="<?php echo $dateFrom; ?>">
            <label for="date_to">To:</label>
            <input type="datetime-local" id="date_to" name="date_to" value="<?php echo $dateTo; ?>">
            <input type="submit" value="Filter">
        </form>
        <div>
        <h3>Summary Statistics</h3>
        </div>
        <table>
            <!--<tr>
                <th>Statistics</th>
                <th>Value</th>
            </tr>-->
            <tr>
                <td>Total Orders</td>
                <td><?php echo $totalOrders; ?></td>
            </tr>
            <tr>
                <td>Total Revenue</td>
                <td>₱<?php echo $totalRevenue; ?></td>
            </tr>
            <tr>
                <td>Average Order Value</td>
                <td>₱<?php echo number_format($averageOrderValue, 2); ?></td>
            </tr>
        </table>
        <table>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Contact Num</th>
                <th>Address</th>
                <th>Mode of Payment</th>
                <th>Total Price</th>
                <th>Order Date</th>
                <th>Received Date</th>
                <th>Status</th>
            </tr>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['orderid']; ?></td>
                    <td><?php echo $order['userid']; ?></td>
                    <td><?php echo $order['name']; ?></td>
                    <td><?php echo $order['contact_num']; ?></td>
                    <td><?php echo $order['address']; ?></td>
                    <td><?php echo $order['mode_of_payment']; ?></td>
                    <td>₱<?php echo $order['total_price']; ?></td>
                    <td><?php echo $order['order_date']; ?></td>
                    <td><?php echo $order['received_date']; ?></td>
                    <td><?php echo $order['status']; ?></td>

                </tr>
            <?php endforeach; ?>
        </table>
        <div class="button">
        <a href="home.php" class="back-listbtn">Back to Home</a>
        </div>
    </div>
    <script src="app.js"></script>
</body>
</html>