<?php 
class User{
	private $db;

	function __construct($dbconn){
		$this->db = $dbconn;
	}
	public function create($name,$username,$email,$password,$userpic)
	{
		try
		{
			$hash_password = password_hash($password,PASSWORD_DEFAULT);
			$stmt = $this->db->prepare("INSERT INTO users (name,username,email,password,image) VALUES(:name, :username, :email, :password,:profile)");
			$stmt->bindparam(":name",$name);
			$stmt->bindparam(":username",$username);
			$stmt->bindparam(":email",$email);
			$stmt->bindparam(":password",$hash_password);
			$stmt->bindparam(":profile",$userpic);
			$stmt->execute();
			return true;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
		}
	}
	public function edit_profile($id,$user_pic){
		try{
			$stmt = $this->db->prepare("UPDATE users SET image = :image WHERE id = :id");
			$stmt->bindParam(":image",$user_pic);
			$stmt->bindParam(":id",$id);
			$stmt->execute();
			return true;
		}catch(PDOException $e){
			echo $e->getMessage();
			return false;
		}

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
	public function login($username,$password){
		try{	
		$stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
		$stmt->bindParam(':username',$username);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		// var_dump($/row);echo '<pre>',print_r($row);die();
		if($stmt->rowCount() > 0){
			if(password_verify($password,$row['password'])){
				$_SESSION['user_id'] = $row['id'];
				return true;
			}else{
				return false;
			}
		}
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}

	public function is_loggedin(){
		if(isset($_SESSION['user_id'])){
			return true;
		}
	}
	public function redirect($url){
		header("location:$url");
	}
}

?>