<?php
session_start();

require_once('functions/functions_all.php');

if(isset($_POST['zmien'])) {
	$username = $_POST['username'];

	if(select_username($username)) {
		if(set_new_rand_password($username)) {
			$_SESSION['session_status'] = 'new_pass';
			create_url("../index.php", "Strona logowania");
		}
	} else {
		echo "Podany uzytkownik nie istnieje w bazie danych!";
	}

	
}


?>