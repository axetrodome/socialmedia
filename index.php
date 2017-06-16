<!DOCTYPE html>
<html>
<?php 
session_start();
include_once 'db.php';
 ?>
<head>
	<title>Welcome page</title>
</head>
<body>
<?php
if(isset($_GET['logged'])){
	?>
	<p style="color:green;font-weight:bold">You are logged in as user number<?php $_SESSION['user_id']; ?></p>
	<?php
}
 ?>
</body>
</html>