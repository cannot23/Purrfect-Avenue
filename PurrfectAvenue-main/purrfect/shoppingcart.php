<?php
    session_start();
    include_once 'database.php';

    if (!empty($_SESSION['cart'])) {
        $totalPrice = 0;
        ?>

        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Shopping Cart</title>
            <style>
            /* General page styling */
                .shoppingcart {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 20px;
                    background-color: #f4f4f4;
                }

                h1 {
                    color: #333;
                }

                /* Table styling */
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                }

                table, th, td {
                    border: 1px solid #ddd;
                }

                th, td {
                    padding: 8px;
                    text-align: left;
                }

                th {
                    background-color: #C55A11;
                    color: white;
                }

                td img {
                    margin-right: 10px;
                    vertical-align: middle;
                }
                table td:nth-child(2), 
                table td:nth-child(3), 
                table td:nth-child(4), 
                table td:nth-child(5) {
                    text-align: right;
                }
                th:nth-child(1), td:nth-child(1) {
                    text-align: left;
                }
                th:nth-child(2),
                th:nth-child(3), 
                th:nth-child(4),
                th:nth-child(5) {
                    text-align: right;
                }
                /* Button styling */
                input[type="submit"] {
                    background-color: #474847;
                    color: white;
                    padding: 6px 10px;
                    margin: 4px 2px;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                }
                input[type="submit"]:hover {
                    background-color: #C55A11;
                }

                input[type="number"] {
                    background-color: transparent;
                    color: #333;
                    padding: 6px;
                    margin: 4px 2px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                }
                /* Checkout link styling */
                .shpcrt {
                    text-align: right;
                }
                a {
                    display: inline-block;
                    background-color: #C55A11;
                    color: white;
                    padding: 10px 20px;
                    margin: 20px 0;
                    text-decoration: none;
                    border-radius: 5px;
                }
                .first {
                    margin-right: 10px;
                }
                a:hover {
                    background-color: #b95613;
                }
            </style>
        </head>
        
        <body class="shoppingcart">
        <h1>Shopping Cart</h1>   
        <table>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <?php
            foreach ($_SESSION['cart'] as $productId => $quantity) {
                $quantity = isset($quantity) ? $quantity : 1;
                $stmt = $conn->prepare("SELECT product_name, product_price, image_url FROM products WHERE product_id = ?");
                $stmt->bind_param("i", $productId);
                $stmt->execute();
                $stmt->bind_result($productName, $productPrice, $imageUrl);
                $stmt->fetch();
                $stmt->close();

                
                $total = $productPrice * $quantity;
                $totalPrice += $total;
                ?>
                <tr>
                    <td>
                        <div>
                            <img src="<?php echo $imageUrl; ?>" alt="<?php echo $productName; ?>" style="width: 100px;">
                            <span><?php echo $productName; ?></span>
                        </div>
                    </td>
                    <td>₱<?php echo $productPrice; ?></td>
                    <td>
                        <form method="post" action="updatecart.php">
                            <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                            <input type="number" name="quantity" value="<?php echo $quantity; ?>" min="1">
                            <input type="submit" name="update" value="Update">
                        </form>
                    </td>
                    <td>₱<?php echo number_format($total, 2); ?></td>
                    <td>
                        <form method="post" action="removefromcart.php">
                            <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                            <input type="submit" name="remove" value="Remove">
                        </form>
                    </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="3" align="right">Total:</td>
                <td colspan="1">₱<?php echo number_format($totalPrice, 2); ?></td>
            </tr>
        </table>
        <div class="shpcrt">
            <a href="products.php" class="first">Back</a>
            <a href="checkout.php" class="second">Proceed to Checkout</a>
        </div>
        <script src="app.js"></script>
        </body>
        </html>
        <?php
    } else {
        echo "<div class='empty-cart' style='background-image: url(\"/purrfect/images/Background/gen.png\"); background-size: cover; justify-content:center; align-items: center; width: 100%; height: 98vh; display: flex; flex-direction: column'>
                <p style='font-size: 30px;'>Your cart is empty.</p>
                <form action='products.php' method='get'>
                    <button type='submit' style='background-color: #C55A11; color:white; font-size: 20px; padding: 6px 10px; margin: 4px 2px; border: none; border-radius: 4px;'>Shop</button>
                </form>
                </div>";
    }

    $conn->close();
    ?>
