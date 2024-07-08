<?php
session_start(); // Start the session if not already started

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
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

    </style>
<body>
<header>
	<a href="productsadmin.php"><img src="images/Background/back-arrow.png" class="logo" onclick="ExitPostAlert()"></a> 
</header> 
<div class="container">
    <div class="form-container">
    <div class="form register">
    
    <form method="post" action="postprocess.php"  onsubmit="return PostAlert()">
                
    <label for="imgurl">Image URL</label>
    <input type="text" name="imgurl" required>

    <label for="productName">Product Name</label>
    <input type="text" name="productName" required>

    <label for="productPrice">Product Price</label>
    <input type="text" name="productPrice" required>

    <label for="stockQuantity">Stock Quantity</label>
    <input type="number" name="stockQuantity" required>
    

    <div class="product-categories">
    <label for="productGroup">Product Category <span style="color: red;">REQUIRED</span><br><br></label>

    <label for="petfood">Pet Food</label>
    <input type="radio" name="productGroup" id= "food" value="food">

    <label for="petfood">Health and wellness products (vitamins, supplements)</label>
    <input type="radio" name="productGroup" id= "health" value="health">

    <label for="petfood">Collars, leashes, and harnesses</label>
    <input type="radio" name="productGroup" id= "accessory" value="accessory">

    <label for="petfood">Toys for pets</label>
    <input type="radio" name="productGroup" id= "toy" value="toy">

    <label for="petfood">Bedding and cages</label>
    <input type="radio" name="productGroup" id= "bedcage" value="bedcage">

    <label for="petfood">Grooming supplies (brushes, shampoos)</label>
    <input type="radio" name="productGroup" id= "supplies" value="supplies">
    
    <label for="petfood">Pet Utilities</label>
    <input type="radio" name="productGroup" id= "utility" value="utility">
    </div>
<!-- -->
    <label for="productDesc">Product Description:</label>
    <input type="text" name="productDesc" required>
    
    <button type="submit">Submit</button>
</form>
</div>
</div>
</div>
<script src="script.js"></script>
</body>
</html>