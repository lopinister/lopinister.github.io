<?php 
function getPhotos() {
    require 'server.php';
    $q = "SELECT id, tn_src FROM photo ORDER BY id desc";
     
    $result = $mysqli->query($q) or die($mysqli_error($mysqli));
     
    if($result) {
        while($row = $result->fetch_object()) {
            $tn_src = $row->tn_src;
            $src = $row->src;
            $id = $row->id;
         
            print '<li>
                     <a href="review_image.php?id=' . $id . '">
                      <img src="' . $tn_src . '" alt="images" id="' . $id . '" />
                    </a>
                   </li>';
                    
            print "\n";
        }
    }
}