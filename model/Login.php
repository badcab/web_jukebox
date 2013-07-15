<?php
 class Login extends Base {
 	function __construct($id = NULL){
		$table = 'login';
		$pk = 'id';
		parent::__construct($table, $pk, $id);
	}
 }
?>