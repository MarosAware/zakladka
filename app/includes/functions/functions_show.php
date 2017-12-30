<?php

function create_url($url, $name) {
?>
<br><a href="<?php echo $url; ?>"><?php echo $name; ?></a></br>
<?php
}


function is_login() {
	if(isset($_SESSION['valid_user'])) {
		return true;
	} else {
		return false;
	}
}


function show_menu() {
	?>
		<nav>
		<a href="member.php">Home</a> |
		<a href="#">Placeholder</a> |
		<a href="profile.php">Moj profil</a> |
		<a href="./change_password_form.php">Zmien haslo</a> |
		<a href="includes/logout.php">Wyloguj</a>
		</nav>
	<?php
}


function show_status_session() {
	if(isset($_SESSION['session_status'])) {
		$ses = $_SESSION['session_status'];

		switch($ses) {
			case 'pass_change': 
			echo "<p class='status'>Haslo zostalo zmienione pomyslnie!</p>";
			unset($_SESSION['session_status']);
			break;

			case 'new_pass': 
			echo "<p class='status'>Zmieniono haslo pomyslnie. Zalecamy zmienic haslo na nowe po zalogowaniu!</p>";
			unset($_SESSION['session_status']);
			break;

			case 'logout': 
			echo "<p class='status'>Zostales pomyslnie wylogowany!</p>";
			unset($_SESSION['session_status']);
			break;

			case 'edit_url': 
			echo "<p class='status'>Twoja zakladka zostala zaktualizowana pomyslnie!</p>";
			unset($_SESSION['session_status']);
			break;

			case 'delete_url': 
			echo "<p class='status'>Twoja zakladka zostala usunieta pomyslnie!</p>";
			unset($_SESSION['session_status']);
			break;

			case 'delete_urls': 
			echo "<p class='status'>Twoje zakladki zostaly usuniete pomyslnie!</p>";
			unset($_SESSION['session_status']);
			break;


			case 'clone_url': 
			echo "<p class='status'>Twoja zakladka zostala sklonowana pomyslnie!</p>";
			unset($_SESSION['session_status']);
			break;

			case 'clone_urls': 
			echo "<p class='status'>Twoje zakladki zostaly sklonowane pomyslnie!</p>";
			unset($_SESSION['session_status']);
			break;

			case 'profile_update': 
			echo "<p class='status'>Twoj profil zaktualizowany pomyslnie!</p>";
			unset($_SESSION['session_status']);
			break;

			default:
			$_SESSION['session_status'] = NULL;
		}
	}

	
}


function show_add_form() {
	?>
		<h3>Dodaj zakladke:</h3>
				<!-- <form action="includes/add_url.php" method="post"> -->
				<form>
					<label for="url">URL Twojej zakladki:</label><br>
					<input type="text" name="input_url" placeholder="Enter your favorite URL!" value="http://" size="32" maxlength="32" id="url"><br>
					<label for="text">Opis:</label><br>
					<textarea rows='4' cols='30' name="input_opis" placeholder="Opis!" size="32" id="text"></textarea><br>
					<input type="button" name="add_url" value="Dodaj" onclick="add_new_url()"/>
				</form>
				<div id="demo"></div>
				<?php
}


function edit_url_form($zak_url, $zak_spec, $id) {
	?>
					<h3>Edytuj zakladke:</h3>
					<form action="includes/edit_url.php" method="post">
						<label for="url">URL Twojej zakladki:</label><br>
						<input type="text" name="url" placeholder="Enter your favorite URL!" value="<?php echo $zak_url; ?>" size="32" maxlength="32" id="url"><br>
						<label for="text">Opis:</label><br>
						<input type="hidden" name="url_id" value="<?php echo $id; ?>">
						<textarea rows='4' cols='30' name="opis" placeholder="Opis!" size="128" maxlength="128" id="text"><?php echo $zak_spec; ?></textarea><br>
						<input type="submit" name="edit_url" value="Edytuj">
					</form>
					<?php
}


function show_add_recom_form($zak_url) {
	?>
				<h3>Dodaj rekomendowana zakladke:</h3>
				<form>
					<label for="url">URL Twojej zakladki:</label><br>
					<input type="text" name="input_url" placeholder="Enter your favorite URL!" value="<?php echo $zak_url; ?>" size="32" maxlength="32" id="url"><br>
					<label for="text">Opis:</label><br>
					<textarea rows='4' cols='30' name="input_opis" placeholder="Opis!" size="128" maxlength="128" id="text"></textarea><br>
					<input type="button" name="add_url" value="Dodaj" onclick="add_new_url()"/>
				</form>
				<div id="demo"></div>
					<?php
}


function show_table_url($user) {
?>
	<table>
		<tr>
			<th><input id="selectAllBoxes" onClick="toggle(this)" type="checkbox">ALL</th>
			<th>MOJE ZAKLADKI</th>
			<th>OPIS</th>
			<th>EDYTUJ</th>
		</tr>

			<?php 
				//wywolany caly wynik zapytania
			 $result = take_url($user);

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
	<?php		
}


function show_operation() {
	?>
	<form action="", method="post">

		<div class="option">
			<h3>Wybierz operacje na zakladkach!</h3>
			<select name='option_action'>
				<option value='' id="select">Select Options</option>
				<option value='delete'>Delete</option>
				<option value='clone'>Clone</option>
			</select>

			<input type="submit" name="submit_action" value="Zatwierdz operacje!">
		</div>

	<?php
}

function edit_or_add_recom_form($source, $id) {

	$result = take_url_byid($id);
	while($row = $result->fetch_assoc()){
		$zak_url = $row['zak_url'];
		$zak_spec = $row['zak_spec'];
	}
	switch($source) {

		case 'edit_url':
		edit_url_form($zak_url, $zak_spec, $id);
		break;

		case 'add_url_recom':
		show_add_recom_form($zak_url);
		break;

	}
}


function show_recomendation_table($log_in_username) {
	$result = take_url_byid(recomendation(get_user_id($log_in_username)));

	if(!$result) {

		echo "<h3>Przepraszamy, nie znaleziono zadnych rekomendacji!</h3>";

	} else {

		while($row = $result->fetch_assoc()) {
			$recom_id = $row['url_id'];
			$recom_url = $row['zak_url'];

			?>

			<h2>Rekomendowane zakladki:</h2>
			
			<table>
				<tr>
					<th>REKOMENDOWANE ZAKLADKI</th>
					<th>DODAJ DO MOICH ZAKLADEK</th>
				</tr>


				<?php
				echo "<tr>";
				echo "<td><a href='{$recom_url}'>{$recom_url}</td>";
				echo "<td><a href='member.php?source=add_url_recom&url_id={$recom_id}'>DODAJ</td>";
				echo "</tr>";

			}

			?>
		</table>
		<?php
	}

}


function test() {
	try {

    // Find out how many items are in the table
    $total = $dbh->query('SELECT COUNT(*) FROM table')->fetchColumn();

    // How many items to list per page
    $limit = 20;

    // How many pages will there be
    $pages = ceil($total / $limit);

    // What page are we currently on?
    $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
        'options' => array(
            'default'   => 1,
            'min_range' => 1,
        ),
    )));

    // Calculate the offset for the query
    $offset = ($page - 1)  * $limit;

    // Some information to display to the user
    $start = $offset + 1;
    $end = min(($offset + $limit), $total);

    // The "back" link
    $prevlink = ($page > 1) ? '<a href="?page=1" title="First page">&laquo;</a> <a href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';

    // The "forward" link
    $nextlink = ($page < $pages) ? '<a href="?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';

    // Display the paging information
    echo '<div id="paging"><p>', $prevlink, ' Page ', $page, ' of ', $pages, ' pages, displaying ', $start, '-', $end, ' of ', $total, ' results ', $nextlink, ' </p></div>';

    // Prepare the paged query
    $stmt = $dbh->prepare('
        SELECT
            *
        FROM
            table
        ORDER BY
            name
        LIMIT
            :limit
        OFFSET
            :offset
    ');

    // Bind the query params
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    // Do we have any results?
    if ($stmt->rowCount() > 0) {
        // Define how we want to fetch the results
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $iterator = new IteratorIterator($stmt);

        // Display the results
        foreach ($iterator as $row) {
            echo '<p>', $row['name'], '</p>';
        }

    } else {
        echo '<p>No results could be displayed.</p>';
    }

} catch (Exception $e) {
    echo '<p>', $e->getMessage(), '</p>';
}
}



























?>

