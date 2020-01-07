<?php

require("../../main.php");

$title = "Performance Type";
require("../head.php");

$id = $_GET['id'] ?? -1;
$id = (int) $id;


if($id === -1) {
	$performanceTypes = PerformanceType::getAll();
	show_table($performanceTypes);
} else {
	$performanceType = new PerformanceType($id);
	$performanceType_array = $performanceType->export();
	show_table([$performanceType_array]);
}
