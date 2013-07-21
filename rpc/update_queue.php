<?php
	require_once('../CONFIG.php');

	//$current_hash_id = isset($_POST['id_hash']) ? $_POST['id_hash'] : FALSE ;
	$advance_by_one = isset($_POST['advance_by_one']) ? $_POST['advance_by_one'] : FALSE ;
	//$max_entropy = TRUE;
	//may need a $_SESSION var to keep track of the current_hash
	

	$cvs = new Current_vote_stack();
	if(!isset($_SESSION['current_hash_id'])){
		$first = $cvs->getNext();
		$_SESSION['current_hash_id'] = $first['id_hash'];
	}
	

	if($advance_by_one){
		$next = $cvs->getNext($_SESSION['current_hash_id']);
	} else {
		$next = $cvs->get($_SESSION['current_hash_id']);
	}

	if($next){
		$max_entropy = FALSE;
	} else {
		$max_entropy = TRUE;
	}
	
	$return = array(
		'id_hash' => $next['id_hash'],
		'update_list' => TRUE,
		'max_entropy' => $max_entropy,//when set to true the just dance mordal shows
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