<?php
	require_once('CONFIG.php');
	
	$songs = new Songs(1);

	//echo print_r($songs->get(),TRUE);
	//echo '<br/>';
	//echo print_r($songs->get(4),TRUE);
	echo '<br/><pre>';
	echo print_r($songs->scanMusicDir(),TRUE);
	echo '<br/></pre>';
?>
