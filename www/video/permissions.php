<?php

require("../../main.php");

$title = "Video permissions";
require("../head.php");

$colorMatrix = [
	-1 => "lightcoral",
	0 => "lightsteelblue",
	1 => "lightgreen",
	2 => "aquamarine"
];


// ==================
// == Form handler ==
// ==================

if(isset($_GET['video'])){
	$video = new Video($_GET['video']);
	$column = $_GET['column'] ?? '';
	$value = $_GET['value'] ?? -2;
	$video->updatePermission($column, $value);
	header("Location: ?comp={$_GET['comp']}");
}


// ==================
// == Form display ==
// ==================

$columns = [
//	'id' => 'ID',
	'compName' => 'Comp',
	'code' => 'Code',
	'levelCode' => 'Lvl',
	'eventName' => 'Event',
	'roundName' => 'Round',
	'performanceType' => 'Type',
	'leadName' => 'Lead',
	'permLeadDisplay' =>'permLead',
	'followName' => 'Follow',
	'permFollowDisplay' =>'permFollow',
	'otherName' => 'Other',
	'permOtherDisplay' =>'permOther',
//	'heat' => 'Heat',
	'linkMarkup' => 'YouTube',
	'seconds' => 'Sec',
//	'aaa' =>'Fin',
//	'note' => 'Note',
];

echo "<b><a href='add.php'>Add</a></b><br /><br />";
$videos = Video::getAll($_GET);
foreach($videos as $id => $video){
	// Set up permission display/update
	$pl = $video['perm_lead'];
	$videos[$id]['permLeadDisplay'] = getPermissionMarkup($video['comp'], $video['id'], 'pl', $pl);
	$pf = $video['perm_follow'];
	$videos[$id]['permFollowDisplay'] = getPermissionMarkup($video['comp'], $video['id'], 'pf', $pf);
	$po = $video['perm_other'];
	$videos[$id]['permOtherDisplay'] = getPermissionMarkup($video['comp'], $video['id'], 'po', $po);
	
	// Colour-code lead/follow/other display names by permission
	$videos[$id]['leadName'] = "<i style='background-color:{$colorMatrix[$pl]}'>&nbsp;{$video['leadName']}&nbsp;</i>";
	$videos[$id]['followName'] = "<i style='background-color:{$colorMatrix[$pf]}'>&nbsp;{$video['followName']}&nbsp;</i>";
	$videos[$id]['otherName'] = "<i style='background-color:{$colorMatrix[$po]}'>&nbsp;{$video['otherName']}&nbsp;</i>";
	
}
show_table($videos, $columns);

function getPermissionMarkup($comp, $video, $column, $currentValue){
	$optionNo = getPermissionOptionMarkup($comp, $video, $column, -1, $currentValue, 'N');
	$optionUnknown = getPermissionOptionMarkup($comp, $video, $column, 0, $currentValue, '?');
	$optionYes = getPermissionOptionMarkup($comp, $video, $column, 1, $currentValue, 'Y');
	$optionNA = getPermissionOptionMarkup($comp, $video, $column, 2, $currentValue, '-');

	return $optionNo
		. ' ' . $optionUnknown
		. ' ' . $optionYes
		. ' ' . $optionNA;
}

function getPermissionOptionMarkup($comp, $video, $column, $value, $currentValue, $display) {
	global $colorMatrix;
	
	$colour = $colorMatrix[$value];
	if($value === $currentValue) {
		return "<b style='background-color:{$colour}'>&nbsp;{$display}&nbsp;</b>";
	} else {
		return "<a href='?comp={$comp}&video={$video}&column={$column}&value={$value}' style='background-color:{$colour}; text-decoration:none;'>&nbsp;{$display}&nbsp;</a>";
	}
}