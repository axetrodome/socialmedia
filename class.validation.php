<?php 
Class Validation{
	private $db,
			$_errors = array(),
			$_passed = false;
	function __construct($dbconn){
		$this->db = $dbconn;
	}

	public function check($source,$items = array()){
		foreach ($items as $item => $rules) {
			foreach ($rules as $rule => $rule_value) {
				$value = trim($source[$item]);
				
				if($rule === 'required' && empty($value)){
					$this->addError("{$item} is required");
				}elseif(!empty($value)){
					switch ($rule) {
						case 'min':
							if(strlen($value) < $rule_value){
								$this->addError("{$item} must be a minimum of {$rule_value} characters");
							}
							break;
						case 'max':
							if(strlen($value) > $rule_value){
								$this->addError("{$item} must be a maximum of {$rule_value} characters");
							}
							break;	
					}
				}
			}
		}
		if(empty($this->_errors)){
			$this->_passed = true;
		}
	}

	public function addError($error){
		$this->_errors[] = $error;
	}
	public function errors(){
		return $this->_errors;
	}
	public function passed(){
		return $this->_passed;
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