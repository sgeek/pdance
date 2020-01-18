<?php

require("../../main.php");

$title = "Entry";
require("../head.php");

$id = $_GET['id'] ?? -1;
$id = (int) $id;

$columns = [
	'id' => 'ID',
	'compName' => 'Comp',
	'eventName' => 'Event',
	'levelCode' => 'Level',
	'leadName' => 'Lead',
	'followName' => 'Follow',
	'otherName' => 'Other'
];

if($id === -1) {
	$entries = Entry::getAll();
	show_table($entries, $columns);
} else {
	$entry = new Entry($id);
	$entry_array = $entry->export();
	show_table([$entry_array], $columns);
}
