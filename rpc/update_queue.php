<?php
	require_once('../CONFIG.php');
//	if(!$_SESSION['logged_in']){die();}

	$current_hash_id = isset($_POST['id_hash']) ? $_POST['id_hash'] : NULL ;
	$advance_by_one = isset($_POST['advance_by_one']) ? $_POST['advance_by_one'] : FALSE ;
	//maybe I should change advance_by_one to vote for ID

	$cvs = new Current_vote_stack();

	if($advance_by_one){
		$next = $cvs->getNext($current_hash_id);
	} else {
		$next = $cvs->get($current_hash_id);
	}

	if(!$next){
		//somthing unexpected happended, acuracy is not important for this so we will just start over
		$next = $cvs->getNext(0);
	}
	


/*
    $next['id_hash'] => 2013-07-19 20:11:10
    $next['song1_id'] => 6
    $next['song2_id'] => 11
    $next['song3_id'] => 12
    $next['vote1'] => 5
    $next['vote2'] => 4
    $next['vote3'] => 6
    $next['song1_desc'] => tttt
    $next['song2_desc'] => ttt
    $next['song3_desc'] => tttt
*/

	$return = array(
		'id_hash' => $next['id_hash'],
		'update_list' => TRUE,
		'max_entropy' => FALSE,
		'song1' => $next['song1_desc'],
		'song2' => $next['song2_desc'],
		'song3' => $next['song3_desc'],
		'vote1' => $next['vote1'],
		'vote2' => $next['vote2'],
		'vote3' => $next['vote3'],
	);

	header('Content-type: application/json');
	echo json_encode($return);
?>