<?php
 
require 'server.php';
 
$query = "SELECT id, title, src FROM photos";
 
$result = $mysqli->query($query) or die(mysqli_error($mysqli));
 
if ($result) {
  echo "<ul id='photos'> \n";
     
  while ($row = $result->fetch_object()) {
     
    $title = $row->title;
    $src = $row->src;
    $id = $row->id;
         
    echo "<li><a title='$title' href='images/$src'><img src='images/$src' id='$id' alt='$title' /> </a>\n";
    echo "<h4>$title</h4> \n";
    echo "<input type='text' name='title' value='$title' /></li> \n \n";    
 
    }
  echo "\n</ul>";
}
?>