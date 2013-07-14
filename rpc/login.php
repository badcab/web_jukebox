<?php
	//verify username and password, go to voting area if valid
	session_start();

	//do the db call to check pw
	if(!$_SESSION['logged_in']){die();}
?>