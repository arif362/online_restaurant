<?php
$dbhost = 'sql309.cuccfree.com';
$dbname = 'cucch_18266026_restaurant';
$dbuser = 'cucch_18266026';
$dbpass = 'cityrestaurant2016';

try {
	$db = new PDO("mysql:host={$dbhost};dbname={$dbname}",$dbuser,$dbpass);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch(PDOException $e) {
	echo "Connection error: ".$e->getMessage();
}
?>