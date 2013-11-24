<?php

if($_GET['sec_lazy'] != 'XXXXXXPASSWORDXXXXXXX'){
	die('cryptic message');
}

$db = new PDO();//fill in connection string

try {
	$stmt = $db->query("SELECT `queue`.`id`, `songs`.`file_path` FROM `queue` JOIN `songs` ON `songs`.`id`=`queue`.`song_id`ORDER BY `time` ASC LIMIT 1");
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$delete = "DELETE FROM `queue` WHERE `queue`.`id` = " . $result[0]['id'];
	$sp = "CALL ADD_TO_QUEUE()";
	$db->exec($delete);
	$db->exec($sp);
	$json = json_encode($result);
} catch(PDOException $ex) {
	$json = json_encode($ex->getMessage());
}

header('Content-Type: application/json');
echo $json;
?>
