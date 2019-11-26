<?php
include('server.php');

if (isset($_POST['reg_art'])) {
	
  // receive all input values from the form
  $name =  e($_POST['name']);
  $website = e($_POST['website']);
  $address = e($_POST['address']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($name)) {
    array_push($errors, "Name is required");
  }
  if (empty($website)) {
    array_push($errors, "Website is required");
  }
  if (empty($address)) {
    array_push($errors, "Address is required");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM artists WHERE name='$name'LIMIT 1";
  $result = mysqli_query($con, $user_check_query);
  $userc = mysqli_fetch_assoc($result);

  if ($userc) { // if user exists
    if ($userc['name'] === $name) {
      array_push($errors, "Artist already exists");
    }
  }

  // Finally, register user if there are no errors in the form

    if (count($errors) == 0)  {
      $query = "INSERT INTO artists (name, website, address) 
					  VALUES('$name', '$website', '$address')";
      mysqli_query($con, $query);
      $_SESSION['success']  = "New artist successfully created!!";
      header('location: manage.php');
    }
}
?>