<?php 
Class Validation{
	private $db;
	
	function __construct($dbconn){
		$this->db = $dbconn;
	}
	public function Email_validation($email){
		return !filter_var($email,FILTER_VALIDATE_EMAIL);
	}
	public function Name_validation($name){
		return !preg_match("/^[A-Za-z]*$/", $name);
	}
	public function PasswordLength($password){
		return strlen($password) < 6;
	}
	public function UniqueValidations($username,$email){
		$stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
		$stmt->execute(array(':username'=>$username,':email'=>$email));
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
}

 ?>