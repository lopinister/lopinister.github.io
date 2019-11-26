<?php
include('server.php');

if (isset($_POST['del_art'])) {

	// receive all input values from the form
	$artistID =  e($_POST['artistID']);

	// Finally, register user if there are no errors in the form
  
	  if (count($errors) == 0)  {
		$query = "DELETE FROM artists WHERE artistID='$artistID'";
		mysqli_query($con, $query);
		$_SESSION['success']  = "Artist successfully deleted!!";
		header('location: manage.php');
	  }
}
?>