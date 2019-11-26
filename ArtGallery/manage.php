<?php
include('server.php');

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

// Include and initialize DB class
require_once 'DB.class.php';
$db = new DB();

// Fetch the users data
$images = $db->getRows('arts');

// Get session data
$sessData = !empty($_SESSION['sessData']) ? $_SESSION['sessData'] : '';

// Get status message from session
if (!empty($sessData['status']['msg'])) {
  $statusMsg = $sessData['status']['msg'];
  $statusMsgType = $sessData['status']['type'];
  unset($_SESSION['sessData']['status']);
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Manage Arts - Art Mobi</title>
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
    <div class="wrapper" style="background-image: url('images/bg-registration-form-1.jpg');">
      <div class="inner2">
        <!-- Display status message -->
        <?php if (!empty($statusMsg)) { ?>
          <div class="col-xs-12">
            <div class="alert alert-<?php echo $statusMsgType; ?>"><?php echo $statusMsg; ?></div>
          </div>
        <?php } ?>
        <?php if (!empty($_SESSION['success'])) { ?>
          <div class="col-xs-12">
            <div class="alert alert-success"><?php echo $_SESSION['success'];  ?></div>
          </div>
        <?php
          unset($_SESSION['success']);
        } ?>
        </h3>
        <div class="row">
          <div class="col-md-12 head">
            <h5>Edit Art Pieces</h5>
            <!-- Add link -->
            <div class="float-right">
              <a href="addEdit.php" class="btn btn-primary"><i class="plus"></i> New Art Piece</a>
              <a href="addArtists.php" class="btn btn-primary"><i class="plus"></i> New Artist</a>
              <a href="delArtists.php" class="btn btn-danger"><i class="plus"></i> Remove Artist</a>
            </div>
          </div>
          <!-- List the images -->
          <table class="table table-striped table-bordered">
            <thead class="thead-dark">
              <tr>
                <th width="5%"></th>
                <th width="12%">Image</th>
                <th width="29%">Title</th>
                <th width="14%">Artist</th>
                <th width="9%">Likes</th>
                <th width="10%">Type</th>
                <th width="8%">Status</th>
                <th width="13%">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (!empty($images)) {
                foreach ($images as $row) {
                  $statusLink = ($row['status'] == 1) ? 'postAction.php?action_type=block&artID=' . $row['artID'] : 'postAction.php?action_type=unblock&artID=' . $row['artID'];
                  $statusTooltip = ($row['status'] == 1) ? 'Click to Inactive' : 'Click to Active';
                  ?>
                  <tr>
                    <td><?php echo '#' . $row['artID']; ?></td>
                    <td><img src="<?php echo 'uploads/images/' . $row['file_name']; ?>" alt="" /></td>
                    <td><?php echo $row['title']; ?></td>
                    <?php $row1 = $row["artistID"];
                        $getartistname = mysqli_query($con, "SELECT name FROM artists INNER JOIN arts ON arts.artistID = artists.artistID WHERE arts.artistID = $row1 LIMIT 1");
                        $artistname = mysqli_fetch_assoc($getartistname); ?>
                    <td><?php echo is_array($artistname) ? implode(", ", $artistname) : $artistname; ?></td>
                    <?php
                    $resultlikes = mysqli_query($con, "SELECT COUNT(*) as 'likes' FROM likes WHERE artID=" . $row['artID'] . "");
												foreach ($resultlikes as $rows) {
													?>
                    <td><?php echo $rows['likes']; ?></td>
                        <?php } ?>
                    <td><?php echo $row['type']; ?></td>
                    <td><a href="<?php echo $statusLink; ?>" title="<?php echo $statusTooltip; ?>"><span class="badge <?php echo ($row['status'] == 1) ? 'badge-success' : 'badge-danger'; ?>"><?php echo ($row['status'] == 1) ? 'Active' : 'Inactive'; ?></span></a></td>
                    <td>
                      <a href="addEdit.php?artID=<?php echo $row['artID']; ?>" class="btn btn-warning">edit</a>
                      <a href="postAction.php?action_type=delete&artID=<?php echo $row['artID']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete data?')?true:false;">delete</a>
                    </td>
                  </tr>
                <?php }
                } else { ?>
                <tr>
                  <td colspan="6">No Art Piece(s) found...</td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
          <a href="gallery.php" class="btn btn-primary"><i class="plus"></i> Back</a>
        </div>
      </div>
    </div>
    <?php include('footer.php');
    ?>
</body>

</html>