<?php


    $con = mysqli_connect("localhost", "root", "", "img_gal");

    if (!$con){
        die("Connection failed: ".mysqli_connect_error());
    }

?>