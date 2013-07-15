<?php
 class Current_vote_stack extends Base {
 	function __construct($id = NULL){
		$table = 'current_vote_stack';
		$pk = 'hash_id';
		parent::__construct($table, $pk, $id);
	}
 }
?>