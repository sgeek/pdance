<?php

require("../../main.php");

$title = "Video permissions";
require("../head.php");

$columns = [
//	'id' => 'ID',
	'compName' => 'Comp',
	'code' => 'Code',
	'levelCode' => 'Lvl',
	'eventName' => 'Event',
	'roundName' => 'Round',
	'performanceType' => 'Type',
	'leadName' => 'Lead',
	'followName' => 'Follow',
	'otherName' => 'Other',
//	'heat' => 'Heat',
	'linkMarkup' => 'YouTube',
	'seconds' => 'Sec',
	'permLeadDisplay' =>'pL',
	'permFollowDisplay' =>'pF',
	'permOtherDisplay' =>'pO',
	'aaa' =>'Fin',
//	'note' => 'Note',
];

echo "<b><a href='add.php'>Add</a></b><br /><br />";
$videos = Video::getAll($_GET);
foreach($videos as $id => $video){
	$pl = $video['perm_lead'];
	$videos[$id]['permLeadDisplay'] = Video::$permissions[$pl];
	$pf = $video['perm_follow'];
	$videos[$id]['permFollowDisplay'] = Video::$permissions[$pf];
	$po = $video['perm_other'];
	$videos[$id]['permOtherDisplay'] = Video::$permissions[$po];
	
	$videos[$id]['aaa'] = "<a href='?comp={$video['comp']}&video={$video['id']}&pl=1'>AAA</a>";
}
show_table($videos, $columns);
