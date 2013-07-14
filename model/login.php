<?php
 class login extends base {
 	function __construct($id = NULL){
		$table = 'login';
		$pk = 'id';
		parent::__construct($table, $pk, $id);
	}
 }
?>