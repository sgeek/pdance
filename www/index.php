<?php
$start = microtime(true);

// Public display of all public videos
require("../pdo.php");
require("../functions.php");
require("../model/video.php");

$title = "Pat's MJ Comp Videos";

echo <<<EOT
<html>
<head>
<title>pDance: {$title}</title>
<style>
body {
	text-align: center;
}

div.page {
	display:inline-block;
	border:1px solid black;
	padding:5px;
	background-color:rgb(230,230,230);
	max-width: 100vw;
}

table {
	border: 1px solid black;
	border-collapse: collapse;
	width: 100%;
	margin-left: auto;
	margin-right: auto;
	background-color:white;
}

th, td {
	border: 1px solid black;
	text-align: center;
}

h1 {
	text-align: center;
}
</style>
</head>
<body>
<h1>{$title}</h1>


EOT;
// Set up columns
$columns = [
	'compName' => 'Comp',
	'code' => 'Code',
	'level_code' => 'Lvl',
	'event_name' => 'Event',
	'roundName' => 'Round',
	'performance_type_name' => 'Type',
	'leadName' => 'Lead',
	'followName' => 'Follow',
	'otherName' => 'Other',
	'linkMarkup' => 'YouTube',
	'length' => 'Length',
];

// Fetch video metadata
$videos = Video::getPublic($_GET);

// Collect data for filter dropdowns
$comps = [];
$years = [];
$rounds = [];
$levels = [];
$types = [];
$events = [];
$dancers = [];
foreach($videos as $row){
	// Pull relevant fields from row
	$comp_id = $row['comp_id'];
	$compName = $row['compName'];
	$year = $row['comp_year'];
	$round_id = $row['round_id'];
	$round_name = $row['round_name'];
	$level_id = $row['level_id'];
	$level_name = $row['level_name'];
	$type_id = $row['type_id'];
	$performance_type_name = $row['performance_type_name'];
	$event_id = $row['event_id'];
	$event_name = $row['event_name'];
	$entry_lead_id = $row['entry_lead_id'];
	$leadName = $row['leadName'];
	$followId = $row['followId'];
	$followName = $row['followName'];
	$entry_other_id = $row['entry_other_id'];
	$otherName = $row['otherName'];

	// Save values to dropdown arrays
	$comps[$comp_id] = $compName;
	$years[$year] = $year;
	$rounds[$round_id] = $round_name;
	$levels[$level_id] = $level_name;
	$types[$type_id] = $performance_type_name;
	$events[$event_id] = $event_name;
	$dancers[$entry_lead_id] = $leadName;
	$dancers[$followId] = $followName;
	$dancers[$entry_other_id] = $otherName;
}

// Add "All" options to dropdowns, sort options, fe
$dropdowns = ['comps', 'years', 'rounds', 'levels', 'types', 'events', 'dancers'];
foreach($dropdowns as $dropdown){
	$$dropdown["all"] = " All";
	asort($$dropdown);
}

// Get dropdown markups
$compDropdown = dropdown_markup('comp', $comps, $_GET['comp'] ?? 'all');
$yearDropdown = dropdown_markup('year', $years, $_GET['year'] ?? 'all');
$roundDropdown = dropdown_markup('round', $rounds, $_GET['round'] ?? 'all');
$levelDropdown = dropdown_markup('level', $levels, $_GET['level'] ?? 'all');
$typeDropdown = dropdown_markup('type', $types, $_GET['type'] ?? 'all');
$eventDropdown = dropdown_markup('event', $events, $_GET['event'] ?? 'all');
$dancerDropdown = dropdown_markup('dancer', $dancers, $_GET['dancer'] ?? 'all');
$dancer2Dropdown = dropdown_markup('dancer2', $dancers, $_GET['dancer2'] ?? 'all');

echo <<<EOT
<div class="page">
	<form method="GET" action="">
		<table>
			<tr>
				<th>Comp</th>
				<th>Level</th>
				<th>Event</th>
				<th>Round</th>
				<th>Type</th>
				<th>Dancer</th>
				<th>Dancer</th>
			</tr>
			<tr>
				<td>{$compDropdown}</td>
				<td>{$levelDropdown}</td>
				<td>{$eventDropdown}</td>
				<td>{$roundDropdown}</td>
				<td>{$typeDropdown}</td>
				<td>{$dancerDropdown}</td>
				<td>{$dancer2Dropdown}</td>
			</tr>
		</table>
	</form>
		<br />
EOT;

show_table($videos, $columns);
$numVideos = count($videos);
$elapsed = microtime(true) - $start;
$milli = 0.1 * floor($elapsed*1000);
echo "<p style='display:none;'>{$numVideos} videos in {$milli} ms</p>";

echo "</div>";
