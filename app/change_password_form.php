<?php
session_start();

require_once('includes/functions/functions_all.php');


if(is_login()) {
	$log_in_username = $_SESSION['valid_user'];
	?>

	<!DOCTYPE html>
<html>
<head>
	<title>Zmiana hasla</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<?php
		show_menu();
	?>
</head>
<body>
<header>
	<h1>Witamy na stronie zmiany hasla.</h1>
	<h2><?php echo "Zalogowano jako: ".$log_in_username ?></h2>
	<h3>Zmiana hasla:</h3>

	<form action="includes/change_password.php" method="post">
		<label for="oldpassword">Stare Haslo</label><br>
		<input type="password" name="oldpassword" placeholder="Enter your password" size="16" maxlength="16" id="oldpassword"><br>

		<?php
			if(isset($_SESSION['e_log'])) {
				echo '<p class="error">'.$_SESSION['e_log'].'</p>';
				unset($_SESSION['e_log']);
			}
			
		?>

		<label for="password">Nowe haslo:(6-16 znakow)</label><br>
		<input type="password" name="password" placeholder="Enter your password" size="16" maxlength="16" id="password"><br>

			<?php
			if(isset($_SESSION['e_pass'])) {
				echo '<p class="error">'.$_SESSION['e_pass'].'</p>';
				unset($_SESSION['e_pass']);
			}
			
		?>

		<label for="password2">Powtorz nowe haslo:</label><br>
		<input type="password" name="password2" placeholder="Enter your password" size="16" maxlength="16" id="password2"><br>

			<?php
			if(isset($_SESSION['e_pass2'])) {
				echo '<p class="error">'.$_SESSION['e_pass2'].'</p>';
				unset($_SESSION['e_pass2']);
			}
			
		?>
		<input type="submit" name="newpass" value="Zmien haslo">

		<?php
		if(isset($_SESSION['e_empty'])) {
			echo '<p class="error">'.$_SESSION['e_empty'].'</p>';
			unset($_SESSION['e_empty']);
		}

		if(isset($_SESSION['e_pass3'])) {
			echo '<p class="error">'.$_SESSION['e_pass3'].'</p>';
			unset($_SESSION['e_pass3']);
		}

		?>
	</form>
</header>

</body>
</html>
<?php
}
?>

