<?php 
session_start();

include 'database.php';

$sql = "SELECT is_admin FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

$sql = "SELECT products.*, stocks.quantity AS stock_quantity FROM products INNER JOIN stocks ON products.product_id = stocks.product_id";
$result = mysqli_query($conn, $sql);

$productsByGroup = [];
while ($row = mysqli_fetch_assoc($result)) {
    $productsByGroup[$row['product_group']][] = $row;
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<section class="products">
<header>
    <a href="home.php"><img src="images/Background/logo.png" class="logo"></a>
    <div class="nav-bar">
        <div class="toggle"></div>
        <ul class="navigation">
            <?php 
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            $itemCnt = array_sum($_SESSION['cart']);
            
            if (isset($_SESSION['user_id'])): ?>
            <?php
               echo "<li><a href='shoppingcart.php'><img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAAA60lEQVR4nO3WsQpBURjA8VsmKwNG5Q1MJoOFlFmKJ7BY5QHkJZTJG9ydYrPZhZXBoAh/XX1ic45z7pH4z1/n11nOdzzvJwPGPFoA1U/AQScg4wS/BwxuNHQ8lwEVgaeu4SiwB85AwjXuy60bruEm4TR6BadDglcqt56HAPdV4F4IcE0FzltGL0BSBY4AG4vw7CX6hA8twl0duG4RLujAMVkYpu2DF1EZFnxiAfa1UIHbFuDWO3AK2BmgWyCuDQueC9YkcNQAD/LByL6F/m5AGVgHGwYomc4pJwfdW5rOfQVckkOXQNF07p/nqit4etkTHpfOQQAAAABJRU5ErkJggg=='><span id='itemCount'>$itemCnt</span></a></li>";
                ?>
                <li><a href="orderspage.php">My Orders</a></li>
                <li><a href="orderhistory.php">Order History</a></li>
                <li><a href="home.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="settings.php">User Settings</a></li>
                <li><a href="bookappointment.php">Book an Appointment</a></li> 
					<li><a href="userviewappointment.php">My Appointments</a></li> 
                <li><a href="#" onclick="logoutAlert()">Log Out</a></li>
            <?php else: ?>
                <?php
               echo "<li><a href='shoppingcart.php'><img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAAA60lEQVR4nO3WsQpBURjA8VsmKwNG5Q1MJoOFlFmKJ7BY5QHkJZTJG9ydYrPZhZXBoAh/XX1ic45z7pH4z1/n11nOdzzvJwPGPFoA1U/AQScg4wS/BwxuNHQ8lwEVgaeu4SiwB85AwjXuy60bruEm4TR6BadDglcqt56HAPdV4F4IcE0FzltGL0BSBY4AG4vw7CX6hA8twl0duG4RLujAMVkYpu2DF1EZFnxiAfa1UIHbFuDWO3AK2BmgWyCuDQueC9YkcNQAD/LByL6F/m5AGVgHGwYomc4pJwfdW5rOfQVckkOXQNF07p/nqit4etkTHpfOQQAAAABJRU5ErkJggg=='><span id='itemCount'>$itemCnt</span></a></li>";
                ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="registration.php">Sign Up</a></li>
            <?php endif; ?>
        </ul>
    </div>
</header>
    <div class="category category-1">
        <!-- <div class="ecart">
            <div class="ecart-header cursor" onclick="toggleCart()">
                <h3>View Cart</h3>
            </div> -->
            <div class="cart" id="cart">
                <h2>Shopping Cart</h2>
                <div id="cart-content"></div>
                <div id="total"></div>
            </div> 
        </div>
        <?php foreach ($productsByGroup as $group => $products): ?>
            <div class="header-title">
                <h1><?php echo htmlspecialchars($group); ?></h1>
            </div>
            <div class="grid-container">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <div class="product-image" style="background-image: url('<?php echo $product['image_url']; ?>');"></div>
                        <div class="product-details">
                            <div class="product-id" style="display: none;"><?php echo $product['product_id']; ?></div>
                            <div class="product-name"><?php echo $product['product_name']; ?></div>
                            <div class="product-description"><?php echo $product['product_desc']; ?></div>
                            <div class="product-price">₱<?php echo $product['product_price']; ?></div>
                            <?php
                            if ($product['stock_quantity'] == 0) {
                                echo "<button class='add-to-cart' disabled>Out of Stock</button>";
                            } else {
                                echo "<button class='add-to-cart' onclick='addToCart({$product['product_id']}, \"{$product['product_name']}\", \"{$group}\", {$product['product_price']})'>Add to Cart</button>";
                            }
                            if (isset($admin) && $admin['is_admin'] == 1) {
                                echo '<a href="modifyproducts.php?product_id=' . htmlspecialchars($product['product_id']) . '" class="modify-product-btn">Update</a>';
                            }
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <script src="app.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</section>
</body>
</html>