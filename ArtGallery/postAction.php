<?php
// Start session
session_start();

// Include and initialize DB class
require_once 'DB.class.php';
$db = new DB();

$tblName = 'arts';

// File upload path
$uploadDir = "uploads/images/";

// Allow file formats
$allowTypes = array('jpg','png','jpeg','gif');

// Set default redirect url
$redirectURL = 'manage.php';

$statusMsg = '';
$sessData = array();
$statusType = 'danger';
if(isset($_POST['imgSubmit'])){
    
     // Set redirect url
    $redirectURL = 'addEdit.php';

    // Get submitted data
    $image    = $_FILES['image'];
    $title    = $_POST['title'];
    $type     = $_POST['type'];
    $artistID = $_POST['artistID'];
    $artID    = $_POST['artID'];
    
    // Submitted user data
    $imgData = array(
        'title'  => $title,
        'type'   => $type,
        'artistID' => $artistID
    );
    
    // Store submitted data into session
    $sessData['postData'] = $imgData;
    $sessData['postData']['artID'] = $artID;
    
    // ID query string
    $idStr = !empty($artID)?'?artID='.$artID:'';
    
    // If the data is not empty
    if((!empty($image['name']) && !empty($title)) || (!empty($artID) && !empty($title))){
        
        if(!empty($image)){
            $fileName = basename($image["name"]);
            $targetFilePath = $uploadDir . $fileName;
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
            
            if(in_array($fileType, $allowTypes)){
                // Upload file to server
                if(move_uploaded_file($image["tmp_name"], $targetFilePath)){
                    $imgData['file_name'] = $fileName;
                }else{
                    $statusMsg = "Sorry, there was an error uploading your file.";
                }
            }else{
                $statusMsg = "Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.";
            }
        }

        if(!empty($artID)){
            // Previous file name
            $conditions['where'] = array(
                'artID' => $_GET['artID'],
            );
            $conditions['return_type'] = 'single';
            $prevData = $db->getRows('arts', $conditions);
            
            // Update data
            $condition = array('artID' => $artID);
            $update = $db->update($tblName, $imgData, $condition);
            
            if($update){
                // Remove old file from server
                if(!empty($imgData['file_name'])){
                    @unlink($uploadDir.$prevData['file_name']);
                }
                
                $statusType = 'success';
                $statusMsg = 'Image data has been updated successfully.';
                $sessData['postData'] = '';
                
                $redirectURL = 'manage.php';
            }else{
                $statusMsg = 'Some problem occurred, please try again.';
                // Set redirect url
                $redirectURL .= $idStr;
            }
        }elseif(!empty($imgData['file_name'])){
            // Insert data
            $insert = $db->insert($tblName, $imgData);
            
            if($insert){
                $statusType = 'success';
                $statusMsg = 'Image has been uploaded successfully.';
                $sessData['postData'] = '';
                
                $redirectURL = 'manage.php';
            }else{
                $statusMsg = 'Some problem occurred, please try again.';
            }
        }
    }else{
        $statusMsg = 'All fields are mandatory, please fill all the fields.';
    }
    
    // Status message
    $sessData['status']['type'] = $statusType;
    $sessData['status']['msg']  = $statusMsg;
}elseif(($_REQUEST['action_type'] == 'block') && !empty($_GET['artID'])){
    // Update data
    $imgData = array('status' => 0);
    $condition = array('artID' => $_GET['artID']);
    $update = $db->update($tblName, $imgData, $condition);
    if($update){
        $statusType = 'success';
        $statusMsg  = 'Image data has been blocked successfully.';
    }else{
        $statusMsg  = 'Some problem occurred, please try again.';
    }
    
    // Status message
    $sessData['status']['type'] = $statusType;
    $sessData['status']['msg']  = $statusMsg;
}elseif(($_REQUEST['action_type'] == 'unblock') && !empty($_GET['artID'])){
    // Update data
    $imgData = array('status' => 1);
    $condition = array('artID' => $_GET['artID']);
    $update = $db->update($tblName, $imgData, $condition);
    if($update){
        $statusType = 'success';
        $statusMsg  = 'Image data has been activated successfully.';
    }else{
        $statusMsg  = 'Some problem occurred, please try again.';
    }
    
    // Status message
    $sessData['status']['type'] = $statusType;
    $sessData['status']['msg']  = $statusMsg;
}elseif(($_REQUEST['action_type'] == 'delete') && !empty($_GET['artID'])){
    // Previous file name
    $conditions['where'] = array(
        'artID' => $_GET['artID'],
    );
    $conditions['return_type'] = 'single';
    $prevData = $db->getRows('arts', $conditions);
                
    // Delete data
    $condition = array('artID' => $_GET['artID']);
    $delete = $db->delete($tblName, $condition);
    if($delete){
        // Remove old file from server
        @unlink($uploadDir.$prevData['file_name']);
        
        $statusType = 'success';
        $statusMsg  = 'Image data has been deleted successfully.';
    }else{
        $statusMsg  = 'Some problem occurred, please try again.';
    }
    
    // Status message
    $sessData['status']['type'] = $statusType;
    $sessData['status']['msg']  = $statusMsg;
}

// Store status into the session
$_SESSION['sessData'] = $sessData;
    
// Redirect the user
header("Location: ".$redirectURL);
exit();
?>