<?php

session_start();

require_once('functions/functions_all.php');

if(isset($_POST['rejestracja'])) {
	$username = escape($_POST['username']);
	$email = escape($_POST['email']);
	$password = escape($_POST['password']);
	$password2 = escape($_POST['password2']);

}

$password_len = strlen($password);
$flag = true;


	if(!empty_input($_POST)) {
		$_SESSION['e_empty'] = "Wszystkie pola powinny byc wypelnione.";
		$flag = false;
	}

	if(!valid_email($email)) {
		$_SESSION['e_email'] = "Nieprawidlowy email lub email zajety, sproboj ponownie!";
		$flag = false;
	}

	if(!valid_username($username) || empty($username)) {
		$_SESSION['e_user'] = "Nazwa uzytkownika zajeta lub zawiera znaki niedozwolone, wybierz inna nazwe i sproboj ponownie!";
		$flag = false;
	}

	if($password_len < 6 || $password_len > 16) {
		$_SESSION['e_pass'] = "Haslo nie moze miec wiecej niz 16 znakow, oraz mniej niz 6 znakow. Sproboj ponownie!";
		$flag = false;
	}

	if($password !== $password2) {
		$_SESSION['e_pass2'] = "Niepasujace do siebie hasla. Sproboj ponownie!";
		$flag = false;
	}


	if($flag) {
		register_user($username, $email, $password);

		$_SESSION['valid_user'] = $username;

		header("location:../member.php");
	} else {
		header("location: rejestracja.php");
	}


?>
