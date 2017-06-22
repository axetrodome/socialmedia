<!DOCTYPE html>
<html>
<?php 
session_start();
include_once 'db.php';
$errphp = false;
$success = '';
$id = $_SESSION['user_id'];
if(!$user->is_loggedin()){
	$user->redirect('login.php');
}
$sql = $dbconn->prepare("SELECT * FROM users WHERE id = $id");
$sql->execute();
$row = $sql->fetch(PDO::FETCH_ASSOC);
if(isset($_POST['upload-btn']))
{
	$imgFile = $_FILES['profile-image']['name'];
	$tmp_dir = $_FILES['profile-image']['tmp_name'];
	$imgSize = $_FILES['profile-image']['size'];


	$upload_dir = "uploads/";
	$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
	$valid_extension = array('jpg','jpeg','gif','png');
	$user_pic = rand(10000,1000000).'.'.$imgExt;

	if(in_array($imgExt, $valid_extension)){
		if($imgSize < 5000000){
			unlink($upload_dir.$row['image']);
			move_uploaded_file($tmp_dir, $upload_dir.$user_pic);
		}else{
			$errImg = "Image is too large";
			$errphp = true;
		}
	}else{
		$errImg = "Only JPG, JPEG,GIF,PNG are allowed";
		$errphp = true;
	}

	if($errphp == false){
		if($user->edit_profile($id,$user_pic)){
			$success = "Profile updated Successfuly";			
		}else{
			$error[] = "Error while Updating";
			$errphp = true;
		}
	}
}
 ?>
<head>
	<title>Welcome page</title>
</head>
<body>
<?php
if(isset($_GET['logged'])){
	?>
	<p style="color:green;font-weight:bold">Welcome user number <?php echo $id; ?>!</p>
	<?php
}
 ?>
 <p style="color:green;font-weight:bold"><?php echo $success; ?></p>
 <form method="POST" enctype="multipart/form-data">
 	<img src="uploads/<?php echo $row['image']?>" style="width:70px;height:70px;border-radius:100%;"><br>
	<input type="file" name="profile-image"><br>
	<button type="submit" name="upload-btn">Upload</button>
 </form>
 <form action="logout.php">
 	<button type="submit" name="logout-btn">Logout</button>
 </form>
</body>
</html>