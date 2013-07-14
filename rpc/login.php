<?php
	//verify username and password, go to voting area if valid
	require_once('../CONFIG.php');

	//do the db call to check pw
	if(!$_SESSION['logged_in']){die();}
?>