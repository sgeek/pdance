<?php

require("model/city.php");
require("model/dancer.php");

require("config/credentials.php");

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$GLOBALS['pdo'] = $pdo;

function show_table($data) {
	if(!is_array($data) || !is_array(array_values($data)[0])) return false;
	echo "<table><tr>";
	$keys = array_keys(array_values($data)[0]);
	foreach($keys as $key) {
		echo "<th>{$key}</th>";
	}
	echo "</tr>\n";
	foreach($data as $row){
		echo "<tr>";
		foreach($row as $cell){
			echo "<td>{$cell}</td>";
		}
		echo "</tr>\n";
	}
	
	return true;
}