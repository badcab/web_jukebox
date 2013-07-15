<?php
//if(!defined(''))
if(!defined('DB_NAME')) {define('DB_NAME','web_jukebox');}
if(!defined('DB_USER')) {define('DB_USER','root');}
if(!defined('DB_PASSWORD')) {define('DB_PASSWORD','blizzard');}
if(!defined('DB_HOST')) {define('DB_HOST','localhost');}
if(!defined('ZEND_INCLUDE_PATH')) {define('ZEND_INCLUDE_PATH','/usr/share/php');}
if(!defined('MP3_INCLUDE_PATH')) {define('MP3_INCLUDE_PATH','/usr/share/php');}
if(!defined('MUSIC_DIRECTORY')) {define('MUSIC_DIRECTORY','/home/pi/music');}
if(!defined('MODELS')) {define('MODELS','/var/www/model/');}

set_include_path(get_include_path() . PATH_SEPARATOR . ZEND_INCLUDE_PATH);
//set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . '/model');

require_once('Zend/Loader.php');
Zend_Loader::loadClass('Zend_Db');

foreach (glob("model/*.php") as $filename)
{
	include $filename;
}

//remember to use glob to load all the mp3 stuff too


session_start();
?>