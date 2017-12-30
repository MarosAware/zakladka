<?php
	session_start();
	unset($_SESSION['valid_user']);
	session_destroy();
	session_start();
	$_SESSION['session_status'] = 'logout';

	header('Location: ../index.php');

	

?>