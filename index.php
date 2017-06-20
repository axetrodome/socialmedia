<!DOCTYPE html>
<html>
<?php 
session_start();
include_once 'db.php';
$errMsg = '';
$user_id = $_SESSION['user_id'];
if(!$user->is_loggedin()){
	$user->redirect('login.php');
}
$sql = $dbconn->prepare("SELECT * FROM users WHERE id = $user_id");
$sql->execute();
$row = $sql->fetch(PDO::FETCH_ASSOC);

 ?>
<head>
	<title>Welcome page</title>
</head>
<body>
<?php
if(isset($_GET['logged'])){
	?>
	<p style="color:green;font-weight:bold">You are logged in as user number <?php echo $user_id; ?>!</p>
	<?php
}
 ?>
 <img src="uploads/<?php echo $row['image']?>" style="width:70px;height:70px;border-radius:100%;">
 <form method="POST" enctype="multipart/form-data">
 	<input type="file" name="profile-image">
 	<button type="submit" name="upload-btn">Upload</button>
 </form>
 <form action="logout.php">
 	<button type="submit" name="logout-btn">Logout</button>
 </form>
</body>
</html>