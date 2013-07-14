<?php
 class queue extends base {
 	function __construct($id = NULL){
		$table = 'queue';
		$pk = 'id';
		parent::__construct($table, $pk, $id);
	}
 }
?>