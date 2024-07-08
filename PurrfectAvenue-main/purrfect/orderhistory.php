<?php
session_start();
include_once 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM orders WHERE userid = ? AND status = 'Received' ORDER BY received_date DESC"; // Fetch only received orders and sort by received date
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
/* General page styling */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 20px;
    padding-top: 110px;
    background-color: #f4f4f4;
}
.history {
    display: block;
    margin-top: 90px;
    width: 70%;
    margin: auto    ;
}
h1 {
    color: #333;
}

/* User Info Styling */
.user-info {
    background-color: #ddd;
    padding: 10px;
    margin-bottom: 20px;
}

/* Table styling */
.orders-table {
    width: 100%;
    border-collapse: collapse;
}

.orders-table, th, td {
    border: 1px solid #ddd; 
    padding: 8px;
}

th, td {
    padding: 8px;
    text-align: left;
}

th {
    background-color: #C55A11;
    color: white;
}
td ul li {
    list-style-type: none; /* Remove bullet points */
}
.order-details {
    margin-top: 60px;
}

.order-details th, .order-details td {
    text-align: left;
}
.order {
    text-align: right;
}
/* Links styling */
a.first, a.second, .order-received input[type="submit"] {
    margin-top: 20px;
    display: inline-block;
    background: #C55A11;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
}
.order-total-row, .order-row {
    font-weight: bold; /* Make the text bold */
    background-color: #f0f0f0; /* Light grey background for slight emphasis */
}

a.second, .order-received input[type="submit"] {
    background: #333;
}

</style>
<body>
<header>
    <a href="home.php"><img src="images/Background/logo.png" class="logo"></a> 
    <div class="nav-bar">
        <div class="toggle"></div>
        <ul class="navigation"> 
        <li><a href='shoppingcart.php' ><img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAAA60lEQVR4nO3WsQpBURjA8VsmKwNG5Q1MJoOFlFmKJ7BY5QHkJZTJG9ydYrPZhZXBoAh/XX1ic45z7pH4z1/n11nOdzzvJwPGPFoA1U/AQScg4wS/BwxuNHQ8lwEVgaeu4SiwB85AwjXuy60bruEm4TR6BadDglcqt56HAPdV4F4IcE0FzltGL0BSBY4AG4vw7CX6hA8twl0duG4RLujAMVkYpu2DF1EZFnxiAfa1UIHbFuDWO3AK2BmgWyCuDQueC9YkcNQAD/LByL6F/m5AGVgHGwYomc4pJwfdW5rOfQVckkOXQNF07p/nqit4etkTHpfOQQAAAABJRU5ErkJggg=='><span id='itemCount'><?php echo array_sum($_SESSION['cart']); ?></span></a></li>
            <li><a href="orderspage.php">My Orders</a></li>
            <li><a href="orderhistory.php">Order History</a></li>
            <li><a href="home.php">Home</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="settings.php">User Settings</a></li>
            <li><a href="#" onclick="logoutAlert()">Log Out</a></li>
        </ul> 
    </div>
</header>  
    <?php if (empty($result)): ?>
        <div class="empty-cart" style="background-image: url('/purrfect/images/Background/gen.png'); background-size: cover; justify-content:center; align-items: center; width: 100%; height: 98vh; display: flex; flex-direction: column;">
            <p style="font-size: 30px;">You haven't ordered anything yet.</p>
            <div style="margin-top: 20px;">
                <a href="products.php" class="first">Shop</a>
                <a href="shoppingcart.php" class="second">Shopping Cart</a>
            </div>
        </div>
<div class="history">
    <?php else: ?>
        <div class="user-info">
            <p><strong>Name:</strong> <?php echo $result[0]['name']; ?></p>
            <p><strong>Contact Number:</strong> <?php echo $result[0]['contact_num']; ?></p>
            <p><strong>Address:</strong> <?php echo $result[0]['address']; ?></p>
        </div>
        <h1>Order History</h1>
        <?php foreach ($result as $row): ?>
            <div class="order-details">
                <table class="orders-table">
                    <tr class="order-row">
                        <td><strong>Date Received:</strong></td>
                        <td><?php echo htmlspecialchars($row['received_date'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                    <tr class="order-row">
                        <td><strong>Date Ordered:</strong></td>
                        <td><?php echo htmlspecialchars($row['order_date'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                    <tr class="order-row">
                        <td><strong>Mode of Payment:</strong></td>
                        <td><?php echo htmlspecialchars($row['mode_of_payment'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                </table>
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Products Received</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $conn->prepare("SELECT products.product_name, order_items.quantity, products.product_price, products.image_url FROM order_items INNER JOIN products ON order_items.productid = products.product_id WHERE orderid = ?");
                        $stmt->bind_param("i", $row['orderid']);
                        $stmt->execute();
                        $resultItems = $stmt->get_result(); 
                        $orderTotal = 0; 
                        while ($item = $resultItems->fetch_assoc()):
                            $productTotal = $item['product_price'] * $item['quantity']; // Calculate total price per product
                            $orderTotal += $productTotal; // Add to order total
                        ?>
                        <tr>
                            <td>
                                <img src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['product_name']; ?>" style="width: 100px;">
                                <?php echo $item['product_name']; ?>
                            </td>
                            <td>x<?php echo $item['quantity']; ?></td>
                            <td>₱<?php echo $productTotal; ?></td>
                        </tr>
                        <?php endwhile; ?>
                        <tr class="order-total-row">
                            <td colspan="2" style="text-align: right;"><strong>Order Total:</strong></td>
                            <td>₱<?php echo $orderTotal; ?></td>
                        </tr> 
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>
        <div style="text-align: right; margin-top: 20px;">
            <a href="products.php" class="first">Back</a>
            <a href="shoppingcart.php" class="second">Shopping Cart</a>
        </div>
    <?php endif; ?>
</div>
<script src="app.js"></script>
</body>
</html>

<?php
$conn->close();
?>
