<?php
$con = new mysqli('localhost', 'root', '', 'img_gal');



    $query = mysqli_query($con, "UPDATE images SET status = '".$_POST['val']."' WHERE id = '".$_POST['image_id']."'");

    if ($query){

        $q = mysqli_query($con, "SELECT * FROM images WHERE id = '".$_POST['image_id']."'");

        $data = mysqli_fetch_assoc($q);
        echo $data['status'];
    
}else {echo "fail";}
?>
