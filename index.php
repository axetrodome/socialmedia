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
$sql = $dbconn->prepare("SELECT * FROM users WHERE id = :id");
$sql->execute(array(':id'=> $id));
$row = $sql->fetch(PDO::FETCH_ASSOC);
extract($row);
if(isset($_POST['upload-btn']))
{
	$imgFile = $_FILES['profile-image']['name'];
	$tmp_dir = $_FILES['profile-image']['tmp_name'];
	$imgSize = $_FILES['profile-image']['size'];
	$name = $_POST['name'];
	$username = $_POST['username'];
	$email = $_POST['email'];

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
	}elseif(empty($email)){
		$error[] = 'Please Enter E-mail';
	}elseif(empty($username)){
		$error[] = 'Enter Username';
	}elseif($user->Email_validation($email)){
			$error[] = "Invalid E-mail format";
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
				move_uploaded_file($tmp_dir, $upload_dir.$user_pic);
			}else{
				$errImg = "Image is too large";
				$errphp = true;
			}
		}else{
			$errImg = "Only JPG, JPEG,GIF,PNG are allowed";
			$errphp = true;
		}
	}else{
		$user_pic = $row['image'];
	}

	if($errphp == false){
		if($user->edit_profile($name,$username,$email,$password,$id,$user_pic)){
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
if(isset($error)){
	foreach($error as $errors) {
		?>
		<div style="color:red;"><?php echo $errors ?></div>
		<?php
	}
}
if(isset($success)){
	?>
	<p style="color:green;font-weight:bold"><?php echo $success; ?></p>
	<?php
}
 ?>
 <form method="POST" enctype="multipart/form-data" action="index.php">
 <img src="uploads/<?php echo $row['image'] ?>" style="width:70px;height:70px;border-radius:100%;"><h3><?php $row['name'];  ?></h3><br>
 	<input type="file" name="profile-image"><br>
 	<input type="text" name="name" value="<?php echo $name; ?>"><br>
 	<input type="text" name="username" value="<?php echo $username; ?>"><br>
 	<input type="password" name="password" value="<?php echo $password; ?>"><br>
 	<button type="submit" name="upload-btn">Update</button>
 </form>
 <a href="edit.php?id=<?php echo $row['id']; ?>">Edit profile</a>
 <form action="logout.php">
 	<button type="submit" name="logout-btn">Logout</button>
 </form>
</body>
</html>