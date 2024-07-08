

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<header>
<a href="home.php"><img src="images/Background/back-arrow.png" class="logo" onclick="ExitPostAlert()"></a> 
</header>
<body>
<div class="container">
    <div class="form-container">
    <div class="form register">
<h2>Apply for a Role</h2>
    <form action="requestprocess.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="role">Select a Role:</label>
        <select id="role" name="role" required>
            <option value="seller">Seller</option>
            <option value="rider">Rider</option>
        </select><br><br>
        <input type="submit" value="Submit">
    </form>
    </div>
    </div>
</div>
</body>
</html>