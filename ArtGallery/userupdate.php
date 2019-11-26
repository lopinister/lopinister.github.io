<?php 
include('server.php');

// call the update() function if update_user is clicked
if (isset($_POST['update_user'])) {

	foreach($_SESSION['user'] as $userID) { 
		$userID = $userID; 
		break;  
	  } 
	
	  $email = e($_POST['email']);
	  $first_name = e($_POST['first_name']);
	  $last_name = e($_POST['last_name']);
	  $address = e($_POST['address']);
	  $oldpassword_1 = e($_POST['oldpassword']);
	  $newpassword = e($_POST['newpassword']);
	  $newpassword2 = e($_POST['newpassword2']);
	
	if (empty($oldpassword_1)) {
		array_push($errors, "Old Password is required");
	  }
	
	if ($newpassword != $newpassword2) {
	  array_push($errors, "The two passwords do not match");
	}
	
	  $oldpassword = md5($oldpassword_1);
	  $pass_check_query = "SELECT * FROM users WHERE userID='$userID' AND password='$oldpassword' LIMIT 1";
	  $result = mysqli_query($con, $pass_check_query);
	
	 
	  // Finally, update user if there are no errors in the form
	  if (count($errors) == 0) {
		$password = md5($newpassword); //encrypt the password before saving in the database
	
	if (mysqli_num_rows($result) == 1) {
	
	  $query = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', email = '$email', address = '$address', password = '$password' WHERE userID='$userID'";
	  mysqli_query($con, $query);
	
	  $_SESSION['success']  = "<script type='text/javascript'>

	  $(document).ready(function(){
	
		Swal.fire({
		  icon: 'success',
		  title: 'Yes!',
		  text: 'User updated'
		})
	
	  });
	
	  </script>";
		header("Location: index.php");
	  } else {
		array_push($errors, "Wrong password");
	  }
	}
}

?>