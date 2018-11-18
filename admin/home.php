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

$msg = "";
if (isset($_POST['submit'])) {
    // Get text
    $name = $con->real_escape_string($_POST['name']);

    if ($name == "")
			$msg = "Please check your inputs!";
		else {
    $sql = "INSERT INTO albums (name, uid) VALUES ('$name', '".$_SESSION['id']."')";
    // execute query
    mysqli_query($con, $sql);
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    </div>
    <div class="content" >
        <h2>My Albums</h2>
    </div>
    <div class='row' style="margin: 10px;">

        <?php
            $result = mysqli_query($con, "SELECT * FROM albums WHERE uid = '".$_SESSION['id']."' ");

            while ($row = mysqli_fetch_array($result)) {?>

            <div class='col-xs-6 col-md-2'>
                <a name="album" href="images.php?id=<?php echo $row['id'] ?>" class="thumbnail">
                    <img src="../images/download.jpg" alt="...">
                </a>
                    <a href='images.php'><?php echo $row['name'] ?></a>
                    
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

       <?php } ?>
    </div>
    <div class="row" style="margin-top: 100px;">
		<div class="row justify-content-center">
			<div class="col-md-6 col-md-offset-3" align="center">
            <?php if ($msg != "") echo $msg . "<br><br>" ?>

				<form method="post" action="home.php">
					<input class="form-control" name="name" placeholder="Name..."><br>
					<input class="btn btn-primary" type="submit" name="submit" value="Add">
				</form>

			</div>
		</div>
	</div>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>

    function publish_album(val,album_id){
       $.ajax({
            type: 'post',
            url: 'change.php',
            data: {val:val, album_id:album_id},
                success: function(result){
                    if(result==1){
                        $('#sts'+album_id).html('Published');
                    }else{
                        $('#sts'+album_id).html('Unpublished');
                    }
                }

        });
    }

</script>
</html>

