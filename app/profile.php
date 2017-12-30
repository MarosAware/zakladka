<?php session_start(); 
require_once('includes/functions/functions_all.php'); 



if(is_login()) {
	$log_in_username = $_SESSION['valid_user'];
	?>

<!DOCTYPE html>
<html>
<head>
	<title>Witamy na stronie profilu</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<?php
		show_menu();
	?>
</head>
<body>
<header>
	<h1>Witamy na stronie profilu.</h1>
	<?php show_status_session(); ?>
	<h3>Tutaj mozesz uzupelnic swoje dane profilowe.</h3>
	<form action="includes/update_profile.php" method="post" enctype="multipart/form-data">
		<label for="username">Nazwa uzytkownika:</label><br>
		<?php echo $log_in_username."<br>"; ?>
		<br>

		<label for="firstname">Imie:</label><br>
		<input type="text" name="firstname" placeholder="Enter your firstname" maxlength="32" id="firstname"><br>
		<br>
		<label for="lastname">Nazwisko:</label><br>
		<input type="text" name="lastname" placeholder="Enter your lastname" maxlength="32" id="lastname"><br>
		<br>
		<?php
		$image = select_user_image(get_user_id($log_in_username));
		$image ? $image : $image = 'default.png';

		?>
		Twoje dotychczasowe zdjecie profilowe:<br>
		<img width="150" height="100" src='includes/images/<?php echo $image; ?>'><br>
		<br>

		<?php

		if($image != 'default.png') {
			?>
			<input type="checkbox" name="del_img">Usun zdjecie i ustaw domyslne.<br><br>
			<?php
		}

		?>
		<label for="file">Dodaj zdjecia profilowe:</label><br>
		<input type="file" name="image" id="file"><br>

		<?php
			// if(isset($_FILES['image']['name'])) {
			// 	echo "dodales zdjecie";
			// }

		?>
		<br>


		<input type="submit" name="profile_save" value="Zapisz">
	</form>
</header>

<!-- http://localhost/zakladka/app/index.php -->
</body>
</html>
<?php
}

