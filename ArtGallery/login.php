<?php 
include('userlogin.php'); 
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Login - Art Mobi</title>
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
					<a class="nav-link" href="./register.php">Sign Up</a>
					<a class="nav-link active" href="./login.php">Log in</a>
				</nav>
			</div>
		</header>
		<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
				<p><?php if (isset($_SESSION['msg'])) : ?>
				<h3>
					<?php 
						echo $_SESSION['msg']; 
						unset($_SESSION['msg']);
					?>
				</h3>
	<?php endif ?></p>
	</div>
		</div>
		<div class="wrapper" style="background-image: url('images/bg-registration-form-1.jpg');">
			<div class="inner">
				<div class="image-holder">
					<img src="images/registration-form-1.jpg" alt="">
				</div>    
				<form method="POST">
					<h3>Member Login</h3>
					<div class="form-wrapper">
						<input class="form-control" type="text" name="username" placeholder="Username">
						<i class="zmdi zmdi-email"></i>
					</div>
					<div class="form-wrapper">
						<input class="form-control" type="password" name="password" placeholder="Password">
						<i class="zmdi zmdi-lock"></i>
					</div>
					<br><br>
					<?php echo display_error(); ?>
					<button type="submit" name="login_user">
						Login
						<i class="zmdi zmdi-arrow-right"></i>
					</button>

					<br>
					<div class="form-wrapper">
						Forgot
						<a href="#">
							Email / Password?
						</a>
					</div>

					<a href="register.php">
						Create your Account
						<i class="zmdi zmdi-arrow-right" aria-hidden="true"></i>
					</a>

				</form>
			</div>
		</div>
		<?php include('footer.php')
		?>
</body>

</html>