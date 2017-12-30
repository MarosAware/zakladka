<?php
session_start();

require_once('functions/functions_all.php');

if(isset($_POST['newpass'])) {
	$oldpassword = $_POST['oldpassword'];
	$newpassword = $_POST['password'];
	$newpassword2 = $_POST['password2'];
}

$password_len = strlen($newpassword);
$username = $_SESSION['valid_user'];
$flag = true;


	if(!empty_input($_POST)) {
		$_SESSION['e_empty'] = "Wszystkie pola powinny byc wypelnione.";
		$flag = false;
	}

	if($password_len < 6 || $password_len > 16) { 
		$_SESSION['e_pass'] = "Haslo nie moze miec wiecej niz 16 znakow, oraz mniej niz 6 znakow. Sproboj ponownie!";
		$flag = false;
	}


	if(!login($username, $oldpassword)) {
		$_SESSION['e_log'] = "Niepasujace stare haslo!";
		$flag = false;
	}


	if($newpassword !== $newpassword2) {
		$_SESSION['e_pass2'] = "Niepasujace do siebie nowe hasla. Sproboj ponownie!";
		$flag = false;
	}

	if($flag) {
		if(!set_new_password($username, $newpassword)) {
			$_SESSION['e_pass3'] = "Zmiana hasla niemozliwa. Nie mozna ustawic nowego hasla. Sproboj ponownie pozniej!";
			$flag = false;
		}
	}

	if($flag) {
		$_SESSION['session_status'] = "pass_change";
		header("location:../member.php");
	} else {
		header("Location: ../change_password_form.php");
	}

?>