<!DOCTYPE html>
<html>
<?php 
session_start();
include_once 'db.php';
if(isset($_POST['login-btn'])){
	$name = $_POST['user'];
	$username = $_POST['user'];
	$password = $_POST['password'];

	if($user->login($name,$username,$password)){
		$user->redirect('index.php?logged');
	}else{
		$user->redirect('login.php?logfailed');
	}
}
?>
<head>
	<title>Login</title>
</head>
<body>
<?php 
if(isset($_GET['logfailed']))
{
	?>
	<p style="color:red;font-weight:bold">Wrong password or username</p>
	<?php
}

?>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
	<input type="text" name="user" placeholder="Username" required="">
	<input type="password" name="password" placeholder="Password" required="">
	<button type="submit" name="login-btn">Login</button>
</form>
<a href="register.php?inserted">Go back to register page</a>
</body>
</html>