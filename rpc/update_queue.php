<?php
	require_once('../CONFIG.php');
//	if(!$_SESSION['logged_in']){die();}

	$current_hash_id = isset($_POST['hash_id']) ? $_POST['hash_id'] : NULL ;
	$advance_by_one = isset($_POST['advance_by_one']) ? $_POST['advance_by_one'] : FALSE ;

	$cvs = new Current_vote_stack();

	

//if $current_hash_id is in the array and advance_by_one is false then set the update_list opt to false

//figure out what to do if the exause the entrpy in the vote_stack

	$return = array(
		'hash_id' => 'adfadfasfds',
		'update_list' => TRUE,
		'max_entropy' => FALSE,
		'song1' => 'It is my life',
		'song2' => 'I am the best',
		'song3' => 'Bubble Pop',
		'vote1' => rand ( 0 , 70 ),
		'vote2' => rand ( 0 , 70 ),
		'vote3' => rand ( 0 , 70 ),
	);

	header('Content-type: application/json');
	echo json_encode($return);
?>