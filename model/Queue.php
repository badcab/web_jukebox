<?php
 class Queue extends Base {
 	function __construct($id = NULL){
		$table = 'queue';
		$pk = 'id';
		parent::__construct($table, $pk, $id);
	}
 }
?>

