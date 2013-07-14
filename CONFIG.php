<?php
define(DB_NAME,'web_jukebox');
define(DB_USER,'root');
define(DB_PASSWORD,'blizzard');
define(DB_HOST,'localhost');
define(ZEND_INCLUDE_PATH,'/usr/share/php/');
define(MP3_INCLUDE_PATH,'/usr/share/php/');
define(MUSIC_DIRECTORY,'/home/pi/music');

set_include_path(implode(PATH_SEPARATOR, array(
    ZEND_INCLUDE_PATH,
    get_include_path(),
)));

session_start();
?>