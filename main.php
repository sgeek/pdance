<?php

require("model/city.php");
require("model/dancer.php");
require("model/comp.php");
require("model/school.php");
require("model/event.php");
require("model/level.php");
require("model/performanceType.php");
require("model/round.php");
require("model/entry.php");
require("model/video.php");

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

function show_table($data, $columns=[]) {
	if(!is_array($data) || !$data || !is_array(array_values($data)[0])) {
    echo "Error: Cannot display table<br />\n";
    return false;
  }
	echo "<table><tr>";

	//If columns aren't specified, use array keys instead
	if(!$columns) {
		$columns = array_keys(array_values($data)[0]); // get column headings (key names from the first row of data)
	}

	//Display table headings
	foreach($columns as $key => $name) {
		echo "<th>{$name}</th>";
	}
	echo "</tr>\n";
	foreach($data as $row){
		echo "<tr>";
		foreach($columns as $key => $name){
			if(is_numeric($key)) $key = $name;
      $value = $row[$key] ?? "";
			echo "<td>{$value}</td>";
		}
		echo "</tr>\n";
	}

	return true;
}
