<?php
include "database.php"; // Include the database connection file
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $image_url = $_POST['imgurl'];
    $product_name = $_POST['productName'];
    $product_desc = $_POST['productDesc'];
    $product_price = $_POST['productPrice'];
    $product_group = $_POST['productGroup'];



    // Perform SQL insertion
    $sql = "INSERT INTO product (image_url, product_name, product_desc, product_price, product_group) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
            
    if ($prepareStmt) {
        mysqli_stmt_bind_param($stmt, "sssds", $image_url, $product_name, $product_desc, $product_price, $product_group);
        mysqli_stmt_execute($stmt);
        echo "<div><p class='alert-success'>Product added successfully.</p></div>";
    } else {
        die("Something went wrong");
    }

    mysqli_stmt_close($stmt); // Close the prepared statement
}

mysqli_close($conn); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process</title>
</head>
<body>
    <a href="dashboard.php">Back to Dashboard</a>
    <a href="products.php">Back to Products</a>
    <a href="postproduct.php">Post Another Product</a>
</body>
</html>
