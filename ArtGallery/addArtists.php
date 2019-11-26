<?php
include('artistregister.php');

if (!isAdmin()) {
    $_SESSION['msg'] = "<script type='text/javascript'>

    $(document).ready(function(){
  
      Swal.fire({
        icon: 'warning',
        title: 'Oops...',
        text: 'You have to be an administrator in order to enter this page'
      })
  
    });
  
    </script>";
    header('location: gallery.php');
}

// Get session data
$sessData = !empty($_SESSION['sessData']) ? $_SESSION['sessData'] : '';

// Get status message from session
if (!empty($sessData['status']['msg'])) {
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}

// Get posted data from session
if (!empty($sessData['postData'])) {
    $postData = $sessData['postData'];
    unset($_SESSION['sessData']['postData']);
}

// Define action
$actionLabel = !empty($_GET['artID']) ? 'Edit' : 'Add';
?>
<html>

<head>
    <meta charset="utf-8">
    <title>Admin Panel - Art Mobi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('styles.php');
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
                    <a class="nav-link" href="./editprofile.php">Edit Profile</a>
                    <a class="nav-link active" href="./adminpanel.php">Admin Panel</a>
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
					<h3><?php echo $actionLabel; ?> Artist</h3>
					<div class="form-group">
						<input type="text" name="name" placeholder="Name" class="form-control">
					</div>
					<div class="form-wrapper">
						<input type="text" name="address" placeholder="Address" class="form-control">
					</div>
					<div class="form-wrapper">
						<input type="text" name="website" placeholder="Website" class="form-control">
                    </div>
                    <br><br>
					<?php echo display_error(); ?>
          <a href="manage.php" class="btn btn-secondary">Back</a><br>
          <input type="submit" name="reg_art" class="btn btn-primary" value="SUBMIT">
				</form>
			</div>
		</div>
        <?php include ('footer.php');
        ?>
</body>

</html>