<?php
if(!defined('DB_NAME')) {define('DB_NAME','web_jukebox');}
if(!defined('DB_USER')) {define('DB_USER','root');}
if(!defined('DB_PASSWORD')) {define('DB_PASSWORD','blizzard');}
if(!defined('DB_HOST')) {define('DB_HOST','localhost');}
if(!defined('ZEND_INCLUDE_PATH')) {define('ZEND_INCLUDE_PATH','/usr/share/php');}
if(!defined('MP3_INCLUDE_PATH')) {define('MP3_INCLUDE_PATH','/usr/share/php');}//if this and the zend path were different I would have to put both in the include path but well they are the same
if(!defined('MUSIC_DIRECTORY')) {define('MUSIC_DIRECTORY','/home/pi/music');}
if(!defined('DEV_MODE')) {define('DEV_MODE',TRUE);}

set_include_path(get_include_path() . PATH_SEPARATOR . ZEND_INCLUDE_PATH);

require_once('Zend/Loader.php');
Zend_Loader::loadClass('Zend_Db');

foreach (glob(dirname(__FILE__)."/model/*.php") as $filename){
	include $filename;
}

session_start();

function loginCheck(){
	if(!isset($_SESSION['logged_in'])){
		$_SESSION['logged_in'] = FALSE;
	}

	if(!$_SESSION['logged_in']){
		//die();//instead redirect to the login page
	} 
}

loginCheck();

?>