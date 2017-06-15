<?php 
class user{
	private $db;

	function __construct($dbconn){
		$this->db = $dbconn;
	}
	public function create($name,$username,$email,$password)
	{
		try
		{
			$stmt = $this->db->prepare("INSERT INTO users(name,username,email,password) VALUES(:name, :username, :email, :password)");
			$stmt->bindparam(":name",$name);
			$stmt->bindparam(":username",$username);
			$stmt->bindparam(":email",$email);
			$stmt->bindparam(":password",$password);
			$stmt->execute();
			return true;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
		
	}
}

?>