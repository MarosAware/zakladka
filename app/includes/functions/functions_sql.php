<?php 


require_once ('functions_all.php');

function select_email($email) {
	$conn = connect();
	$query = "SELECT * FROM users WHERE user_email = '{$email}' ";

	$result = $conn->query($query);

	if($conn->connect_error) {
		die("Connection failed ". $conn->connect_error);
	} else {
		if($result->num_rows > 0) {
			$conn->close();
			return true;
		}
	}
	$conn->close();
	return false;
}

function select_username($username) {
	// $conn = connect();
	// $query = "SELECT * FROM users WHERE user_name = '{$username}' ";
	
	// $result = $conn->query($query);

	// if($conn->connect_error) {
	// 	die("Connection failed ". $conn->connect_error);
	// } else {
	// 	if($result->num_rows > 0) {
	// 		return true;
	// 	}
	// }
	// return false;
	//<script>alert('hacked');</script>

	$username = escape($username);
	$conn = connect();
	$stmt = $conn->prepare("SELECT * FROM users WHERE user_name = ?");

	$stmt->bind_param("s", $username);
	$stmt->execute();
	$result = $stmt->get_result();

	//$result = $conn->query($query);

	if($conn->connect_error) {
		die("Connection failed ". $conn->connect_error);
	} else {
		if($result->num_rows > 0) {
			$conn->close();
			return true;
		}
	}
	$conn->close();
	return false;
}

function register_user($username, $email, $password) {
	$conn = connect();

	$password = password_hash($password, PASSWORD_DEFAULT, array('cost'=> 10));

	$query = "INSERT INTO users(user_name, user_password, user_email) VALUES('{$username}', '{$password}', '{$email}')";
	$result = $conn->query($query);

	if(!$result) {
		throw new Exception("Rejestracja w bazie danych nie mozliwa, sprobuj ponownie pozniej! " . $conn->connect_error);
	}
	$conn->close();
	return true;
}


function set_new_rand_password($username) {
	$new = make_rand_pass();

	if(!$new) {
		throw new Exception("Zmiana hasla niemozliwa. Sproboj ponownie pozniej.");
	}

	$conn = connect();

	$password = password_hash($new, PASSWORD_DEFAULT, array('cost'=> 10));
	$query = "UPDATE users SET user_password = '{$password}' WHERE user_name = '{$username}'";

	$result = $conn->query($query);

	if(!$result) {
		throw new Exception("Zmiana hasla nie powiodla sie! " . $conn->connect_error);
	} else {
		echo "Zmiana hasla nastapila pomyslnie! Twoje nowe haslo przy logowaniu to: ".$new."<br>"."Po zalogowaniu zmien haslo!";
	}

	$conn->close();
	return true;
}



function set_new_password($username, $password) {
	$conn = connect();

	$password = password_hash($password, PASSWORD_BCRYPT, array('cost'=> 10));
	$query = "UPDATE users SET user_password = '{$password}' WHERE user_name = '{$username}'";

	$result = $conn->query($query);

	if(!$result) {
		//throw new Exception("Zmiana hasla nie powiodla sie! " . $conn->connect_errno);
		return false;
	} else {
		return true;
	}
	$conn->close();
}

function get_user_id($username) {
	$conn = connect();
	$query = "SELECT user_id FROM users WHERE user_name = '{$username}' ";
	
	$result = $conn->query($query);

	if($conn->connect_error) {
		die("Connection failed ". $conn->connect_error);
	} 
	if($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$user_id = $row['user_id'];
		$conn->close();
		return $row['user_id'];
	}
	$conn->close();
	return false;
		
}




function add_url($url, $desc, $user_id) {


	$conn = connect();

	//sprawdzenie czy istnieje juz taka zakladka
	$query = "SELECT * FROM zakladki WHERE user_url_id = '{$user_id}' AND zak_url = '{$url}' ";

	$result = $conn->query($query);

	if($result && $result->num_rows > 0) {
		// throw new Exception("Podana zakladka juz istnieje.");
		echo '<p class="error">Podana zakladka juz istnieje.';
		print_r($result);
	} else {
		$query2 = "INSERT INTO zakladki (user_url_id, zak_url, zak_spec) VALUES ('{$user_id}', '{$url}', '{$desc}')";

		$result2 = $conn->query($query2);

		if(!$result2) {
		//throw new Exception("Wstawienie nowej zakladki nie powiodlo sie!". $conn->connect_error);
			echo '<p class="error">Wstawienie nowej zakladki nie powiodlo sie!'. $conn->connect_error;
		} else {
			echo "<p class='status'>Twoja nowa zakladka zostala dodana pomyslnie!</p>";
		}
	}

	//jesli nie istnieje dodaj nowa zakladke


	$conn->close();
	return true;
}


function edit_url($url, $desc, $url_id) {

	$conn = connect();

	//jesli nie istnieje dodaj nowa zakladke

	$query2 = "UPDATE zakladki SET zak_url = '{$url}', zak_spec = '{$desc}' WHERE url_id = {$url_id}";

	$result2 = $conn->query($query2);

	if(!$result2) {
		throw new Exception("Edytowanie zakladki nie powiodlo sie!". $conn->connect_error);
		$conn->close();
	}
	$conn->close();
	return true;
}

function take_url_num_row($username) {
	$user_id = get_user_id($username);

	$conn = connect();

	$query = "SELECT * FROM zakladki WHERE user_url_id = '{$user_id}'";

	$result = $conn->query($query);

	if(!$result) {
		return false;
	} else {
		return $result->num_rows;
	}
	//zwraca caly wynik zapytania
	$conn->close();


	// while($row = $result->fetch_row()) {
	// 	$zak_url[] = $row;
	// 	// $url_id = $row['url_id'];
	// 	// $user_url_id = $row['user_url_id'];
	// 	// $zak_url = $row['zak_url'];
	// 	// $zak_spec = $row['zak_spec'];
	// }

	// return $zak_url;

}

function take_url($username, $page, $limit) {
	$user_id = get_user_id($username);

	$conn = connect();

	$query = "SELECT * FROM zakladki WHERE user_url_id = '{$user_id}' LIMIT $page, $limit";

	$result = $conn->query($query);

	if(!$result) {
		return false;
	}
	//zwraca caly wynik zapytania
	$conn->close();
	return $result;

	// while($row = $result->fetch_row()) {
	// 	$zak_url[] = $row;
	// 	// $url_id = $row['url_id'];
	// 	// $user_url_id = $row['user_url_id'];
	// 	// $zak_url = $row['zak_url'];
	// 	// $zak_spec = $row['zak_spec'];
	// }

	// return $zak_url;

}

function take_url_byid($url_id) {
	if($url_id === false) {
		return false;
	}

	$conn = connect();

	$query = "SELECT * FROM zakladki WHERE url_id = '{$url_id}'";

	$result = $conn->query($query);

	if(!$result) {
		throw new Exception("Nie mozna wykonac zapytania". $conn->connect_error);
		return false;
	}
	//zwraca caly wynik zapytania
	$conn->close();
	return $result;
}


function delete_url_byid($url_id) {
	$conn = connect();

	$query = "DELETE FROM zakladki WHERE url_id = '{$url_id}'";

	$result = $conn->query($query);

	if(!$result) {
		throw new Exception("Nie mozna usunac zakladki. Sproboj ponownie pozniej!". $conn->connect_error);
		$conn->close();
		return false;
	}
	
	$conn->close();
	return true;
}

function recomendation($user_id, $pop = 1) {								//    |
	$conn = connect();														//    |
	//wybieramy wszystkie zakladki uzywajac user_id pochodzacego z podzapytania - V (w pierwszym nawiasie).
	//Pierwszy nawias(podzapytanie) uzywa select distinct(czyli wybiera roznice, cos bez powtorzen) a wiec wybiera takich innych uzytkownikow (z2.user_url_id)
	//z tabeli zakladki z1 i tabeli z2 (zastosowano tu aliasy i polaczono tabele do samej siebie, jakgdyby byly dwoma oddzielnymi tabelami) gdzie uzytkownik z1 
	// jest uzytkownikiem dla ktorego szukamy innych uzytkownikow, oraz oczywiscie, uzytkownik z1 nie jest uzytkownikiem szukanym.
	// Nastepnie zaznaczamy aby nie byly to zakladki ktore juz sa w posiadaniu uzytkownika dla ktorego szukamy, a na koncu grupujemy te zakladki po przez ilosc
	// wystepowania u innych uzytkownikow(zlicza czestosc wystepowania danej zakladki, jesli np. jakas zakladka jest u 3 uzytkownikow, to count = 3) i oferuje 
	// takie zakladki ktorych wystepowanie jest wieksze od zmiennej $pop.
	$query = "SELECT url_id FROM zakladki WHERE user_url_id IN 

																(SELECT DISTINCT(z2.user_url_id)
																FROM zakladki z1, zakladki z2 WHERE z1.user_url_id='{$user_id}' 
																AND z1.user_url_id != z2.user_url_id)

											AND zak_url NOT IN 

																(SELECT zak_url FROM zakladki WHERE user_url_id = '{$user_id}')

											GROUP BY zak_url HAVING count(zak_url)>".$pop;
	
	if(!($result = $conn->query($query))) {
		throw new Exception("Nie znaleziono zadnych rekomendowanych zakladek.");
		$conn->close();
	}

	if($result->num_rows == 0) {
		$conn->close();
		return false;
	}

	while($row = $result->fetch_assoc()) {
		$url_id = $row['url_id'];
	}
	$conn->close();
	return $url_id;
}

function clone_zak_url($url_id) {
	$url_id = escape($url_id);
	$conn = connect();

	$query = "SELECT * FROM zakladki WHERE url_id = '{$url_id}'";
	$result = $conn->query($query);

	while($row = $result->fetch_array()) {
		$user_url_id = $row['user_url_id'];
		$zak_url = $row['zak_url'];
		$zak_spec = $row['zak_spec'];
	}

	$query2 = "INSERT INTO zakladki(user_url_id, zak_url, zak_spec) VALUES('{$user_url_id}','{$zak_url}','{$zak_spec}')";
	$result2 = $conn->query($query2);

	if(!$result || !$result2) {
		throw new Exception("Nie mozna wykonac zapytania". $conn->connect_error);
		$conn->close();
		return fale;
	}
	
	$conn->close();
	return true;
}

function add_profile_info($user_id, $firstname, $lastname, $image) {

	$conn = connect();

	$query = "UPDATE users SET user_firstname = '{$firstname}', user_lastname = '{$lastname}', user_image = '{$image}' WHERE user_id = $user_id";

	$result = $conn->query($query);

	if(!$result) {
		throw new Exception("Nie mozna uzupelnic profilu uzytkownika!". $conn->connect_error);
		$conn->close();
		return false;
	}
	$conn->close();
	return true;
}

function select_user_image($user_id) {
	$conn = connect();
	settype($user_id, "int");
	($user_id < 0) ? $user_id = 0 : $user_id;

	$stmt = $conn->prepare("SELECT user_image FROM users WHERE user_id = ?");
	$stmt->bind_param("i", $user_id);
	$stmt->execute();
	$result = $stmt->get_result();

	if($result->num_rows > 0) {
		$image = $result->fetch_row();
		$conn->close();
		return $image[0];
	}

	$stmt->close();
	return false;



	






	// $conn = connect();

	// $query = "SELECT user_image FROM users WHERE user_id = $user_id ";

	// $stmt = $conn->prepare("SELECT user_image FROM users WHERE user_id = ?")


	// $result = $conn->query($query);
	

	// if($result->num_rows > 0) {
	// 	$image = $result->fetch_row();
	// 	return $image[0];
	// }

	// return false;
	
}




?>