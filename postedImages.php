<?php

include 'utils/dbh.php';
include 'partials/header.php';


	

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Img Gallery</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="assets/style.css"
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
<div class ='page-header'>
        <h2>Images</h2>
        </div>
        <div class="row" style="margin-top: 10px">
            <?php
            if (isset($_GET['id'])){   
            $album_id=$_GET['id'];  
                $result = mysqli_query($con, "SELECT * FROM images WHERE status = '1' AND album_id= '$album_id' ");
            }else{
                $result = mysqli_query($con, "SELECT * FROM images WHERE status = '1' ");
            }
                while ($row = mysqli_fetch_array($result)) { ?>
                    <div class='col-xs-6 col-md-1'>
                        <div class='column'>
                            <div class="row" style="margin: 10px">
                                <img src="images/<?php echo $row['image'] ?>" width="100px" height="100px" onclick="myFunction(this);"
                                <p ><?php echo $row['image_text'] ?></p>
                            </div> 
                            </div>
                    </div>
             <?php  }?>
        </div>
        <!-- The expanding image container -->
        <div class="container">
        <!-- Close the image -->
        <span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>

        <!-- Expanded image -->
        <img id="expandedImg" style="width:100%">

        <!-- Image text -->
        <div id="imgtext"></div>
        </div>


</body>
</html>

<script>
function myFunction(imgs) {
  // Get the expanded image
  var expandImg = document.getElementById("expandedImg");
  // Get the image text
  var imgText = document.getElementById("imgtext");
  // Use the same src in the expanded image as the image being clicked on from the grid
  expandImg.src = imgs.src;
  // Use the value of the alt attribute of the clickable image as text inside the expanded image
  imgText.innerHTML = imgs.alt;
  // Show the container element (hidden with CSS)
  expandImg.parentElement.style.display = "block";
}

</script>