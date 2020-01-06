<?php

require("../../main.php");

$title = "Level";
require("../head.php");

$id = $_GET['id'] ?? 0;
$id = (int) $id;


if($id === 0) {
	$levels = Level::getAll();
	show_table($levels);
} else {
	$level = new Level($id);
	$level_array = $level->export();
	show_table([$level_array]);
}
