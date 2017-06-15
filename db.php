<?php
try{
	$dbconn = new PDO("mysql:host=localhost;dbname=socialmedia","root","");
	$dbconn->setAttribute(PDO::ERRMODE_EXCEPTION,PDO::ATTR_ERRMODE);
}catch(PDOexception $e){
	echo 'failed to connect'. $e->getMessage();

}
include_once 'class.user.php';
$user = new user($dbconn);
?>