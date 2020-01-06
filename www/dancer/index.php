<?php

require("../../main.php");

$title = "Dancer";
require("../head.php");

$id = $_GET['id'] ?? -1;
$id = (int) $id;


if($id === -1) {
	$dancers = Dancer::getAll();
	show_table($dancers);
} else {
	$dancer = new Dancer($id);
	$dancer_array = $dancer->export();
	show_table([$dancer_array]);
}
