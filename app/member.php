<?php

session_start();
require_once('includes/functions/functions_all.php');


if(isset($_SESSION['valid_user'])) {
	$log_in_username = $_SESSION['valid_user'];

} else {

	if(isset($_POST['login'])) {
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);

		try {

			if(!empty_input($_POST)) {
				throw new Exception("Wszystkie pola powinny byc wypelnione");
			}

			if(!select_username($username)) {
				throw new Exception("Nie znaleziono takiej nazwa uzytkownika, wybierz inna nazwe uzytkownika!");
			}

			if(login($username, $password)) {
				$_SESSION['valid_user'] = $username;
				$log_in_username = $_SESSION['valid_user'];
			}		
		}

		catch(Exception $e) {
			$_SESSION['login_error'] = "Problem: ".$e->getMessage()."<br/>";
			header("Location: index.php");
			exit();
		}
	} else {
		$_SESSION['login_error'] = "Aby ogladac strone członkowską musisz byc zalogowany!";
		header("Location: index.php");
		//echo "Aby ogladac ta strone członkowską musisz byc zalogowany!<br>";
	}
}


//jesli zaznaczony chociaz jeden checkbox(nalezy pamietac ze del_tab to tablica);
if(isset($_POST['del_tab'])) {

	$deltab = $_POST['del_tab'];

	foreach($deltab as $del_element_id) {

		//wybrana jedna z opcji w select
		$option = $_POST['option_action'];

		switch($option) {

			case 'delete':

				if(delete_url_byid($del_element_id)) {
					if(count($deltab) > 1)
						$_SESSION['session_status'] = 'delete_urls';
					 else 
						$_SESSION['session_status'] = 'delete_url';
				}
					
			break;

			case 'clone':

				if(clone_zak_url($del_element_id)) {
					if(count($deltab) > 1)
						$_SESSION['session_status'] = 'clone_urls';
					 else 
						$_SESSION['session_status'] = 'clone_url';
				}

			break;

		}
	}
}

?>





<!-- Begining of show everything -->


<!DOCTYPE html>
<html>
<head>
	<title>Strona czlonkowska.</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src='js/app.js'></script>
		<?php
			show_menu();
		?>
		<h1>Witamy na stronie czlonkowskiej. <?php echo "Zalogowano jako: ".stripslashes($log_in_username) ?></h1>
		<?php
			$image = select_user_image(get_user_id($log_in_username));
			$image ? $image : $image = 'default.png';
		?>
		<img width="280px" height="180px" src='includes/images/<?php echo $image; ?>'>
		<?php 
			show_status_session();
		?>
</head>
<body>



<!-- Add form or edit form -->
<?php

if(isset($_GET['source'])) {
	$source = $_GET['source'];
	$id = $_GET['url_id'];

	edit_or_add_recom_form($source, $id);
			
} else {
	show_add_form();

}

$limit = 3;

if(isset($_GET['page'])) {
	$curr = $_GET['page'];
	$page = $_GET['page'] * $limit;
} else {
	$curr = 0;
	$page = 0;
}


//reload page after 4,5 sec when xmlhttp request is done

?>
<script type="text/javascript">
	// var id2 = document.getElementsByName('add_url')[0];
	
	// 	id2.addEventListener("click", ifclick);

	// 	function ifclick() {
	// 		setTimeout(function() {
	// 			location.reload();
	// 		}, 4500);
	// 	}

</script>


<!-- main table url + operation form -->

<?php show_operation(); ?>
<?php //show_table_url($log_in_username); 


?>
	<table>
		<tr>
			<th><input id="selectAllBoxes" onClick="toggle(this)" type="checkbox">ALL</th>
			<th>MOJE ZAKLADKI</th>
			<th>OPIS</th>
			<th>EDYTUJ</th>
		</tr>

			<?php 
				
			$num_row = take_url_num_row($log_in_username);

			//wywolany caly wynik zapytania
			$result = take_url($log_in_username, $page, $limit);

			 

			while($row = $result->fetch_assoc()) {
				$url_id = $row['url_id'];
				$user_url_id = $row['user_url_id'];
				$zak_url = $row['zak_url'];
				$zak_spec = $row['zak_spec'];

				echo "<tr>";
				?>
		<td><input type='checkbox' name='del_tab[]' value='<?php echo $url_id; ?>'></td>

		<?php
				echo "<td><a href='{$zak_url}'>{$zak_url}</td>";
				echo "<td>{$zak_spec}</td>";
				echo "<td><a href='member.php?source=edit_url&url_id={$url_id}'>EDYTUJ</td>";
				//echo "<td><a href='member.php?delete={$url_id}'>DELETE</td>";
				//echo "<td><input type='checkbox' name='del_tab[]' value='$url_id'></td>";

				echo "</tr>";
			}

			?>
	</table>
			
</form>

	<div class="pagination">
					
				
		<?php
			$all = ceil($num_row/$limit);

			// if($page == 0) {
			// 	echo "<a href='member.php' class='active'>1</a>";
			// } else {

			// }
			for($i = 0; $i<$all; $i++) {

				if($i == $curr) {
					?>
					<a id='pager' class='active' href='member.php?page=<?php echo $i;?>'><?php echo $i+1; ?></a>
					<?php

				} else {
					?>
					<a id='pager' href='member.php?page=<?php echo $i;?>'><?php echo $i+1; ?></a>

					<?php
				}

				?>
				<!-- <a id='pager' href='member.php?page=<?php// echo $i;?>' onclick='active(this)'><?php //echo $i+1; ?></a> -->

				<?php
			}

		?>

		</div>


	<?php	








?>



<!-- recommendation table -->
<?php show_recomendation_table($log_in_username);?>


</body>
</html>


