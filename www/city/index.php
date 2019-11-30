<?php

require("../../main.php");

$id = $_GET['city'] ?? 0;

$id = (int) $id;


if($id === 0) {
	$cities = City::getAll();
	var_dump($cities);
	echo " all ";
} else {
	$city = new City($id);
	var_dump($city);
	echo " one ";
}

