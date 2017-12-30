<?php
session_start();

require_once('functions/functions_all.php');

if(isset($_POST['edit_url'])) {
	$new_url = $_POST['url'];
	$id = $_POST['url_id'];
	$url_desc = escape($_POST['opis']);
	$username = $_SESSION['valid_user'];


	try {

		if(!is_login()) {
			throw new Exception("Musisz byc zalogowany aby dodac zakladke!");
		}

		if(!empty_input($_POST)) {
			throw new Exception("Wszystkie pola powinny byc wypelnione");
		}

		// if (!valid_url($new_url)) {
		// 	throw new Exception('URL nieprawidlowy. Sproboj ponownie!');
		// }

		 if (!(@fopen($new_url, 'r')) || (filter_var($new_url, FILTER_VALIDATE_URL) === FALSE)) {
      		 throw new Exception('Nieprawidlowy URL.');
   		 }

		if(edit_url($new_url, $url_desc, $id)) {
			$_SESSION['session_status'] = 'edit_url';
			header("Location: ../member.php");
		}

}
	catch(Exception $e) {
		echo "Wystapil problem: ".$e->getMessage();
	}
}