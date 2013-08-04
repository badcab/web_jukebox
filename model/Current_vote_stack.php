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
			$this->debug($e->getMessage(),'current_vote_stack getNext');
			return FALSE;
		}	
	}

	public function castVote($songSlot, $id_hash){
		try {
//$this->db->beginTransaction();
$this->debug($id_hash,'timestamp voting on');
			$current = $this->get($id_hash);//this is throwing an error

			if(!$current[$this->pk]){
				$this->db->rollBack();
				$this->debug('there was a problem getting record','castVote model');
				return FALSE;
			}
			
			if((int)$songSlot == 1){
				$current['vote1']++;
			} elseif ((int)$songSlot == 2) {
				$current['vote2']++;
			} elseif ((int)$songSlot == 3) {
				$current['vote3']++;
			}

$this->debug($current,'castVote model vote to save');

			$this->save($current);

//$this->db->commit();
			return TRUE;
			
		} catch (Exception $e) {
			$this->db->rollBack();
			$this->debug($e->getMessage(),'current_vote_stack castVote error');
			return FALSE;
		}
	}
}
?>