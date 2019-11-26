<?php 
session_start();

// connect to the database
$con = mysqli_connect('database-1.cptrcvahtkfl.eu-west-1.rds.amazonaws.com', 'Murilo_2018362', 'Jushubas186!', 'murilo_2018362');
//$con = mysqli_connect('localhost', 'root', 'password', 'artgallery');
// initializing variables
$username = "";
$email    = "";
$errors = array();

function getUserById($id)
{
  global $con;
  $query = "SELECT * FROM users WHERE userID=" . $id;
  $result = mysqli_query($con, $query);

  $user = mysqli_fetch_assoc($result);
  return $user;
}

// escape string
function e($val)
{
  global $con;
  return mysqli_real_escape_string($con, trim($val));
}

function display_error()
{
  global $errors;

  if (count($errors) > 0) {
    echo '<div class="error">';
    foreach ($errors as $error) {
      echo $error . '<br>';
    }
    echo '</div>';
  }
}

function isLoggedIn()
{
  if (isset($_SESSION['user'])) {
    return true;
  } else {
    return false;
  }
}

// log user out if logout button clicked
if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['user']);
  header("location: login.php");
}

function isAdmin()
{
  if (isset($_SESSION['user']) && $_SESSION['user']['usertype'] == 'admin') {
    return true;
  } else {
    return false;
  }
}



