<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
</head>
<?php 
session_start();
$errphp = false;
$errName = $errUsername = $errEmail = $errPass = $errImg = $errImgExt = $errMSG = "";
include_once 'db.php';
if($user->is_loggedin() != ''){
	$user->redirect('index.php');
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
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
			$errName = 'Please Enter Name';
			$errphp = true;
		}else{
			if(!preg_match("/^[A-Za-z]*$/", $name)){
				$errName = "Letters and White space Only";
				$errphp = true;
			}
		} 
		if(empty($username)){
			$errUsername = 'Please Enter Username';
			
		}else{
			try{
			$stmt = $dbconn->prepare("SELECT * FROM users WHERE username = :username");
			$stmt->bindparam(':username',$username);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
				if($row['username'] == $username){
					$errUsername = 'Username was already taken';
					$errphp = true;
				}
			}catch(PDOException $e){
				echo $e->getMessage();
			}
		}
		if(empty($email)){
			$errEmail = 'Please Enter E-mail';
			$errphp = true;
		}else{
			if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
				$errEmail = "Invalid E-mail format";
				$errphp = true;
			}
		} 

		if(empty($password)){
			$errPass = 'Please Enter Password';
		}else{
			if(strlen($password) < 6){
				$errPass = "Password must contain atleast 6 Characters";
			}
		}
		// IMAGE UPLOAD
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
				if($imgSize < 5000000)    {
				     move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				    }
				    else{
				   	 $errImg = "File is too big";
				   	 $errphp = true;
				    }

			}else{
				$errImgExt = "Only JPG,PNG,JPEG,GIF are allowed";
				$errphp = true;
			}

				if($errphp == false)
				{
					if($user->create($name,$username,$email,$password,$userpic))
					{
						header("Location:register.php?inserted"); // redirects image view page after 5 seconds.
					}
					else
					{
						$errMSG = "error while inserting....";
					}
				}
		//END OF IMAGE UPLOAD
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
?>
<div style="color:red"><?php echo $errName ?></div>
<div style="color:red"><?php echo $errUsername ?></div>
<div style="color:red"><?php echo $errEmail ?></div>
<div style="color:red"><?php echo $errPass ?></div>
<div style="color:red"><?php echo $errImgExt ?></div>
<div style="color:red"><?php echo $errMSG ?></div>
<form method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
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
