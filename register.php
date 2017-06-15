<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
</head>
<?php 
include_once 'db.php';
if(isset($_POST['submit-btn']))
{
	$name = $_POST['name'];
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$hash = password_hash($password,PASSWORD_BCRYPT,['cost'=>11]);
	if($user->create($name,$username,$email,$password))
	{
		header("Location:register.php?inserted");
	}
	else
	{
		header("Location:register.php?failed");
	}
}
 ?>
<body>
<?php 
if(isset($_GET['inserted'])){
?>
	<div style="color:green">Success</div>
	
<?php
}elseif (isset($_GET['failed'])) {
?>
	<div style="color:red">Failed</div>
<?php
}
 ?>
<form method="POST">
	<input type="text" name="name" placeholder="Name" required="">
	<input type="text" name="username" placeholder="Username" required="">
	<input type="text" name="email" placeholder="Email" required="">
	<input type="password" name="password" placeholder="Password" required="">
	<button type="submit" name="submit-btn">Register</button>
</form>
</body>
</html>