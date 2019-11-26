<?php 
include('server.php');

// call the login() function if login_user is clicked
if (isset($_POST['login_user'])) {
	  // grap form values
    $username = $_POST['username'];
    $password = $_POST['password'];
  
    // make sure form is filled properly
    if (empty($username)) {
      array_push($errors, "Username is required");
    }
    if (empty($password)) {
      array_push($errors, "Password is required");
    }
  
    // attempt login if no errors on form
    if (count($errors) == 0) {
      $password = md5($password);
  
      $query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
      $results = mysqli_query($con, $query);
  
      if (mysqli_num_rows($results) == 1) { // user found
        // check if user is admin or user
        $logged_in_user = mysqli_fetch_assoc($results);
        if ($logged_in_user['usertype'] == 'admin') {
    
          $_SESSION['user'] = $logged_in_user;
          $_SESSION['username'] = $username;
          $_SESSION['first_name'] = $first_name;
          //$_SESSION['success']  = '<div class="alert alert-success">You are now logged in</div>';
          $_SESSION['success'] = "<script type='text/javascript'>

          $(document).ready(function(){

            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'You are now logged in',
              showConfirmButton: false,
              timer: 2000
            })

          });
  
          </script>";   
          header('location: adminpanel.php');
        } else {
          $_SESSION['user'] = $logged_in_user;
          $_SESSION['username'] = $username;
          $_SESSION['first_name'] = $first_name;
          //$_SESSION['success']  = '<div class="alert alert-success">You are now logged in</div>';
          $_SESSION['success'] = "<script type='text/javascript'>

          $(document).ready(function(){

            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'You are now logged in',
              showConfirmButton: false,
              timer: 1500
            })

          });
  
          </script>";
          header('location: index.php');
        }
      } else {
        array_push($errors, "Wrong username/password combination");
      }
    }
}
  ?>