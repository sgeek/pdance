<?php

require("../../main.php");

$title = "City";
require("../head.php");

$id = $_GET['id'] ?? -1;
$id = (int) $id;


if($id === -1) {
	$cities = City::getAll();
	show_table($cities);
} else {
	$city = new City($id);
	$city_array = $city->export();
	show_table([$city_array]);
}
