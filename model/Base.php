<?php
class Base {
	protected $table;
	protected $pk;
	protected $id;
	protected $db;

	function __construct($table, $pk = NULL, $id = NULL){
		$this->table = $table;
		$this->pk = $pk ? $pk : 'id';
		$this->id = $id;

		try {
			$this->db = Zend_Db::factory('Pdo_Mysql', array(
				'host'     => DB_HOST,
				'username' => DB_USER,
				'password' => DB_PASSWORD,
				'dbname'   => DB_NAME
			));
		} catch (Exception $e) {
			die($e->getMessage() . ' base construct');
		}
	}

	public function get($id = NULL){
		$id = ($id) ? $id : $this->id;
		try {
			$select = $this->db->select()->from($this->table)->where("{$this->pk} = ?", $id);
			return $select->query()->fetch(Zend_Db::FETCH_ASSOC);
		} catch (Exception $e) {
			$this->debug($e->getMessage(),'base get');
			return FALSE;
		}
	}

	public function delete($id = NULL){
		$id = ($id) ? $id : $this->id;
		try {
			$this->db->delete($this->table,"{$this->pk} = {$id}");
			return TRUE;
		} catch (Exception $e) {
			$this->debug($e->getMessage(),'base delete');
			return FALSE;
		}
	}

	public function save($data){
		try {
			if(isset($data[$this->pk]) && $data[$this->pk]){
				$this->db->update($this->table,$data,"{$this->pk} = {$data[$this->pk]}");
				return $data[$this->pk];
			} else {
				$this->db->insert($this->table, $data);
				return $this->db->lastInsertId();
			}
		} catch (Exception $e) {
			$this->debug($e->getMessage(),'base save');
			return FALSE;
		}
	}

	public function getAll(array $filter = array()){
		try {
			if(empty($filter)){
				return $this->db->select()->from($this->table)->query()->fetchAll(Zend_Db::FETCH_ASSOC);
			} else {
				$select = $this->db->select()->from($this->table);
				foreach ($filter as $key => $value) {
					$select->where("{$key} = ?", $value);
				}
				return $select->query()->fetchAll(Zend_Db::FETCH_ASSOC);
			}
		} catch (Exception $e) {
			$this->debug($e->getMessage(),'base getAll');
			return FALSE;
		}
	}

	public function debug($input, $label = ''){
		if(!DEV_MODE){
			return;
		}

		$file="../log/db_log.log";
		$linecount = 0;
		$handle = fopen($file, "r");
		while(!feof($handle)){
			$line = fgets($handle);
			$linecount++;
		}
		fclose($handle);
		if($linecount > 10000){
			file_put_contents($file, '');//keep this log from getting huge
		}

		$result = '';
		$result .= "\n" . str_pad(date('c',strtotime("now")), 80, "*", STR_PAD_BOTH) . "\n";
		$result .= print_r($input,TRUE);
		$result .= "\n" . str_pad($label, 80, "*", STR_PAD_BOTH) . "\n";
		file_put_contents($file, $result, FILE_APPEND);
	}

}
?>

