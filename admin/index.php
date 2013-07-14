<?php
//check if logged in and is_admin

?>

<html>
<head>
	<title>Web JukeBox Admin Console</title>
	<script src="../js/jquery-1.9.1.min.js"></script>
	<script src="../js/jquery-ui.js"></script>
	<link rel="stylesheet" href="../css/jquery-ui.min.css" />
	<script>
		$(function() {
			$( "#tabs" ).tabs();

			$('#overview').on('click',function(){
				$.ajax({
				    url: '../rpc/admin.php',
				    type: 'POST',
				    data: {action: 'overview', sub_action: 'view'}
				}).done(function(result){
					$('#tabs-1').html(result);
				});
			});

			$('#songs').on('click',function(){
				$.ajax({
				    url: '../rpc/admin.php',
				    type: 'POST',
				    data: {action: 'songs', sub_action: 'view'}
				}).done(function(result){
					$('#tabs-2').html(result);
				});
			});

			$('#users').on('click',function(){
				$.ajax({
				    url: '../rpc/admin.php',
				    type: 'POST',
				    data: {action: 'users', sub_action: 'view'}
				}).done(function(result){
					$('#tabs-3').html(result);
				});
			});
		});
	</script>
</head>
<body>
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1" id="overview">Overview</a></li>
			<li><a href="#tabs-2" id="songs">Songs</a></li>
			<li><a href="#tabs-3" id="users">Users</a></li>
		</ul>
		<div id="tabs-1">
			<p>
				this is the overview tab
			</p>
		</div>
		<div id="tabs-2">
			<p>
				this is the songs library tab
			</p>
		</div>
		<div id="tabs-3">
			<p>
				this is the users tab
			</p>	
		</div>
	</div>
	<script type="text/javascript">
		//add live binding to the other non view sub actions
	</script>
</body>
</html>