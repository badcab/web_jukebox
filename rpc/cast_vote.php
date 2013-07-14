<?php
	session_start();
	if(!$_SESSION['logged_in']){die();}
	//for when a user makes a selection of what song to vote for

	//first check if the vote is still valid and then write the change, lastly return a json object with new vote queue
?>