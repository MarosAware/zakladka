<?php

require_once ('functions_all.php');

function escape($string) {
	$conn = connect();
	return $conn->real_escape_string(trim($string));
}

function empty_input($input) {
	//sprawdza input(array) pod wzgledem kluczy i wartosci, gdy klucze nie ustawione, lub wartosci puste zwraca false;
	foreach($input as $key => $value) {
		if((!isset($key) || empty($value))) {
			return false;
		}
	}
	return true;
}

function valid_email($email) {
	//jesli email jest prawidlowy oraz nie wystepuje w bazie danych
	if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
		if(!select_email($email)) {
			return true;
		}
	}

	return false;
}

function valid_url($url) {
	$url = filter_var($url, FILTER_SANITIZE_URL);
	$url = "http://".$url;
	if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
		return false;
	}
	return true;
}

function valid_username($username) {
	//jesli username nie wystepuje w bazie danych oraz zawiera tylko znaki alfanumeryczne
	//ctype_alnum wylaczone, poniewaz uzytkownik typu O'reilly nie moglby sie zarejestrowac
		if(!select_username($username) /*&& ctype_alnum($username)*/) {
			return true;
		}

	return false;
}

function login($username, $password) {
	$username = escape($username);
	$password = escape($password);

	$conn = connect();

	$query = "SELECT * FROM users WHERE user_name = '{$username}'";
	$result = $conn->query($query);

	if($result->num_rows > 0) {
		//output data 
		while($row = $result->fetch_assoc()) {
			$username_db = $row['user_name'];
			$password_db = $row['user_password'];
		}
	} else {
		throw new Exception("Nie znaleziono w bazie danych.");
		return false;
	}

	if(password_verify($password, $password_db)) {
		return true;
	} else {
		return false;
	}

}

function make_rand_pass() {
	$new = "";

	$dic = './dic.txt';

	$wp = @fopen($dic, 'rb');

	if(!$wp) {
		return false;
	}

	$len = filesize($dic);

  while ((strlen($new) < 6)) {
     if (feof($wp)) {
        fseek($wp, 0);//jesli koniec pliku przeskocz na poczatek
     }

     $rand = rand(0, $len); // randomowo wybiera pozycje od poczatku pliku do max(czyli jego dlugosci)
     fseek($wp, $rand); // przestawia za kazdym razem wewnetrzny wskaznik pliku
     $new .= fgetc($wp); //pobiera jeden znak z pliku i dodaje do $new 
  }
  $new = trim($new);
  return $new;

}


function valid_upload_file($file) {


$target_dir = "../includes/images/";
$target_file = $target_dir . basename($file["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image only when no errors
if($file['error'] == 0) {

//This function expects filename to be a valid image file. If a non-image file is supplied, it may be incorrectly detected as an image and the function will
//return successfully, but the array may contain nonsensical values.
//Do not use getimagesize() to check that a given file is a valid image. Use a purpose-built solution such as the Fileinfo extension instead.

//I used pathinfo() to check for valid extension file to be sure this is image file

    $check = getimagesize($file["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
        throw new Exception("Twoj plik nie jest zdjeciem!");
    }
} else {
	return false;
}
// Check if file already exists
// if (file_exists($target_file)) {
//     $uploadOk = 0;
//     throw new Exception("Twoje zdjecie juz istnieje!");
// }
// Check file size
if ($file["size"] > 5000000) {
    $uploadOk = 0;
    throw new Exception("Twoj plik jest za duzy!");
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
	$uploadOk = 0;
	throw new Exception("Tylko pliki JPG, JPEG, PNG & GIF dozwolone!");
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    throw new Exception("Twoje zdjecie nie zostalo dodane!");
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
       // echo "The file ". basename($file["name"]). " has been uploaded.";
    	return true;
    } else {
        //echo "Sorry, there was an error uploading your file.";
        throw new Exception("Dodanie zdjecia nie powiodlo sie!");
    }
}

}





?>