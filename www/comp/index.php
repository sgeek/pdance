<?php

require("../../main.php");

$title = "Comp";
require("../head.php");

$id = $_GET['id'] ?? -1;
$id = (int) $id;

if($id === -1) {
	echo "<b><a href='add.php'>Add</a></b><br /><br />";
	$comps = Comp::getAll();
	show_table($comps);
} else {
	$comp = new Comp($id);
	$comp_array = $comp->export();
	show_table([$comp_array]);
}
