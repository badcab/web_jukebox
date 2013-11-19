<?php
 class Songs extends Base {
 	function __construct($id = NULL){
		$table = 'songs';
		$pk = 'id';
		parent::__construct($table, $pk, $id);
	}

	public function initialStartUp($votePile = 5, $queuePlay = 2)
	{
		for($i = 0; $i < $votePile + $queuePlay; $i++){
			sleep(1);
			$this->db->query('CALL web_jukebox.ADD_TO_CURRENT_VOTE_STACK()');
		}

		for($i = 0; $i < $queuePlay; $i++){
			$this->db->query('CALL web_jukebox.ADD_TO_QUEUE()');
		}
	}

	public function scanMusicDir(){
		require_once('getid3/getid3.php');
		$getID3 = new getID3();
		$this->clearSongs();
		$music_root = scandir(MUSIC_DIRECTORY);
		$dir = array();
		foreach($music_root as $file){
			if(is_dir(MUSIC_DIRECTORY . '/' . $file) && substr($file, 0, 1) != '.'){
				foreach(scandir(MUSIC_DIRECTORY . '/' . $file) as $music){
					if(is_file(MUSIC_DIRECTORY . '/' . $file . '/' . $music) && $audio_tag = $getID3->analyze(MUSIC_DIRECTORY . '/' . $file . '/' . $music)){
						$file_path = MUSIC_DIRECTORY . '/' . $file . '/' . $music;
						if(isset($audio_tag['tags']['id3v1'])){
							$dir[] = array(
								'file_path' => $file_path,
								'name' => $audio_tag['tags']['id3v1']['title'][0],
								'artist' => $audio_tag['tags']['id3v1']['artist'][0],
								'category' => $file,
							);
						} elseif(isset($audio_tag['tags']['quicktime'])) {
							$dir[] = array(
								'file_path' => $file_path,
								'name' => $audio_tag['tags']['quicktime']['title'][0],
								'artist' => $audio_tag['tags']['quicktime']['artist'][0],
								'category' => $file,
							);
						} elseif (isset($audio_tag['tags']['id3v2'])) {
							$dir[] = array(
								'file_path' => $file_path,
								'name' => $audio_tag['tags']['id3v2']['title'][0],
								'artist' => $audio_tag['tags']['id3v2']['artist'][0],
								'category' => $file,
							);
						}
					}
				}
			}
		}
		foreach ($dir as $song) {
			$this->save($song);
		}
	}

	private function clearSongs(){
		try {
			$this->db->delete($this->table,"{$this->pk} != 0");
			return TRUE;
		} catch (Exception $e) {
			$this->debug($e->getMessage(),'base delete');
			return FALSE;
		}
	}
}
?>

