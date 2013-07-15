<?php
 class Login extends Base {
 	function __construct($id = NULL){
		$table = 'login';
		$pk = 'id';
		parent::__construct($table, $pk, $id);
	}

	public function hash_password($username, $password){
		return hash('sha256', $username . $password . 'pathedic saLt$');
	}

	public function login_attempt($username, $password){
		$row = $this->getAll(array('user_name' => $username));
		return ($row[0]['password'] === hash_password($username, $password)) ? $row[0]['id'] : FALSE ;
		//remember to add a unique constraint to the username for login
	}

	public function create_user($username, $password, $is_admin = 0){
		return $this->save(array(
			'user_name' => $username,
			'password' => hash_password($username, $password),
			'is_admin' => $is_admin,
		));
	}

	public function change_password($username, $password_new, $password_old){
		//likely will not be used for this project
		if($id = login_attempt($username, $password_old)){
			return $this->save(array(
				'password' => hash_password($username, $password_new),
				'id' => $id,
			));
		}
	}
 }
?>