#!/usr/bin/php

<?php
	require_once('CONFIG.php');
	#After you have put your songs in there respective folders run this to populate the
	#DB. If you are going to be running this program on multiple computers make sure you
	#have an exact copy of the music folder on each box
	$Songs = new Songs();
	$Songs->scanMusicDir();
	print_r($Songs->getAll(),TRUE);
	$Songs->initialStartUp(5,2);
	echo 'done, now run the python script on the box that will output the music';
?>
