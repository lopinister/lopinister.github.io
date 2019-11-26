<?php session_start();

if (!isset($_SESSION['username'])) {
  $_SESSION['msg'] = "You must log in first";
  header('location: login.php');
}
if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['fname']);
  header("location: login.php");
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Gallery - Art Mobi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include('styles.php')
  ?>
  <!-- Fancybox CSS library -->
  <link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox.css">
  <!-- jQuery library -->
  <script src="js/jquery.min.js"></script>
  <!-- Fancybox JS library -->
  <script src="fancybox/jquery.fancybox.js"></script>
</head>

<body>
  <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <header class="masthead mb-auto">
      <div class="inner">
        <h3 class="masthead-brand">Art MOBI</h3>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <nav class="nav nav-masthead justify-content-center">
          <a class="nav-link" href="./index.php">Home</a>
          <a class="nav-link active" href="./gallery.php">Gallery</a>
          <a class="nav-link" href="./artists.php">Artists</a>
          <a class="nav-link" href="./editprofile.php">Edit Profile</a>
        </nav>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <div class="logged">
          <!-- logged in user information -->
          <?php if (isset($_SESSION['username'])) : ?>
            <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
            <p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
          <?php endif ?>
        </div>
      </div>
    </header>
    <div class="wrapper" style="background-image: url('images/bg-registration-form-1.jpg');">
      <div class="inner">
      <?php

$postData = $imgData = array();

// Get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

// Get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}

// Get posted data from session
if(!empty($sessData['postData'])){
    $postData = $sessData['postData'];
    unset($_SESSION['sessData']['postData']);
}

// Get image data
if(!empty($_GET['id'])){
    // Include and initialize DB class
    require_once 'DB.class.php';
    $db = new DB();
    
    $conditions['where'] = array(
        'id' => $_GET['id'],
    );
    $conditions['return_type'] = 'single';
    $imgData = $db->getRows('images', $conditions);
}

// Pre-filled data
$imgData = !empty($postData)?$postData:$imgData;

// Define action
$actionLabel = !empty($_GET['id'])?'Edit':'Add';
?>

<!-- Display status message -->
<?php if(!empty($statusMsg)){ ?>
<div class="col-xs-12">
    <div class="alert alert-<?php echo $statusMsgType; ?>"><?php echo $statusMsg; ?></div>
</div>
<?php } ?>
<div class="row">
    <div class="col-md-6">
        <form method="post" action="postAction.php" enctype="multipart/form-data">
            <div class="form-group">
                <label>Image</label>
                <?php if(!empty($imgData['file_name'])){ ?>
                    <img src="uploads/images/<?php echo $imgData['file_name']; ?>">
                <?php } ?>
                <input type="file" name="image" class="form-control" >
            </div>
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter title" value="<?php echo !empty($imgData['title'])?$imgData['title']:''; ?>" >
            </div>
            <a href="manage.php" class="btn btn-secondary">Back</a>
            <input type="hidden" name="id" value="<?php echo !empty($imgData['id'])?$imgData['id']:''; ?>">
            <input type="submit" name="imgSubmit" class="btn btn-success" value="SUBMIT">
        </form>
    </div>
</div>
</body>

</html>