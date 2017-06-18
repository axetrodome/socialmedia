<?php 
class User{
	private $db;

	function __construct($dbconn){
		$this->db = $dbconn;
	}
	public function create($name,$username,$email,$password)
	{
		try
		{
			$hash_password = password_hash($password,PASSWORD_DEFAULT);
			$stmt = $this->db->prepare("INSERT INTO users (name,username,email,password) VALUES(:name, :username, :email, :password)");
			$stmt->bindparam(":name",$name);
			$stmt->bindparam(":username",$username);
			$stmt->bindparam(":email",$email);
			$stmt->bindparam(":password",$hash_password);
			$stmt->execute();
			return true;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
		}
		
	}
	public function login($name,$username,$password){
		try{	
		$stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username OR name = :name LIMIT 1");
		$stmt->execute(array(':username'=> $username,':name'=> $name));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($stmt->rowCount() > 0){
			if(password_verify($password,$row['password'])){
				$SESSION['user_id'] = $row['id'];
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