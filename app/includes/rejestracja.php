<?php
	
	session_start();

?>


<!DOCTYPE html>
<html>
<head>
	<title>Rejestracja</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<header>
	<h1>Witamy na stronie rejestracji.</h1>
	<h3>Rejestracja</h3>

	<form action="nowa_rejestracja.php" method="post">
		<label for="username">Nazwa uzytkownika(max 16 znakow):</label><br>
		<input type="text" name="username" placeholder="Enter your username" size="16" maxlength="16" id='username'><br>
		<?php
			if(isset($_SESSION['e_user'])) {
				echo '<p class="error">'.$_SESSION['e_user'].'</p>';
				unset($_SESSION['e_user']);
			}
			
		?>
		<br>
		<label for="email">Email:</label><br>
		<input type="email" name="email" placeholder="Enter your email" size="30" maxlength="100" id="email"><br>
		<?php
			if(isset($_SESSION['e_email'])) {
				echo '<p class="error">'.$_SESSION['e_email'].'</p>';
				unset($_SESSION['e_email']);
			}
			
		?>
		<br>

		<label for="password">Haslo(6-16 znakow):</label><br>
		<input type="password" name="password" placeholder="Enter your password" size="16" maxlength="16" id="password"><br>


		<?php
			if(isset($_SESSION['e_pass'])) {
				echo '<p class="error">'.$_SESSION['e_pass'].'</p>';
				unset($_SESSION['e_pass']);
			}
			
		?>
		<br>
		<label for="password2">Powtorz haslo:</label><br>
		<input type="password" name="password2" placeholder="Enter your password" size="16" maxlength="16" id="password"><br>


		<?php
			if(isset($_SESSION['e_pass2'])) {
				echo '<p class="error">'.$_SESSION['e_pass2'].'</p>';
				unset($_SESSION['e_pass2']);
			}
			
		?>
		<br>
		<input type="submit" name="rejestracja" value="Zarejestruj"><br><br>

		<?php
			if(isset($_SESSION['e_empty'])) {
				echo '<p class="error">'.$_SESSION['e_empty'].'</p>';
				unset($_SESSION['e_empty']);
			}
			
		?>
	</form>

	<a href="../index.php">Powrot do strony logowania.</a>
</header>

</body>
</html>