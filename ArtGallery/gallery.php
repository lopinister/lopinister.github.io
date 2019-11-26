<?php

include('server.php');

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
  header('location: index.php');
}

if (!isset($_SESSION['user'])) {
  $_SESSION['user'] = session_id();
}

foreach ($_SESSION['user'] as $userID) {
  $userID = $userID;
  break;
}

// Include and initialize DB class
require_once 'DB.class.php';
$db = new DB();

// Fetch the images data
$condition = array('where' => array('status' => 1));
$images = $db->getRows('arts', $condition);

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Gallery - Art Mobi</title>
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
          <a class="nav-link active" href="./gallery.php">Gallery</a>
          <a class="nav-link" href="./searchart.php">Search</a>
          <a class="nav-link" href="./editprofile.php">Edit Profile</a>
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
    <div class="form-group">
      <div class="col-sm-10 col-sm-offset-2">
        <p><?php if (isset($_SESSION['msg'])) : ?>
            <h3>
              <?php
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
                ?>
            </h3>
          <?php endif ?></p>
      </div>
    </div>
    <div class="wrapper" style="background-image: url('images/bg-registration-form-1.jpg');">
      <div class="inner2">
        <div id="gridview" class="container">
          <h1>Gallery</h1>
          <div class="head">
            <a href="manage.php" style="float:right" class="btn btn-secondary">Manage</a>
          </div>
          <hr>
          <div class="row">
            <?php
            if (!empty($images)) {
              foreach ($images as $row) {
                $uploadDir = 'uploads/images/';
                $imageURL = $uploadDir . $row["file_name"];
                ?>
                <div id="gallery" class="col-lg-3">
                  <a href="<?php echo $imageURL; ?>" data-fancybox="gallery" data-caption="<?php echo $row["title"]; ?> ">
                    <img src="<?php echo $imageURL; ?>" alt="" />
                    <p><strong>Title:</strong> <?php echo $row["title"]; ?></p>
                    <p><strong>Art Type:</strong> <?php echo $row["type"]; ?></p>
                    <?php
                        $getartistname = mysqli_query($con, "SELECT name FROM artists INNER JOIN arts ON arts.artistID = artists.artistID WHERE arts.artistID = " . $row['artistID'] . " LIMIT 1");
                        $artistname = mysqli_fetch_assoc($getartistname);
                        ?>
                    <p><strong>Artist:</strong> <?php echo is_array($artistname) ? implode(", ", $artistname) : $artistname; ?></p>
                  </a>
                  <?php
                      $results = mysqli_query($con, "SELECT * FROM likes WHERE userID='$userID' AND artID=" . $row['artID'] . "");

                      if (mysqli_num_rows($results) == 1) : ?>
                    <!-- user already likes post -->
                    <span class="unlike fa fa-thumbs-up" data-id="<?php echo $row['artID']; ?>"></span>
                    <span class="like hide fa fa-thumbs-o-up" data-id="<?php echo $row['artID']; ?>"></span>
                  <?php else : ?>
                    <!-- user has not yet liked post -->
                    <span class="like fa fa-thumbs-o-up" data-id="<?php echo $row['artID']; ?>"></span>
                    <span class="unlike hide fa fa-thumbs-up" data-id="<?php echo $row['artID']; ?>"></span>
                  <?php endif ?>
                  <?php
                      $resultlikes = mysqli_query($con, "SELECT COUNT(*) as 'likes' FROM likes WHERE artID=" . $row['artID'] . "");
                      foreach ($resultlikes as $row) {
                        ?>
                    <span class="likes_count"><?php echo $row['likes']; ?> likes</span>
                </div>
          <?php }
            }
          } ?>
          </div>
        </div>
      </div>
    </div>
    <?php include('footer.php');
    ?>
</body>

</html>