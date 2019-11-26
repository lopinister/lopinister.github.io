<?php
 
require_once 'server.php';
 
$title = mysql_real_escape_string($_POST['title']);
$id = mysql_real_escape_string($_POST['id']);
 
$update_query = "UPDATE photos SET title = '$title' WHERE id='$id'";
$result = $mysqli->query($update_query) or die(mysqli_error($mysqli));
 
if ($result) {
    echo "Success! <br />";
    echo "The title of this photo has been changed to: <strong>$title</strong>";    
} 
?>