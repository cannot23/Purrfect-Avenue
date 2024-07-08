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
    <title>Registration Form</title> 
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container-register">
        <div class ="form register"> 
			 
                <?php
                if (isset($_POST['submit'])){ //makes sure that the submit has been clicked
                // Declaration of variables
                $firstName = $_POST['firstname'];
                $lastName = $_POST['lastname'];
                $email = $_POST['email'];
                $phone = $_POST['phone']; // Added phone number
                $address = $_POST['address']; // Added address
                $password = $_POST['password'];
                $passwordRepeat = $_POST['repeat-password'];

                // Password encryption
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                // Errors stored in an array for validation
                $errors = array();
                if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($passwordRepeat)) {
                    array_push($errors,"All fields are required");
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    array_push($errors, "Invalid Email Address");
                }
                if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
                    array_push($errors,"Password must be at least 8 characters and include at least one number, symbol, uppercase, and lowercase letter.");
                }
                if ($password !== $passwordRepeat) {
                    array_push($errors,"Password does not match");
                }
                require_once "database.php";
                // To make sure the user doesn't use the same email
                $sql = "SELECT * FROM users WHERE email = '$email' OR contact_num = '$phone'";
                $result = mysqli_query($conn, $sql);
                $rowCount = mysqli_num_rows($result);
                if ($rowCount > 0) {
                    array_push($errors, "Email or Phone number already exists.");
                }
                if (count($errors) > 0) {
                    foreach ($errors as $error) {
                        echo "<div class='error'><p class='errormsg'>$error</p></div>";
                    }
                } else {
                    // Add the is_admin attribute and set its default value to false
                    $is_admin_default = false;

                    $sql = "INSERT INTO users (firstName, lastName, email, password, contact_num, address, is_admin) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

                    if ($prepareStmt) {
                        mysqli_stmt_bind_param($stmt, "ssssssi", $firstName, $lastName, $email, $passwordHash, $phone, $address, $is_admin_default);
                        mysqli_stmt_execute($stmt);
                        echo "<div><p class='alert-success'>Registration Successful.</p></div>";
                    } else {
                        die("Something went wrong");
                    }
                }
                }
			?>
				<div class="form-container"> 
					<form action="registration.php" method="post"> 
						<h3>Register</h3>
						<input type="text" name="firstname"  placeholder="Enter your first name"> 
						<input type="text" name="lastname" placeholder="Enter your last name"> 
						<input type="email" name="email" placeholder="Enter your email"> 
                        <input type="text" name="phone" placeholder="Enter your phone number">
                        <input type="text" name="address" placeholder="Enter your address">
						<div class="field input-field">	
							<input type="password" name="password" placeholder="Enter your password"> 
							<i class='bx bx-hide eye-icon register toggle-register'></i> 
						</div>	
						<div class="field input-field">
						    <input type="password" name="repeat-password" placeholder="Confirm your password">  
                            <i class='bx bx-hide eye-icon register toggle-repeat-password'></i>
                        </div>
						<p>By clicking the register button, you agree to our<br><a href="#" onclick="openTermsModal()">Terms and Conditions</a> and <a href="#" onclick="openTermsModal()">Privacy Policy</a></p>
						<input type="submit" name="submit" value="Register" class="form-btn">  
						<p>Already have an account? <a href="login.php">Log in here</a></p>
					</form>
				</div>
			</div> 
		</div>
    </div>
    <!-- Terms and Conditions Modal -->
    <!-- Terms and Conditions and Privacy Policy Modal -->
<div id="termsModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Terms and Conditions</h2>
        <p>Last updated: <strong>9th July, 2024</strong></p>
        <br><p>Welcome to <strong>Purrfect Avenue,</strong> your number one source for all pet products. We're dedicated to giving you the very best of pet supplies, with a focus on dependability, customer service, and uniqueness.</p></br>
        
        <p><strong>1. Use of Our Service.</strong> You agree that by accessing the site, you have read, understood, and agree to be bound by all of these Terms and Conditions.</p>
        <p><strong>2. Products.</strong> All products are subject to return or exchange only according to our Return Policy.</p>
        <p><strong>3. Order Cancellation.</strong> Orders can be canceled within 24 hours of placing the order. Please contact our customer service team to process cancellations.</p>
        <p><strong>4. Limitation of Liability.</strong> Purrfect Pet Services shall not be liable for any indirect, incidental, or consequential damages that may result from the use of our products.</p>
        
        
        <br><hr></br>
        <h2>Privacy Policy</h2>
        <p>Last updated: <strong>9th July, 2024</strong></p>
        <br><p>At <strong>Purrfect Avenue,</strong> accessible from <strong>www.PurrfectAvenue.com,</strong> one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by Purrfect Pet Services and how we use it.</p></br>
        
        <p><strong>1. Information We Collect.</strong> The personal information that you are asked to provide, and the reasons why you are asked to provide it, will be made clear to you at the point we ask you to provide your personal information.</p>
        <p><strong>2. How We Use Your Information.</strong> We use the information we collect in various ways, including to:</p>
        <ul style="padding-left: 30px;">
            <li>Provide, operate, and maintain our website</li>
            <li>Improve, personalize, and expand our website</li>
            <li>Understand and analyze how you use our website</li>
            <li>Develop new products, services, features, and functionality</li>
        </ul>
        <p><strong>3. Log Files.</strong> Purrfect Pet Services follows a standard procedure of using log files.</strong>
    </div>
</div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
		const togglePassword = document.querySelector(".toggle-register"), 
        toggleRepeatPassword = document.querySelector(".toggle-repeat-password"),
        passwordInput = document.querySelector("input[name='password']"),
		repeatPasswordInput = document.querySelector("input[name='repeat-password']"); 
		
        function togglePasswordVisibility(toggle, input) {
			if(input.type === "password") {
				input.type = "text"; 
				toggle.classList.replace("bx-hide", "bx-show");
			} else {
				input.type = "password"; 
				toggle.classList.replace("bx-show", "bx-hide");
			}
		}
        togglePassword.addEventListener("click", () => {
            togglePasswordVisibility(togglePassword, passwordInput);
        }); 
        toggleRepeatPassword.addEventListener("click", () => {
            togglePasswordVisibility(toggleRepeatPassword, repeatPasswordInput);
        });
    });
	</script>
    <script>
    function openTermsModal() {
            document.getElementById('termsModal').style.display = 'block';
        }
        
        var span = document.getElementsByClassName("close")[0];
        
        span.onclick = function() {
            document.getElementById('termsModal').style.display = 'none';
        }
        
        window.onclick = function(event) {
            if (event.target == document.getElementById('termsModal')) {
                document.getElementById('termsModal').style.display = 'none';
            }
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</body>
</html>