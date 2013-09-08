<?php
if(!defined('DB_NAME')) {define('DB_NAME','web_jukebox');}
if(!defined('DB_USER')) {define('DB_USER','root');}
if(!defined('DB_PASSWORD')) {define('DB_PASSWORD','blizzard');}
if(!defined('DB_HOST')) {define('DB_HOST','localhost');}
if(!defined('ZEND_INCLUDE_PATH')) {define('ZEND_INCLUDE_PATH','..');}
//if(!defined('MP3_INCLUDE_PATH')) {define('MP3_INCLUDE_PATH','..');}//if this and the zend path were different I would have to put both in the include path but well they are the same
if(!defined('MUSIC_DIRECTORY')) {define('MUSIC_DIRECTORY','/home/pi/music');}
if(!defined('DEV_MODE')) {define('DEV_MODE',TRUE);}

set_include_path(get_include_path() . PATH_SEPARATOR . ZEND_INCLUDE_PATH);

require_once('Zend/Loader.php');
Zend_Loader::loadClass('Zend_Db');

foreach (glob(dirname(__FILE__)."/model/*.php") as $filename){
	include $filename;
}

function rpc_debug($input, $label = ''){
	if(!DEV_MODE){
		return;
	}

	$file="../log/rpc_log.log";
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

session_start();
date_default_timezone_set('Etc/UTC');

//set cookie and session variables to make things a bit sticky
//the only things saved here is the timestamp that is used for voting
//have a secret way to not sticky things (for public voting)
?>
