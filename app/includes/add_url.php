<?php
session_start();

require_once('functions/functions_all.php');

if(isset($_POST['add_url'])) {
	$new_url = $_POST['url'];
	$url_desc = htmlspecialchars($_POST['opis']);
	$url_desc = escape($_POST['opis']);
	$username = $_SESSION['valid_user'];

	$id = get_user_id($username);

	//try {
	$flag = true;

		if(!is_login()) {
			//throw new Exception("Musisz byc zalogowany aby dodac zakladke!");
			echo '<p class="error">Musisz byc zalogowany aby dodac zakladke!';
			$flag = false;
		}

		if($flag && !empty_input($_POST)) {
			//throw new Exception("Wszystkie pola powinny byc wypelnione");
			echo '<p class="error">Wszystkie pola powinny byc wypelnione<br/>';
			$flag = false;
		}

		// if (!valid_url($new_url)) {
		// 	throw new Exception('URL nieprawidlowy. Sproboj ponownie!');
		// }
		if($flag) {
		 if (!(@fopen($new_url, 'r')) || (filter_var($new_url, FILTER_VALIDATE_URL) === FALSE)) {
      		 //throw new Exception('Nieprawidlowy URL.');
		 	echo '<p class="error">Nieprawidlowy URL.';
		 	$flag = false;
   		 }
   		}

		if($flag) {
			add_url($new_url, $url_desc, $id);
			
			//header("Location: ../member.php");
		}

//}
	// catch(Exception $e) {
	// 	echo "Wystapil problem: ".$e->getMessage();
	// }
}














?>