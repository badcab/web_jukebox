<?php
	$action = isset($_POST['action']) ? $_POST['action'] : NULL;
	$sub_action = isset($_POST['sub_action']) ? $_POST['sub_action'] : NULL;
	//option1
	//option2


	if($action == 'songs'){
		//create a songs object
		if($sub_action == 'view'){
			$result = '<p>view songs rpc</p>';
		}
		if($sub_action == 'rescan'){

		}
		if($sub_action == 'delete'){

		}
	}

	if($action == 'users'){
		//create a users object
		if($sub_action == 'view'){
			$result = '<p>view users rpc</p>';
		}
		if($sub_action == 'delete'){

		}
		if($sub_action == 'add'){

		}
		if($sub_action == 'password'){

		}
		if($sub_action == 'admin_status'){

		}
	}

	if($action == 'overview'){ 
		//create a overview object
		if($sub_action == 'view'){
			$result = '<p>view overview rpc</p>';
		}
		if($sub_action == 'change_votes'){

		}
	}

	echo $result;
?>