<!-- 

Name: Jatin Kumar
Internship: Web Development
Task: Basic Banking System
Batch: May 2021 

-->
<?php
session_start();
require_once("connection.php");

if(isset($_SESSION['username'])){
    header('Location: home.php');
    exit;
}

function filterText($str){
    $str = strip_tags($str);
    $str = trim($str);
    $str = addslashes($str);
    return $str;
}

if(isset($_POST["email"]) && isset($_POST["pass"])){
    echo "hello";
    $email = filterText($_POST['email']);
    $pass = filterText($_POST['pass']);

    if($email == ''){
        $_SESSION['errors'] = 'Email required';
        header('Location: index.php');
        exit;
    }

    else if($pass == ''){
        $_SESSION['errors'] = 'Password required';
        header('Location: index.php');
        exit;
    }

    else{
        $sql = "SELECT * FROM employee WHERE Eemail='$email' AND Epass='$pass'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        print_r($result->num_rows);
        if($result->num_rows == 0){
            $_SESSION['errors'] = 'Invalid Credentials!';
            header('Location: index.php');
            exit;
        }
        else {
            $_SESSION['username'] = $row['Ename'];
            header('Location: home.php');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Welcome to SBC BANK</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="public/img/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="public/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="public/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="public/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="public/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="public/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="public/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="public/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="public/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="public/css/util.css">
	<link rel="stylesheet" type="text/css" href="public/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('public/img/bg-01.jpg');">
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
					SBC BANK Login
				</span>
				<form class="login100-form validate-form p-b-33 p-t-5" method="post">

					<div class="wrap-input100 validate-input" data-validate = "Enter email">
						<input class="input100" type="email" name="email" placeholder="Email">
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="pass" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>

					<div class="container-login100-form-btn m-t-32">
						<input class="login100-form-btn button" type="submit" placeholder="Login" value="Login">
													<!-- </button> -->
					</div>

				</form>
                <div>
                    <span class="login100-form-error p-b-41"> <?php 
                    if(isset($_SESSION['errors'])){
                        echo $_SESSION['errors'];
                        unset($_SESSION['errors']);
                    }
                     ?> </span>
                    </div>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="public/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="public/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="public/vendor/bootstrap/js/popper.js"></script>
	<script src="public/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="public/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="public/vendor/daterangepicker/moment.min.js"></script>
	<script src="public/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="public/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="public/js/main.js"></script>

</body>
</html>