<?php
	require_once('../CONFIG.php');
//I will have to add some sort of "lock" in session to prevent the reload
	$advance_by_one = isset($_POST['advance_by_one']) && (int)$_POST['advance_by_one'] ? TRUE : FALSE ;
	$_SESSION['dance_lock'] = (isset($_SESSION['dance_lock'])) ? $_SESSION['dance_lock'] : FALSE ;

	$cvs = new Current_vote_stack();
	if(!isset($_SESSION['current_hash_id'])){
		$first = $cvs->getNext();
		$_SESSION['current_hash_id'] = $first['id_hash'];
	}

	if($advance_by_one || $_SESSION['dance_lock']){
		$next = $cvs->getNext(date('c',strtotime($_SESSION['current_hash_id'])));
	} else {
		$next = $cvs->get(date('c',strtotime($_SESSION['current_hash_id'])));
	}

	$_SESSION['current_hash_id'] = strtotime($next['id_hash']) ? $next['id_hash'] : $_SESSION['current_hash_id'] ;

	if($next){
		$max_entropy = FALSE;
		$_SESSION['dance_lock'] = FALSE;
	} else {
		$max_entropy = TRUE;
		$_SESSION['dance_lock'] = TRUE;
	}

	$return = array(
		'id_hash' => $_SESSION['current_hash_id'],
		'update_list' => TRUE,
		'go_dance' => $max_entropy,
		'max_entropy' => $max_entropy,//when set to true the just dance mordal shows
		'song1' => $next['song1_desc'],
		'song2' => $next['song2_desc'],
		'song3' => $next['song3_desc'],
		'vote1' => $next['vote1'],
		'vote2' => $next['vote2'],
		'vote3' => $next['vote3'],
		'file_loc' => __FILE__,
	);

	header('Content-type: application/json');
	echo json_encode($return);

//rpc_debug($_SESSION['current_hash_id'], 'update_queue rpc current hash');
//rpc_debug($next, ' next var');
?>
