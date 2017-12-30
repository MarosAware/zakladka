<?php ob_start();


$db['db_host'] = 'localhost';
$db['db_user'] = 'root';
$db['db_pass'] = '';
$db['db_name'] = 'zakladka';


foreach($db as $key => $value) {
	define(strtoupper($key), $value);
}
//Throw mysqli_sql_exception for errors instead of warnings
//mysqli_report(MYSQLI_REPORT_STRICT);

function connect() {
	$result = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$result->set_charset("utf8");
	if($result->connect_errno != 0) {
		throw new Exception("Polaczenie z baza danych nie powiodlo sie!");
	} else {
		return $result;
	}
}




?>