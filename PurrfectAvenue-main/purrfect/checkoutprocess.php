<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id']) && !empty($_SESSION['cart'])) {
    // Include the database connection file
    include_once 'database.php';

    // Get user information
    $user_id = $_SESSION['user_id'];
    $paymentMode = $_POST['paymentMode'];

    // Determine which address to use
    if ($_POST['address_option'] === 'registered') {
        // Use registered address
        $sql = "SELECT address, contact_num FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($address, $contact_num);
        $stmt->fetch();
        $stmt->close();
    } else {
        // Use new address
        $address = $_POST['new_address'];
        // Ensure to retrieve the contact_num from the form data
        $sql = "SELECT contact_num FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($contact_num);
        $stmt->fetch();
        $stmt->close();
        
    }

    // Get user's first name and last name
    $sql = "SELECT firstName, lastName FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($firstName, $lastName);
    $stmt->fetch();
    $stmt->close();

    // Insert order details into orders table
    $stmt = $conn->prepare("INSERT INTO orders (userid, name, contact_num, address, mode_of_payment, total_price) VALUES (?, ?, ?, ?, ?, ?)");
    $totalPrice = 0; // Initialize total price
    $name = $firstName . ' ' . $lastName; // Concatenate first name and last name
    $stmt->bind_param("issssd", $user_id, $name, $contact_num, $address, $paymentMode, $totalPrice); // Pass total price normally
    $stmt->execute();
    $orderId = $stmt->insert_id;
    $stmt->close();

    // Calculate total price of the order
    foreach ($_SESSION['cart'] as $productId => $quantity) {
        $stmt = $conn->prepare("SELECT product_price FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $stmt->bind_result($productPrice);
        $stmt->fetch();
        $stmt->close();

        $totalPrice += $productPrice * $quantity;
    }

    // Update total price in the orders table
    $stmt = $conn->prepare("UPDATE orders SET total_price = ? WHERE orderid = ?");
    $stmt->bind_param("di", $totalPrice, $orderId);
    $stmt->execute();
    $stmt->close();

    // Insert order items into order_items table
    foreach ($_SESSION['cart'] as $productId => $quantity) {
        $stmt = $conn->prepare("INSERT INTO order_items (orderid, productid, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $orderId, $productId, $quantity);
        $stmt->execute();
        $stmt->close();
    }

    // Clear the cart after successful checkout
    $_SESSION['cart'] = [];

    // Display a success message or perform other actions
    echo "<div class='empty-cart' style='background-image: url(\"/purrfect/images/Background/checkoutyes.png\"); background-size: cover; justify-content:center; align-items: center; width: 100%; height: 98vh; display: flex; flex-direction: column'>"
    . "<div style='display: flex; justify-content: center; gap: 10px;'>"
    . "<a href='home.php' style='background-color: #C55A11; color:white; font-size: 20px; padding: 6px 10px; margin: 4px 2px; border: none; border-radius: 4px; text-decoration: none'>Home page</a>"
    . "<a href='products.php' style='background-color: #C55A11; color:white; font-size: 20px; padding: 6px 10px; margin: 4px 2px; border: none; border-radius: 4px; text-decoration: none'>Shop more</a>"
    . "</div>"
    . "</div>";

    // You can redirect the user to a confirmation page or display a success message here

} else {
    // Redirect to the home page if user is not logged in or cart is empty
    header("Location: home.php");
    exit();
}

// Close the database connection
$conn->close();
?>
