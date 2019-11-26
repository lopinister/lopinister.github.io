<?php 
require_once 'server.php';

// UPDATE USER
if (isset($_POST['update_profile'])) {
    $username = $_GET['username'];
    $email = $_GET['email'];
    $fname = $_POST['fname'];
    $sname = $_POST['sname'];
    $address = $_POST['address'];
    $password = $_POST['password'];
      $update_profile = $mysqli->query("UPDATE users SET fname = '$fname',
                        sname = '$sname', address = '$address', password = '$password'
                        WHERE username = '$username'");
          if ($update_profile) {
             header("Location: index.php?user=$username");
          } else {
            echo $mysqli->error;
          }
      }

?>