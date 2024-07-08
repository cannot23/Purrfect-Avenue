<?php
// Include database connection
include_once 'database.php';

// Check if the user is logged in and is an admin
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'yes' || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History (Admin)</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style1.css">
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
            <li><a href="postproduct.php">Post Product</a>
            <li><a href="orderreport.php">Order Report</a></li>
            <li><a href="viewappointments.php">Appointments</a></li> 
            <li><a href="home.php">Admin Panel</a></li> 
            <li><a href="#" onclick="logoutAlert()">Log Out</a></li>            
        </ul> 
    </div>
</header>     
<div class="container-4">
    <h2>Products</h2>
    <?php
    // Fetch distinct product groups
    $groupSql = "SELECT DISTINCT product_group FROM products ORDER BY product_group ASC";
    $groupResult = $conn->query($groupSql);

    if ($groupResult->num_rows > 0) {
        while ($groupRow = $groupResult->fetch_assoc()) {
            $productGroup = $groupRow["product_group"];

            echo "<table>
                    <tr> 
                        <th colspan='5' style='text-align: center;'>" . strtoupper($productGroup) . "</th>;
                    </tr>
                    <tr>
                        <th>Products</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Update</th>
                    </tr>";

                // Fetch products for the current group
            $sql = "SELECT products.*, COALESCE(stocks.quantity, 0) AS quantity
                    FROM products
                    LEFT JOIN stocks ON products.product_id = stocks.product_id
                    WHERE products.product_group = '$productGroup'
                    ORDER BY products.product_name ASC";
            $result = $conn->query($sql);
                
            if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><img src='" . $row["image_url"] . "' alt='Product Image' style='width: 50px;'> " . $row["product_name"] . "</td>";
                    echo "<td>" . $row["product_desc"] . "</td>";
                    echo "<td> ₱" . $row["product_price"] . "</td>";
                    echo "<td>" . ($row["quantity"] == 0 ? "Out of Stock" : $row["quantity"]) . "</td>"; // Display the quantity
                    echo "<td><a href='modifyproducts.php?product_id=" . $row["product_id"] . "' class='update'>Update</a></td>"; 
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No products found in this group.</td></tr>";
            }
            echo "</table><br>";
        }
    } else {
        echo "<p>No product groups found.</p>";
    }
    ?>
</div>
<div class="button">
    <a href="home.php" class="back-listbtn">Back to Home</a>
</div>
<script src="app.js"></script>
</body>
</html>
<?php
// Close the database connection
$conn->close();
?>