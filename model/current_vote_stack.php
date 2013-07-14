<?php
 class current_vote_stack extends base {
 	function __construct($id = NULL){
		$table = 'current_vote_stack';
		$pk = 'id';
		parent::__construct($table, $pk, $id);
	}
 }
?>