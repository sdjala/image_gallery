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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
<div class="page-header" >
        <h2>Albums</h2>
    </div>
    <div class='row' style="margin: 10px;">

        <?php
            $result = mysqli_query($con, "SELECT * FROM albums WHERE status = '1' ");

            while ($row = mysqli_fetch_array($result)) {?>

            <div class='col-xs-6 col-md-2'>
                <a name="album" href="postedImages.php?id=<?php echo $row['id'] ?>" class="thumbnail">
                    <img src="images/download.jpg" alt="...">
                </a>
                    <a href='images.php'><?php echo $row['name'] ?></a>
                    
            </div>

       <?php } ?>
    </div>


</body>
</html>
