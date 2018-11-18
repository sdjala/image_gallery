<?php
include '../partials/adminHeader.php';
include '../utils/dbh.php';
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}


    $album_id=$_GET['id'];	
    echo '<script>console.log('.json_encode($album_id).')</script>';

    

$sessionID = $_SESSION['id'];
echo '<script>console.log('.json_encode($sessionID).')</script>';

// Initialize message variable
$msg = "";

// If upload button is clicked ...
if (isset($_POST['upload'])) {
    // Get image name
    $image = $_FILES['image']['name'];
    // Get text
    $image_text = mysqli_real_escape_string($con, $_POST['image_text']);
    $album_id = mysqli_real_escape_string($con, $_POST['album_id']);

    // image file directory
    $target = "../images/".basename($image);

    $sql = "INSERT INTO images (image, image_text, uid, album_id) VALUES ('$image', '$image_text', '$sessionID', '$album_id' )";
    // execute query
    mysqli_query($con, $sql);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $msg = "Image uploaded successfully";
    }else{
        $msg = "Failed to upload image";
    }
}



?>
 
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Welcome</title>
        <link rel="stylesheet" type="text/css" href="../assets/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="http://malsup.github.com/jquery.form.js"></script> 
        <style type="text/css">
            body{ font: 14px sans-serif; text-align: center; }
            * {box-sizing: border-box;}
        </style>
    </head>

    <body>
        <div class="page-header">
            <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
        </div>
        <div class ='page-content'>
        <h2>My Images</h2>
        </div>
        <div class="row" style="margin-top: 10px">
            <?php     
                $result = mysqli_query($con, "SELECT * FROM images WHERE uid = '".$_SESSION['id']."' AND album_id= '$album_id' ");
                while ($row = mysqli_fetch_array($result)) { ?>
                    <div class='col-xs-6 col-md-1'>
                        <div class='column'>
                            <div class="row" style="margin: 10px">
                                <img src="../images/<?php echo $row['image'] ?>" width="100px" height="100px" onclick="myFunction(this);"
                                <p ><?php echo $row['image_text'] ?></p>
                            </div>   
                            <div class='row' style="margin-top: 5px;">
                                <?php
                                    if ($row['status']==1){
                                        echo "<p id=sts".$row['id']." >Published</p>";
                                    }else {
                                        echo "<p sts".$row['id'].">Unpublished</p>";
                                    }
                                ?>
                            </div>
                            <div class='row' style="margin-top: 5px;">
                                <select onchange="publish_album(this.value, '<?php echo $row['id']; ?>')">
                                    <option value=''>Select</option>
                                    <option value='1'>Published</option>
                                    <option value='0'>Unpublished</option>
                                </select>
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
        <div  style="margin-top: 100px;">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-md-offset-3" align="center">
                    <?php if ($msg != "") echo $msg . "<br><br>" ?>
                        <form method="POST" action="images.php" class="form-horizontal" enctype="multipart/form-data">
                            <input class="form-control" type="hidden" name="size" value="1000000">
                            <input class="form-control" type="file" name="image">
                            <input class="form-control" type="hidden" name="album_id" value="<?php print $album_id;?>">
                            <textarea 
                                class="form-control"
                                id="text" 
                                cols="40" 
                                rows="4" 
                                name="image_text" 
                                placeholder="Say something about this image..."></textarea>
                            <br/>
                                <button class="btn btn-primary upload-image" type="submit" name="upload">POST</button>
                        </form>
                    </div>
                </div>
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

<script>

    function publish_album(val,image_id){
       $.ajax({
            type: 'post',
            url: 'changeImg.php',
            data: {val:val, image_id:image_id},
                success: function(result){
                    if(result==1){
                        $('#sts'+image_id).html('Published');
                    }else{
                        $('#sts'+image_id).html('Unpublished');
                    }
                }

        });
    }

</script>