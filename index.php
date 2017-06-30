<!DOCTYPE html>
<html>
<?php 
session_start();
include_once 'db.php';
$success = '';
$id = $_SESSION['user_id'];
if(!$user->is_loggedin()){
	$user->redirect('login.php');
}
extract($user->getID($id));
if(isset($_POST['upload-btn']))
{
	$imgFile = $_FILES['profile-image']['name'];
	$tmp_dir = $_FILES['profile-image']['tmp_name'];
	$imgSize = $_FILES['profile-image']['size'];
	$name = $_POST['name'];
	$username = $_POST['username'];
	$password = $_POST['password'];

	$upload_dir = "uploads/";
	$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
	$valid_extension = array('jpg','jpeg','gif','png');
	$user_pic = rand(10000,1000000).'.'.$imgExt;
	if(empty($name)){
		$error[] = 'Please Enter Name';
	}elseif($user->Name_validation($name)){
			$error[] = "Letters and White space Only";
	}elseif(empty($username)){
		$error[] = 'Please Enter Username';
	}
	elseif(empty($password)){
		$error[] = 'Please Enter Password';
	}
	elseif($user->PasswordLength($password)){
			$error[] = "Password must contain atleast 6 Characters";
	}
	if($imgFile){
		if(in_array($imgExt, $valid_extension)){
			if($imgSize < 5000000){
				unlink($upload_dir.$image);
				move_uploaded_file($tmp_dir, $upload_dir.$user_pic);
			}else{
				$error[] = "Image is too large";
			}
		}else{
			$error[] = "Only JPG, JPEG,GIF,PNG are allowed";
		}
	}else{
		$user_pic = $image;
	}
	if(!isset($error)){
		if($user->edit_profile($name,$username,$password,$id,$user_pic)){
			$success = "Profile updated Successfuly";			
		}else{
			$error[] = "Error while Updating";
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
	<p style="color:green;font-weight:bold">Welcome <?php echo $name; ?>!</p>
	<?php
}
 ?>
<p style="color:green;font-weight:bold"><?php echo $success; ?></p>
<?php
if(isset($error)){
	foreach($error as $errors) {
		?>
		<div style="color:red"><?php echo $errors; ?></div>
		<?php
	}
}
?>
 <form method="POST" enctype="multipart/form-data" action="index.php">
 <img src="uploads/<?php echo $image ?>" style="width:70px;height:70px;border-radius:100%;"><h3><?php $name;  ?></h3><br>
 	<input type="file" name="profile-image"><br>
 	<input type="text" name="name" value="<?php echo $name; ?>"><br>
 	<input type="text" name="username" value="<?php echo $username; ?>"><br>
 	<input type="password" name="password" value="<?php echo $password; ?>"><br>
 	<button type="submit" name="upload-btn">Update</button>
 </form>
 <form action="logout.php">
 	<button type="submit" name="logout-btn">Logout</button>
 </form>
</body>
</html>