<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
</head>
<?php 
session_start();
$errMsg = '';
include_once 'db.php';
if($user->is_loggedin() != ''){
	$user->redirect('index.php');
}
if(isset($_POST['submit-btn']))
{

	$imgFile = $_FILES['profile-image']['name'];
	$tmp_dir = $_FILES['profile-image']['tmp_name'];
	$imgSize = $_FILES['profile-image']['size'];
	$name = $_POST['name'];
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	if(empty($name)){

	}elseif(empty($username)){
		$errMsg = 'Please Enter Username';
	}elseif(empty($email)){
		$errMsg = 'Please Enter E-mail';
	}elseif(empty($password)){
		$errMsg = 'Please Enter Password';
	}
	elseif(strlen($password) < 6){
		$errMsg = 'Password must be Atleast 6 characters';
	}elseif($user->validate_email($username,$email)){

	}else{
		$upload_dir = 'uploads/';
		$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
		// valid extensions
		$valid_extensions = array('jpeg','png','gif','jpg');
		// name of file
		$userpic = rand(1000,1000000).'.'.$imgExt;
		//allow valid image file formats
		if(in_array($imgExt, $valid_extensions))//syntax(array,search,type)
		{
			//check file size '5mb'
			if($imgSize > 5000000){
				move_uploaded_file($imgFile, $tmp_dir,$userpic);
			}else{
				$errMsg = 'Sorry file is too large';
			}

		}else{
			$errMsg = 'Sorry Only JPG,JPEG,GIF and PNG files are allowed';
		}
		if(!isset($errMsg)){
			if($user->create($name,$username,$email,$password,$userpic)){
				$user->redirect('register.php?inserted');
			}
		}else{
			$errMsg = 'Error while inserting';
		}
	}
}
 ?>
<body>

<?php 
if(isset($_GET['inserted'])){
?>
	<div style="color:green">Successfully Inserted!</div>
<?php
}
elseif (isset($_GET['failed'])) {
?>
	<div style="color:red">Failed</div>
<?php
}
 ?>
<div style="color: red;font-weight:bold;"><?php echo $errMsg; ?></div>
<form method="POST" enctype="multipart/form-data">
	<input type="file" name="profile-image">
	<input type="text" name="name" placeholder="Name">
	<input type="text" name="username" placeholder="Username">
	<input type="email" name="email" placeholder="E-mail">
	<input type="password" name="password" placeholder="Password">
	<button type="submit" name="submit-btn">Register</button>
</form>
<a href="login.php">Go to login page</a>
</body>
</html>		
<!-- // $upload_dir = 'uploads/';
		// $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
		// // valid extensions
		// $valid_extensions = array('jpeg','png','gif','jpeg');
		// // name of file
		// $userpic = rand(1000,1000000).'.'.$imgExt;
		// //allow valid image file formats
		// if(in_array($imgExt, $valid_extensions))//syntax(array,search,type)
		// {
		// 	//check file size '5mb'
		// 	if($imageSize > 5000000){
		// 		move_uploaded_file($imgFile, $tmp_dir,$userpic);
		// 	}else{
		// 		$errMsg = 'Sorry file is too large';
		// 	}

		// }else{
		// 	$errMsg = 'Sorry Only JPG,JPEG,GIF and PNG files are allowed';
		// }
		// if(!isset($errMsg)){
		// 		//code here.
		// } -->