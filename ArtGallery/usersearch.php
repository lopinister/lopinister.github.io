<?php 

include('server.php');

$resultart = "";
$resultartist = "";
$found = 0;

if (isset($_POST['search'])) {

    $filtervalue = e($_POST['filtervalue']);
    $value = e($_POST['valuetosearch']);

    if ($_POST['filtervalue'] === 'title') {
      $query = "SELECT * FROM arts WHERE title LIKE '%$value%'";
      $resultart = mysqli_query($con, $query);
      while(mysqli_fetch_array($resultart)){
        $found=1;
      }
      if ($found==0) {
        array_push($errors, "Art not found");
    }
    }
    else if ($_POST['filtervalue'] === 'artist') {
      $query = "SELECT * FROM arts INNER JOIN artists ON arts.artistID = artists.artistID WHERE artists.name LIKE '%$value%'";
      $resultartist = mysqli_query($con, $query);
      while(mysqli_fetch_array($resultartist)){
        $found=1;
      }
      if ($found==0) {
        array_push($errors, "Artist not found");
    }
    }
    else {
      array_push($errors, "Title/Artist not found");
    }
}

?>