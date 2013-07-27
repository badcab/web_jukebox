<?php
require_once('../CONFIG.php');

$vote_for = (int)$_POST['vote_for'];

$cvs = new Current_vote_stack();
$next = FALSE;

if($cvs->castVote($vote_for, $_SESSION['current_hash_id'])){
	$next = $cvs->getNext($_SESSION['current_hash_id']);
} 

if(!$next){
	$next = array('error' => TRUE, 'go_dance' => TRUE);//should trigger a go dance mordal
}

header('Content-type: application/json');
echo json_encode($next);	
?>