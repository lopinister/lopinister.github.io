<?php
include('userregister.php'); 
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Registration Form - Art Mobi</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php include('styles.php');
  ?>
</head>

<body>
	<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
		<header class="masthead mb-auto">
			<div class="inner">
				<h3 class="masthead-brand">Art MOBI</h3>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<nav class="nav nav-masthead justify-content-center">
					<a class="nav-link" href="./index.php">Home</a>
					<a class="nav-link active" href="./register.php">Sign Up</a>
					<a class="nav-link" href="./login.php">Log in</a>
				</nav>
			</div>
		</header>
		<div class="wrapper" style="background-image: url('images/bg-registration-form-1.jpg');">
			<div class="inner">
				<div class="image-holder">
					<img src="images/registration-form-1.jpg" alt="">
				</div>
				<form method="POST">
					<h3>Registration Form</h3>
					<div class="form-group">
						<input type="text" name="first_name" placeholder="First Name" class="form-control">
						<input type="text" name="last_name" placeholder="Last Name" class="form-control">
					</div>
					<div class="form-wrapper">
						<input type="text" name="username" placeholder="Username" class="form-control" value="<?php echo $username; ?>">
						<i class="zmdi zmdi-account"></i>
					</div>
					<div class="form-wrapper">
						<input type="text" name="email" placeholder="Email Address" class="form-control" value="<?php echo $email; ?>">
						<i class="zmdi zmdi-email"></i>
					</div>
					<div class="form-wrapper">
						<input type="text" name="address" placeholder="Address" class="form-control">
					</div>
					<div class="form-wrapper">
						<input type="password" name="password_1" placeholder="Password" class="form-control">
						<i class="zmdi zmdi-lock"></i>
					</div>
					<div class="form-wrapper">
						<input type="password" name="password_2" placeholder="Confirm Password" class="form-control">
						<i class="zmdi zmdi-lock"></i>
					</div>
					<?php echo display_error(); ?>
					<button type="submit" name="reg_user">Register
						<i class="zmdi zmdi-arrow-right"></i>
					</button>
					<br><br>
					Already a member? 
					<a href="register.html">
						Sign in
						<i class="zmdi zmdi-arrow-right" aria-hidden="true"></i>
					</a>
				</form>
			</div>
		</div>
		<?php include('footer.php');
    ?>
</body>

</html>