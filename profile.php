<?php 
require 'functions/functions.php';
require 'functions/logout.php';
session_start();
ob_start();
// Check whether user is logged on or not
if (!isset($_SESSION['user_id'])) {
    header("location:index.php");
}
// Establish Database Connection
$conn = connect();
?>

<?php
if(isset($_GET['id']) && $_GET['id'] != $_SESSION['user_id']) {
    $current_id = $_GET['id'];
    $flag = 1;
} else {
    $current_id = $_SESSION['user_id'];
    $flag = 0;
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>My Profile</title>
  <link rel="stylesheet" href="public/stylesheets/style.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
  <style>
  #footer{
            left: 0;
            bottom: 0;
            z-index: 1;
            height: 30px;
            width: 100%;
            background-color: #FAFAFA;  
            position: fixed;
            text-align: right;
            padding-top: 10px;
        }
        #footer input{
            background-color: #faaaaa;
            border: none;
            border-radius: 10px 10px 10px 10px;
            margin-right: 10px;
            width: 100px;
        }
</style>
</head>

<body>
  <div id="topbar">
    <a href="home.php" id="homebut"><img class ="icon" src="public\images\home.png"></a>
    <a href="search.php" id="searchbut"><img class ="icon" src="public\images\search.png"></a>
    <a href="upload.php" id="uploadbut"><img class ="icon" src="public\images\plus.png"></a>
    <a href="recents.php" id="recentbut"><img class ="icon" src="public\images\heart.png"></a>
    <a href="profile.php" id="profbut"><img class ="icon" src="public\images\user.png"></a>
  </div>

        <?php
         if($flag==0){
          $sql2 = "SELECT * from users where user_id=\"".$_SESSION['user_id']."\";";
          $conn = connect();
          $query2 = mysqli_query($conn, $sql2);
          
          $row2 = mysqli_fetch_assoc($query2);
          
          echo "<div id=\"header\"><br><br>";
          echo "<div id=\"dpdiv\">";
            echo "<img id=\"dp\" src=\"".$row2['user_dp']."\" alt=\'Profile Picture\'>";
            echo '</div>';
            echo '<div id=\"desc\">';
              echo "<p>".$row2['user_username']."</p>";
              echo "<h3>".$row2['user_firstname']." ".$row2['user_lastname']."</h3>";
            echo '</div>';
          echo '</div>';
          echo '<br>';
          echo '<hr style=\'color: #cccccc;\'>';
          echo '<div id=\'timeline\'>';
          echo '<p id=\'notfound\' style=\"text-align:center;\"></p>';
          $sql = "SELECT * from posts where post_by=\"".$_SESSION['user_id']."\";";
          $query = mysqli_query($conn, $sql);
          if(mysqli_num_rows($query) == 0){
            ?> <script>
            document.getElementById("notfound").innerHTML="No posts.";
            </script> <?php
          } 
          else{
            while($row = mysqli_fetch_assoc($query)){
              echo '<div class=\'post\'>';
                echo "<img src=\"".$row['post']."\">";
              echo '</div>';
            }
          }
          echo '</div>';
        }
        else if($flag==1){
          $sql2 = "SELECT * from users where user_id=\"".$current_id."\";";
          $conn = connect();
          $query2 = mysqli_query($conn, $sql2);
          
          $row2 = mysqli_fetch_assoc($query2);
          
          echo "<div id=\"header\"><br><br>";
          echo "<div id=\"dpdiv\">";
            echo "<img id=\"dp\" src=\"".$row2['user_dp']."\" alt=\'Profile Picture\'>";
            echo '</div>';
            echo '<div id=\"desc\">';
              echo "<p>".$row2['user_username']."</p>";
              echo "<h3>".$row2['user_firstname']." ".$row2['user_lastname']."</h3>";
            echo '</div>';
          echo '</div>';
          echo '<br>';
          echo '<hr style=\'color: #cccccc;\'>';
          echo '<div id=\'timeline\'>';
          echo '<p id=\'notfound\' style=\"text-align:center;\"></p>';
          $sql = "SELECT * from posts where post_by=\"".$current_id."\";";
          $query = mysqli_query($conn, $sql);
          if(mysqli_num_rows($query) == 0){
            ?> <script>
            document.getElementById("notfound").innerHTML="No posts.";
            </script> <?php
          } 
          else{
            while($row = mysqli_fetch_assoc($query)){
              echo '<div class=\'post\'>';
                echo "<img src=\"".$row['post']."\">";
              echo '</div>';
            }
          }
          echo '</div>';
        }
        ?>

 
  <div id="footer">
  <form method=post>
        <input type="submit" name="Logout" value="Logout"></input>
	</form>
    </div>
</body>

</html>

<?php
	$conn = connect();
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		logout();
	}
?>