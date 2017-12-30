<?php
session_start();

require_once('functions/functions_all.php');

$log_in_username = $_SESSION['valid_user'];

$id = get_user_id($_SESSION['valid_user']);

if(isset($_POST['profile_save'])) {
	$firstname = escape($_POST['firstname']);
	$lastname = escape($_POST['lastname']);
	$image = $_FILES['image'];
	$image_name = $_FILES['image']['name'];
	$del_img = $_POST['del_img'];
}

echo $del_img;

try {
	//if user don't have image and if he upload new image then put it to the database
	if($image['name'] !='') {
		valid_upload_file($image);
	}
	else if($image['name'] =='' && isset($del_img)) {
		$image_name = '';
	}
	else {
		//else : use old image from database
		$image_name = select_user_image($id);
	}

	add_profile_info($id, $firstname, $lastname, $image_name);

	$_SESSION['session_status'] = 'profile_update';
	header("location:../member.php");

}

catch(Exception $e) {
	echo "Wystapil problem: ".$e->getMessage();
	create_url("../member.php", "Powrot do strony czlonkowskiej");
	exit;
}
