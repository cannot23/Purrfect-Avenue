<?php //redirected to dashboard if nakalogin na sila
session_start();
if (isset($_SESSION['user'])){
    header("Location: home.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title> 
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">   
</head>
<body>
    <div class="container">
        <div class ="form login"> 
			<div class="form-content"> 
                <?php
                    if(isset($_POST['login'])){//makes sure that login has been pressed to execute code
                        //declaration of variables
                        $email = $_POST['email'];
                        $password = $_POST['password'];

                        require_once "database.php";
                        $sql = "SELECT * FROM users WHERE email = '$email'";
                        $result = mysqli_query($conn, $sql);
                        $user = mysqli_fetch_array($result, MYSQLI_ASSOC); //used to store the result in an array
                        if ($user) {
								if(password_verify($password, $user['password'])){
									session_start();
									$_SESSION['user'] = 'yes';
									$_SESSION['user_email'] = $user['email'];
									$_SESSION['user_id'] = $user['user_id'];
									header("Location: home.php");//after successful login, user will be redirected
									die();
								}else{
									echo "<div><p class='errormsg'>Incorrect password<p></div>";
								}
							}else{
								echo "<div><p class='errormsg'>Email does not exist<p></div>";
                        }
                    }
                ?> 
					<div class="form-container">
						<form action="login.php" method="post">
							<h3>Login</h3>
							<input type="email" name="email" placeholder="Enter your email">
							<div class="field input-field">
								<input type="password" name="password" placeholder="Enter your password"> 
								<i class='bx bx-hide eye-icon login toggle-login'></i> 
							</div>
							<input type="submit" name="login" value="Login" class="form-btn">
							<p>Don't have an account? <a href="registration.php">Register here</a></p>	
						</form> 
					</div>
			</div>
		</div>
    </div>
    <script>
		const toggle = document.querySelector(".toggle-login"), 
		input = document.querySelector(".field input[name='password']"); 
		
		toggle.addEventListener("click", ()=>{
			if(input.type === "password"){
				input.type = "text"; 
				toggle.classList.replace("bx-hide", "bx-show");
			} else {
				input.type = "password"; 
				toggle.classList.replace("bx-show", "bx-hide");
			}
		})
	</script>
</body>
</html>