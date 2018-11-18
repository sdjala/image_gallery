<?php
include 'utils/dbh.php';
			// Initialize the session
		session_start();
		
		// Check if the user is already logged in, if yes then redirect him to welcome page
		if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
			header("location: admin/home.php");
			exit;}

	include 'partials/header.php';

	$msg = "";

	if (isset($_POST['submit'])) {

		$email = $con->real_escape_string($_POST['email']);
		$password = $con->real_escape_string($_POST['password']);

		if ($email == "" || $password == "")
			$msg = "Please check your inputs!";
		else {
			$sql= "SELECT id, name, password, isEmailConfirmed FROM users WHERE email='$email' ";
			$result = mysqli_query($con, $sql);
			if ($result->num_rows > 0) {
				$data = mysqli_fetch_array($result);
				$verify = password_verify($password, $data['password']);
                if ($verify) {
                    if ($data['isEmailConfirmed'] == 0)
	                    $msg = "Please verify your email!";
                    else {
					   // $msg = "You have been logged in";
					   
					   // Password is correct, so start a new session
					   session_start();
                            
					   // Store data in session variables
					   $_SESSION["loggedin"] = true;
					   $_SESSION["id"] = $data['id'];
					   $_SESSION["username"] = $data['name'];                            
					   
					   // Redirect user to welcome page
					   header("location: admin/home.php");
                    }
                } else
					$msg = "Please check your inputs!";
					echo '<script>console.log('.json_encode($verify).')</script>';
			} else {
				$msg = "Please check your inputs!";
			}
		}
	}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log In</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container" style="margin-top: 100px;">
		<div class="row justify-content-center">
			<div class="col-md-6 col-md-offset-3" align="center">

				<!-- <img src="images/logo.png"><br><br> -->

				<?php if ($msg != "") echo $msg . "<br><br>" ?>

				<form method="post" action="login.php">
					<input class="form-control" name="email" type="email" placeholder="Email..."><br>
					<input class="form-control" name="password" type="password" placeholder="Password..."><br>
					<input class="btn btn-primary" type="submit" name="submit" value="Log In">
				</form>

			</div>
		</div>
	</div>
</body>
</html>