<?php session_start(); 
require_once('includes/functions/functions_all.php'); 

?>

<!DOCTYPE html>
<html>
<head>
	<title>Witamy na stronie domowej</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<header>
	<h1>Witamy na stronie domowej.</h1>
	<?php show_status_session(); ?>
	<h2>Zakładka to aplikacja dzięki której masz wszystkie swoje ulubione strony w jednym miejscu!</h2>
	<h3>Logowanie:</h3>
	<form action="member.php" method="post">
		<label for="username">Nazwa uzytkownika:</label><br>
		<input type="text" name="username" placeholder="Enter your username" size="16" maxlength="16" id="username"><br>
		<label for="password">Haslo:</label><br>
		<input type="password" name="password" placeholder="Enter your password" size="16" maxlength="16" id="password"><br>
		<br>
		<input type="submit" name="login" value="Zaloguj">
	</form>
	<?php
	if(isset($_SESSION['login_error']))
		echo '<p style= "color:red">'.$_SESSION['login_error']." </p>";
	$_SESSION['login_error'] = NULL;

	?>

	<br>
	<a href="recover_password_form.php">Zapomnialem hasla</a>
	<p>Nie masz jeszcze konta?</p>
	<a href="includes/rejestracja.php">Rejestracja</a>
</header>

<!-- http://localhost/zakladka/app/index.php -->


</body>
</html>