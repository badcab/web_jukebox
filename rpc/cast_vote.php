<?php
require_once('../CONFIG.php');

$id_hash = (isset($_POST['id_hash'])) ? $_POST['id_hash'] : NULL ;
$vote_for = (int)$_POST['vote_for'];

$cvs = new Current_vote_stack();
$next = FALSE;

if($cvs->castVote($vote_for, $id_hash)){
	$next = $cvs->getNext($id_hash);
} 

if(!$next){
	$next = array('error' => TRUE, 'go_dance' => TRUE);
}

header('Content-type: application/json');
echo json_encode($next);	
?>