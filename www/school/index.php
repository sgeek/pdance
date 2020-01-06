<?php

require("../../main.php");

$title = "School";
require("../head.php");

$id = $_GET['id'] ?? 0;
$id = (int) $id;


if($id === 0) {
	$schools = School::getAll();
	show_table($schools);
} else {
	$school = new School($id);
	$school_array = $school->export();
	show_table([$school_array]);
}
