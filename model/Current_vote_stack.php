<?php
 class Current_vote_stack extends Base {
 	function __construct($id = NULL){
		$table = 'current_vote_stack';
		$pk = 'id_hash';
		parent::__construct($table, $pk, $id);
	}

	public function getNext($lastUsedTimeStamp = 0){
		try {
			$select = $this->db->select()->from($this->table);
			$select->where("{$this->pk} > ?", date('c',strtotime($lastUsedTimeStamp)));
			$select->order("{$this->pk}")->limit(1);
			return $select->query()->fetch(Zend_Db::FETCH_ASSOC);
		} catch (Exception $e) {
			//return $e->getMessage();
			return FALSE;
		}	}
 }
?>