<?php 
include('server.php');

if (isset($_POST['unliked'])) {
	foreach($_SESSION['user'] as $userID) { 
    $userID = $userID; 
    break;  
  }
    $artID = $_POST['artID'];
		$resultlikes = mysqli_query($con, "SELECT COUNT(*) as 'likes' FROM likes WHERE artID='$artID'");
		$row = mysqli_fetch_array($resultlikes);
		$n = $row['likes'];

		mysqli_query($con, "DELETE FROM likes WHERE artID='$artID' AND userID='$userID'");
		
		echo $n-1;
		exit();
}
  ?>

  