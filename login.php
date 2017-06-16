<!DOCTYPE html>
<html>
<?php 
session_start();
$user_id = $_SESSION['user_id'];
include_once 'db.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$username = $_POST['username'];
	$password = $_POST['password'];

	$stmt = $dbconn->prepare("SELECT * FROM users WHERE username =:username AND password=:password");
	$stmt->bindParam(':username',$username);
	$stmt->bindParam(':password',$password);
	$stmt->execute();
	$row = $stmt->fetch();
	$id = $row['id'];
	 if($username != $row['username'] || $password != $row['password'] ){
	 	header("location:login.php?logfailed");
	 }else{
	 	$_SESSION['user_id'] = $id;
	 	header("Location:login.php?logged");
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
elseif(isset($_GET['logged'])){
	?>
	<p style="color:green;font-weight:bold">You are logged in as user number <?php echo $user_id ?><h1></h1></p>
	<?php
}
 ?>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
	<input type="text" name="username" placeholder="Username">
	<input type="password" name="password" placeholder="Password">
	<button type="submit" name="login-btn">Login</button>
</form>
</body>
</html>