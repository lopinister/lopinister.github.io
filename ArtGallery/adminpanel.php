<?php include('server.php');

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
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Admin Panel - Art Mobi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('styles.php')
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
        <div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
				<p><?php if (isset($_SESSION['success'])) : ?>
				<h3>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
				</h3>
    <?php endif ?></p>
    </div>
    </div>
        <div class="wrapper" style="background-image: url('images/bg-registration-form-1.jpg');">
            <div class="inner">
                <div class="image-holder">
                    <img src="images/registration-form-1.jpg" alt="">
                </div>
                <form>
                    <h3>Admin Panel</h3>
                    <p><a href="registeruser.php" class="btn btn-primary"><i class="plus"></i>Register user or admin</a></p>
                    <br>
                    <p><a href="manage.php" class="btn btn-primary"><i class="plus"></i>Manage Arts</a></p>
                    <br>
                    <p><a href="addEdit.php" class="btn btn-primary"><i class="plus"></i>Add Art</a></p>
                    <br>
                    <p><a href="addArtists.php" class="btn btn-primary"><i class="plus"></i>Register Artist</a></p>
                    <br>
                    <p><a href="delArtists.php" class="btn btn-danger"><i class="plus"></i>Remove Artist</a></p>
                </form>
            </div>

        </div>
        <?php include('footer.php')
        ?>
</body>

</html>