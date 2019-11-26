<?php include('userregister.php');

if (!isAdmin()) {
	$_SESSION['msg'] = "<script type='text/javascript'>

	$(document).ready(function(){
  
	  Swal.fire({
		icon: 'warning',
		title: 'Oops...',
		text: 'You have to be an administrator in order to enter this page'
	  })
  
	});
  
	</script>";
	header('location: gallery.php');
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Home - Art Mobi</title>
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
					<a class="nav-link" href="./gallery.php">Gallery</a>
					<a class="nav-link" href="./searchart.php">Search</a>
					<a class="nav-link" href="./editprofile.php">Edit Profile</a>
					<a class="nav-link active" href="./adminpanel.php">Admin Panel</a>
				</nav>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<div class="logged">
					<!-- logged in user information -->
					<?php if (isset($_SESSION['user'])) : ?>
						<strong><?php echo $_SESSION['user']['first_name']; ?></strong>
						<small>
							<i style="color: #888;">(<?php echo ucfirst($_SESSION['user']['usertype']); ?>)</i>
							<br>
							<a href="index.php?logout='1'" style="color: red;">logout</a>
						</small>
					<?php endif ?>
				</div>
			</div>
		</header>
		<div class="form-group">
			<div class="col-sm-10 col-sm-offset-2">
				<p><?php if (isset($_SESSION['success'])) : ?>
						<h3>
							<?php
								echo $_SESSION['success'];
								unset($_SESSION['success']);
								?>
						</h3>
					<?php endif ?></p>
			</div>
		</div>
	</div>
	<div class="wrapper" style="background-image: url('images/bg-registration-form-1.jpg');">
		<div class="inner">
			<div class="image-holder">
				<img src="images/registration-form-1.jpg" alt="">
			</div>
			<form method="POST">
				<h3>Admin Registration Form</h3>
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
					<select name="usertype" id="usertype" class="form-control">
						<option value="" disabled selected>User Type</option>
						<option value="admin">Admin</option>
						<option value="customer">Customer</option>
					</select>
					<i class="zmdi zmdi-caret-down" style="font-size: 17px"></i>
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
				<button type="submit" name="reg_user">Create User
					<i class="zmdi zmdi-arrow-right"></i>
				</button>
				</a>
			</form>
		</div>
	</div>
	<?php include('footer.php')
	?>
</body>

</html>