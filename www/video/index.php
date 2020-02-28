<?php

require("../../main.php");

$title = "Pat's MJ Comp Videos";
require("../head.php");

$id = $_GET['id'] ?? -1;
$id = (int) $id;

$columns = [
//	'id' => 'ID',
	'compName' => 'Comp',
	'code' => 'Code',
	'levelCode' => 'Lvl',
	'eventName' => 'Event',
	'roundName' => 'Round',
	'performance_type_name' => 'Type',
	'leadName' => 'Lead',
	'followName' => 'Follow',
	'otherName' => 'Other',
//	'heat' => 'Heat',
	'linkMarkup' => 'YouTube',
	'seconds' => 'Sec',
//	'note' => 'Note',
];

if($id === -1) {
	echo "<b><a href='add.php'>Add</a></b><br /><br />";
	$videos = Video::getAll($_GET);
	show_table($videos, $columns);
} else {
	$video = new Video($id);
	$video_array = $video->export();
	show_table([$video_array], $columns);
}
