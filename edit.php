<?php
include_once 'db.php';
session_start();
if(!$user->is_loggedin()){
	$user->redirect('login.php');
}
$error = [];
$success = '';
if(isset($_GET['id']))
{
	$id = $_GET['id'];
	extract($user->getID($id));	
}
if(isset($_POST['edit'])){

	$name = $_POST['name'];
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];	
	$imgFile = $_FILES['profile-image']['name'];
	$tmp_dir = $_FILES['profile-image']['tmp_name'];
	$imgSize = $_FILES['profile-image']['size'];

	if($imgFile){
		$upload_dir = 'uploads/';
		$valid_extensions = array('jpeg','jpg','gif','png');
		$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
		$user_pic = rand(1000,1000000).'.'.$imgFile;
		
		if(in_array($imgExt, $valid_extensions)){

			if($imgSize < 5000000){
				unlink($upload_dir.$image);
				move_uploaded_file($tmp_dir, $upload_dir.$user_pic);
			}else{
				$error[] = 'Image size is too big';
			}
		}else{
			$error[] = 'Only JPEG,GIF,PNG,JPG are allowed';
		}
	}else{
		$user_pic = $image;
	}


	if(!$error){
		if($user->edit_profile($name,$username,$email,$password,$id,$user_pic)){
			$success = 'Profile Successfuly Updated';
		}
	}else{
		$error[] = 'Error while Updating';
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit</title>
</head>
<body>
<div style="color:green"><?php echo $success; ?></div>
<?php
if(isset($error)){
	foreach($error as $errors) {
		?>
		<div style="color:red"><?php echo $errors ?></div>
		<?php
	}
}
?>
<form method="POST" enctype="multipart/form-data">
	<img src="uploads/<?php echo $image ?>" style="width:70px;height:70px;border-radius:100%;"><br>
	<input type="file" name="profile-image"><br>
	<input type="text" name="name" value="<?php echo $name; ?>"><br>
	<input type="text" name="username" value="<?php echo $username; ?>"><br>
	<input type="email" name="email" value="<?php echo $email; ?>"><br>
	<input type="password" name="password" value="<?php echo $password; ?>"><br>
	<button type="submit" name="edit">Update</button>
</form>
<form action="logout.php">
	<button type="submit">Logout</button>
</form>
</body>
</html>