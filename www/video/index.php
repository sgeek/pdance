<?php

require("../../main.php");

$title = "Video";
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
	'otherName' => 'Other',
	'roundName' => 'Round',
	'heat' => 'Heat',
	'performanceType' => 'Type',
	'seconds' => 'Duration',
	'code' => 'Timecode',
	'linkMarkup' => 'YouTube',
	'note' => 'Note',
];

if($id === -1) {
	$videos = Video::getAll();
	show_table($videos, $columns);
} else {
	$video = new Video($id);
	$video_array = $video->export();
	show_table([$video_array], $columns);
}
