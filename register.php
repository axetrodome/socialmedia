<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
</head>
<?php 
session_start();
$errphp = false;
$success = '';
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
			$error[] = 'Please Enter Name';
			$errphp = true;
		}elseif($user->Name_validation($name)){
				$error[] = "Letters and White space Only";
				$errphp = true;
		}elseif(empty($username)){
			$error[] = 'Please Enter Username';
			$errphp = true;
		}else{
			try{
			$stmt = $dbconn->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
			$stmt->execute(array(':username'=>$username,':email'=>$email));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
				if($row['username'] == $username){
					$error[] = 'Username was already taken';
					$errphp = true;
				}
			}catch(PDOException $e){
				echo $e->getMessage();
			}
		}
		if(empty($email)){
			$error[] = 'Please Enter E-mail';
			$errphp = true;
		}elseif($user->Email_validation($email)){
				$error[] = "Invalid E-mail format";
				$errphp = true;
		}elseif($row['email'] == $email){
				$error[] = 'Email was already taken';
				$errphp = true;
		}elseif(empty($password)){
			$error[] = 'Please Enter Password';
		}elseif($user->PasswordLength($password)){
				$error[] = "Password must contain atleast 6 Characters";
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
				   	 $error[] = "File is too big";
				   	 $errphp = true;
				    }

			}else{
				$error[] = "Only JPG,PNG,JPEG,GIF are allowed";
				$errphp = true;
			}
				if($errphp == false)
				{
					if($user->create($name,$username,$email,$password,$userpic))
					{
						$success = "Successfully Inserted!"; // redirects image view page after 5 seconds.
					}
					else
					{
						$error[] = "error while inserting....";
					}
				}
		//END OF IMAGE UPLOAD
	}
}
 ?>
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
<form method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
	<input type="file" name="profile-image">
	<input type="text" name="name" placeholder="Name" value="<?php echo $name = (isset($error)) ? $name : '';  ?>">
	<input type="text" name="username" placeholder="Username" value="<?php echo $username = (isset($error)) ? $username : ''; ?>">
	<input type="email" name="email" placeholder="E-mail" value="<?php echo $email  = (isset($error)) ? $email : ''; ?>">
	<input type="password" name="password" placeholder="Password">
	<button type="submit" name="submit-btn">Register</button>
</form>
<a href="login.php">Go to login page</a>
</body>
</html>		
