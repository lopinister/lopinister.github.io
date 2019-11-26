<?php
include('userupdate.php');

if (!isLoggedIn()) {
    $_SESSION['msg'] = $_SESSION['msg'] = "<script type='text/javascript'>

    $(document).ready(function(){
  
      Swal.fire({
        icon: 'warning',
        title: 'Oops...',
        text: 'You must log in first'
      })
  
    });
  
    </script>";
    header('location: login.php');
}

foreach($_SESSION['user'] as $userID) { 
    $userID = $userID; 
    break;  
  } 

$sql = mysqli_query($con, "SELECT * FROM users WHERE userID='$userID' LIMIT 1");

while($row = mysqli_fetch_assoc($sql)){
    $email = $row['email'];
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $address = $row['address'];
    $oldpassword = $row['password'];

}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Edit Profile - Art Mobi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include ('styles.php');
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
                    <a class="nav-link active" href="./editprofile.php">Edit Profile</a>
                    <a class="nav-link" href="./adminpanel.php">Admin Panel</a>
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
        <div class="wrapper" style="background-image: url('images/bg-registration-form-1.jpg');">
            <div class="inner">
                <div class="image-holder">
                    <img src="images/registration-form-1.jpg" alt="">
                </div>
                <form method="POST">
                    <h3>Edit Profile</h3>
                    <div class="form-group">
                        <input type="text" name="first_name" placeholder="First Name" value="<?php echo $first_name; ?>" class="form-control">
                        <input type="text" name="last_name" placeholder="Last Name" value="<?php echo $last_name; ?>" class="form-control">
                    </div>
                    <div class="form-wrapper">
                        <input type="text" name="email" placeholder="Email" value="<?php echo $email; ?>" class="form-control">
                        <i class="zmdi zmdi-email"></i>
                    </div>
                    <div class="form-wrapper">
                        <input type="text" name="address" placeholder="Address" value="<?php echo $address; ?>" class="form-control">
                    </div>
                    <div class="form-wrapper">
                        <input type="password" name="oldpassword" placeholder="Old Password" class="form-control">
                        <i class="zmdi zmdi-lock"></i>
                    </div>
                    <div class="form-wrapper">
                        <input type="password" name="newpassword" placeholder="New Password" class="form-control">
                        <i class="zmdi zmdi-lock"></i>
                    </div>
                    <div class="form-wrapper">
                        <input type="password" name="newpassword2" placeholder="Confirm New Password" class="form-control">
                        <i class="zmdi zmdi-lock"></i>
                    </div>
                    <br><br>
                    <?php echo display_error(); ?>
                    <button type="submit" name="update_user">Update Profile
                        <i class="zmdi zmdi-arrow-right" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
        </div>
        <?php include('footer.php');
        ?>
</body>

</html>