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

$postData = $imgData = array();

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

// Get image data
if (!empty($_GET['artID'])) {
    // Include and initialize DB class
    require_once 'DB.class.php';
    $db = new DB();

    $conditions['where'] = array(
        'artID' => $_GET['artID'],
    );
    $conditions['return_type'] = 'single';
    $imgData = $db->getRows('arts', $conditions);
}

// Pre-filled data
$imgData = !empty($postData) ? $postData : $imgData;

// Define action
$actionLabel = !empty($_GET['artID']) ? 'Edit' : 'Add';

// Populate drop down list
$res = mysqli_query($con, "SELECT artistID, name FROM artists order by name")
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
            <div class="inner2">
                <div class="container">
                    <h1><?php echo $actionLabel; ?> Art </h1>
                    <hr>
                    <!-- Display status message -->
                    <?php if (!empty($statusMsg)) { ?>
                        <div class="col-xs-12">
                            <div class="alert alert-<?php echo $statusMsgType; ?>"><?php echo $statusMsg; ?></div>
                        </div>
                    <?php } ?>

                    <div class="row">
                        <div class="col-md-3 col-ld-6 col-xl-12">
                            <form method="post" action="postAction.php" enctype="multipart/form-data">
                                <div class="form-group2">

                                    <?php if (!empty($imgData['file_name'])) { ?>
                                        <img src="uploads/images/<?php echo $imgData['file_name']; ?>">
                                    <?php } ?>
                                    <input type="file" name="image" class="form-control">
                                </div>
                                <div class="form-group2">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Enter title" value="<?php echo !empty($imgData['title']) ? $imgData['title'] : ''; ?>">
                                </div>
                                <div class="form-group2">
                                    <label>Artist</label>
                                    <select name="artistID">
                                    <option selected="selected">--Select Artist--</option>
                                        <?php
                                        while ($row = mysqli_fetch_array($res)) {
                                            ?>
                                            <option value="<?php echo $row['artistID'] ?>"><?php echo $row['name'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group2">
                                    <label>Type</label>
                                    <input type="text" name="type" class="form-control" placeholder="Enter type" value="<?php echo !empty($imgData['type']) ? $imgData['type'] : ''; ?>">
                                </div>
                                <a href="manage.php" class="btn btn-secondary">Back</a>
                                <input type="hidden" name="artID" value="<?php echo !empty($imgData['artID']) ? $imgData['artID'] : ''; ?>">
                                <input type="submit" name="imgSubmit" class="btn btn-success" value="SUBMIT">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include ('footer.php');
        ?>
</body>

</html>