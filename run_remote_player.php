<?php
#problems with my live web host so I have to use this method to actually get the data from the db
$sec_lazy = '';//lazy get password used
$base_url = '';//place you put your api

while(TRUE) {
	$result = file_get_contents($base_url . '?sec_lazy=' . $sec_lazy);
	$arr = json_decode($result,TRUE);
	$queue_id = $arr[0]['id'];
	$music_file = $arr[0]['file_path'];
	sleep(1);
	$play_cmd = "omxplayer " . escapeshellarg($music_file);
	echo "playing $music_file\n";
	exec($play_cmd);
}
?>

