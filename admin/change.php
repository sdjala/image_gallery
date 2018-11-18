<?php
$con = new mysqli('localhost', 'root', '', 'img_gal');



    $query = mysqli_query($con, "UPDATE albums SET status = '".$_POST['val']."' WHERE id = '".$_POST['album_id']."'");

    if ($query){

        $q = mysqli_query($con, "SELECT * FROM albums WHERE id = '".$_POST['album_id']."'");

        $data = mysqli_fetch_assoc($q);
        echo $data['status'];
    
}else {echo "fail";}
?>
