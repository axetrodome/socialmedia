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
// if(isset($_POST['upload-btn'])){
// 	$imgFile = $_POST['profile-image']['name'];
// 	$tmp_dir = $_POST['profile-image']['tmp_name'];
// 	$imgSize = $_POST['profile-image']['size'];

// 	$upload_dir = 'uploads/';
// 	$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
// 	// valid extensions
// 	$valid_extensions = array('jpeg','png','gif','jpeg');
// 	// name of file
// 	$userpic = rand(1000,1000000).'.'.$imgExt;
// 	//allow valid image file formats
// 	if(in_array($imgExt, $valid_extensions))//syntax(array,search,type)
// 	{
// 		//check file size '5mb'
// 		if($imageSize > 5000000){
// 			move_uploaded_file($imgFile, $tmp_dir,$userpic);
// 		}else{
// 			$errMsg = 'Sorry file is too large';
// 		}

// 	}else{
// 		$errMsg = 'Sorry Only JPG,JPEG,GIF and PNG files are allowed';
// 	}
// 	if(!isset($errMsg)){
// 		if($user->Upload_image())

// 	}
// }

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
 	<button type="submit" name="upload-btn">Upload</button>
 </form>
 <form action="logout.php">
 	<button type="submit" name="logout-btn">Logout</button>
 </form>
</body>
</html>