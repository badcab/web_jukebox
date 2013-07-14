<?php
 class songs extends base {
 	function __construct($id = NULL){
		$table = 'songs';
		$pk = 'id';
		parent::__construct($table, $pk, $id);
	}

	public function scanMusicDir(){
		
		$music_root = scandir(MUSIC_DIRECTORY);
		//add code here to include the id3 class

		$dir = array();
		foreach($music_root as $file){
			if(is_dir(MUSIC_DIRECTORY . '/' . $file) && substr($file, 0, 1) != '.'){
				$arr['category'] = $file;
				foreach(scandir(MUSIC_DIRECTORY . '/' . $file) as $music){
					if(is_file(MUSIC_DIRECTORY . '/' . $file . '/' . $music)){
						//check if it is an mp3      strpos($str, '.') !== FALSE
						//echo print_r(getID3(MUSIC_DIRECTORY . '/' . $file . '/' . $music), TRUE);
						//should get the artist name, song name and the file location
						$arr['music'][] = $music;	
					}
				}
				$dir[] = $arr;	
			}
		}

		echo print_r($dir,TRUE);

		//now check if the songs are already in the db
		foreach ($dir as $key => $value) {
			foreach ($value as $key2 => $music_file) {
				try {
					//$this->getAll(array('file_path' => MUSIC_DIRECTORY . '/' . $value['category'] . '/' . $value['music']));
				} catch (Exception $e) {
					//thrown exception means does not exist, so write it
				}
			}
		}

		//at this point we should remove things in db that are not in $dir
	}
 }
?>