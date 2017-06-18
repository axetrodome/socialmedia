<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
</head>
<?php 
session_start();
include_once 'db.php';
if(isset($_POST['submit-btn']))
{
	$name = $_POST['name'];
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
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
	<div style="color:green">Success!:</div>
<?php
}
elseif (isset($_GET['failed'])) {
echo $password;
?>
	<div style="color:red">Failed</div>
<?php
}
 ?>

<form method="POST">
	<input type="text" name="name" placeholder="Name" required="">
	<input type="text" name="username" placeholder="Username" required="">
	<input type="email" name="email" placeholder="Email" required="">
	<input type="password" name="password" placeholder="Password" required="">
	<button type="submit" name="submit-btn">Register</button>
</form>
<a href="login.php">Go to login page</a>
</body>
</html>