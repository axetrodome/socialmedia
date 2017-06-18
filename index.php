<!DOCTYPE html>
<html>
<?php 
session_start();
include_once 'db.php';
if(!$user->is_loggedin()){
	?><script type="text/javascript">
		alert('not working');
	</script><?php
}
$user_id = $_SESSION['user_id'];
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
 <form method="POST" enctype="multipart/form-data">
 	<input type="file" name="profile-image">
 	<button type="submit" name="upload">Upload</button>
 </form>
 <form action="logout.php">
 	<button type="submit" name="logout-btn">Logout</button>
 </form>
</body>
</html>