<?php
include('server.php');

if (isset($_POST['reg_user'])) {

	// receive all input values from the form
	$username =  e($_POST['username']);
	$email = e($_POST['email']);
	//$usertype = e($_POST['usertype']);
	$first_name = e($_POST['first_name']);
	$last_name = e($_POST['last_name']);
	$address = e($_POST['address']);
	$password_1 = e($_POST['password_1']);
	$password_2 = e($_POST['password_2']);
  
	// form validation: ensure that the form is correctly filled ...
	// by adding (array_push()) corresponding error unto $errors array
	if (empty($username)) {
	  array_push($errors, "Username is required");
	}
	if (empty($first_name)) {
	  array_push($errors, "First name is required");
	}
	if (empty($last_name)) {
	  array_push($errors, "Surname is required");
	}
	if (empty($address)) {
	  array_push($errors, "Address is required");
	}
	if (empty($email)) {
	  array_push($errors, "Email is required");
	}
	if (empty($password_1)) {
	  array_push($errors, "Password is required");
	}
	if ($password_1 != $password_2) {
	  array_push($errors, "The two passwords do not match");
	}
  
	// first check the database to make sure 
	// a user does not already exist with the same username and/or email
	$user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
	$result = mysqli_query($con, $user_check_query);
	$userc = mysqli_fetch_assoc($result);
  
	if ($userc) { // if user exists
	  if ($userc['username'] === $username) {
		array_push($errors, "Username already exists");
	  }
  
	  if ($userc['email'] === $email) {
		array_push($errors, "Email already exists");
	  }
	}
  
	// Finally, register user if there are no errors in the form
	if (count($errors) == 0) {
	  $password = md5($password_1); //encrypt the password before saving in the database
  
	  if (isset($_POST['usertype'])) {
		$usertype = e($_POST['usertype']);
		$query = "INSERT INTO users (username, email, usertype, password, first_name, last_name, address) 
						VALUES('$username', '$email', '$usertype', '$password', '$first_name', '$last_name', '$address')";
		mysqli_query($con, $query);
		//$_SESSION['success']  = '<div class="alert alert-success">New user successfully created!!</div>';
		$_SESSION['success'] = "<script type='text/javascript'>
								$(document).ready(function(){
								Swal.fire({
									title: 'Great!',
									text: 'Your account has been created successfully.',
									imageUrl: 'images/bgirl.jpg',
									imageWidth: 400,
									imageHeight: 200,
							imageAlt: 'Art Mobi',
							footer: 'Please visit our gallery',
							confirmButtonText: 'See Gallery',
								}).then(function() {
							// Redirect the user
							window.location.href = 'gallery.php';
							})
								});

							</script>"; 
		header('location: adminpanel.php');
	  } else {
		$query = "INSERT INTO users (username, email, password, first_name, last_name, address) 
						VALUES('$username', '$email', '$password', '$first_name', '$last_name', '$address')";
		mysqli_query($con, $query);
  
	  // get id of the created user
	  $logged_in_user_id = mysqli_insert_id($con);
  
	  $_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
	  $_SESSION['username'] = $username;
	  $_SESSION['first_name'] = $first_name;
 	  $_SESSION['success'] = "<script type='text/javascript'>
								$(document).ready(function(){
								Swal.fire({
									title: 'Great!',
									text: 'Your account has been created successfully.',
									imageUrl: 'images/bgirl.jpg',
									imageWidth: 400,
									imageHeight: 200,
							imageAlt: 'Art Mobi',
							footer: 'Please visit our gallery',
							confirmButtonText: 'See Gallery',
								}).then(function() {
							// Redirect the user
							window.location.href = 'gallery.php';
							})
								});

							</script>"; 
	  header('location: index.php');
	}
  }
}
?>