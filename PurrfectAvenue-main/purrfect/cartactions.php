<!-- NOT WORKING PA -->
<?php
session_start();
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id']; 
    $quantity = $_POST['quantity']; 

    // Validate product ID and quantity (you can add more validation logic here)

    // Check if the item is already in the cart for the current user
    $sql = "SELECT id, quantity FROM shopping_cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $_SESSION["user_id"], $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Item already exists in the cart, update the quantity
        $row = $result->fetch_assoc();
        $new_quantity = $row["quantity"] + $quantity;
        $update_sql = "UPDATE shopping_cart SET quantity = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ii", $new_quantity, $row["id"]);
        $update_stmt->execute();
        $update_stmt->close();
        $response = array("success" => true);
    } else {
        // Item does not exist in the cart, insert a new record
        $insert_sql = "INSERT INTO shopping_cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("iii", $_SESSION["user_id"], $product_id, $quantity);
        $insert_stmt->execute();
        $insert_stmt->close();
        $response = array("success" => true);
    }
    // Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle delete item from cart action
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $cart_item_id = $_POST['cart_item_id']; // Assuming this is the ID of the item in the shopping cart

        // Delete the item from the shopping cart
        $delete_sql = "DELETE FROM shopping_cart WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $cart_item_id);
        $delete_stmt->execute();
        $delete_stmt->close();

        echo json_encode(array("success" => true));
        exit();
    }

    // Handle update item quantity in cart action
    if (isset($_POST['action']) && $_POST['action'] === 'update_quantity') {
        $cart_item_id = $_POST['cart_item_id'];   // Assuming this is the ID of the item in the shopping cart
        $new_quantity = $_POST['new_quantity'];   // Assuming this is the new quantity for the item

        // Update the item quantity in the shopping cart
        $update_sql = "UPDATE shopping_cart SET quantity = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ii", $new_quantity, $cart_item_id);
        $update_stmt->execute();
        $update_stmt->close();

        echo json_encode(array("success" => true));
        exit();
    }
}
    echo json_encode($response);
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}
?>