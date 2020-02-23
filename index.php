<?php
// Public display of all public videos

// Title for this instance of pDance
$title = "Pat's MJ Comp Videos";


$start = microtime(true);

// Clean up URL
$uri = preg_replace('/\w+=all&?/', '', $_SERVER['REQUEST_URI']); // Remove any parameters set to 'all'
$uri = rtrim($uri, '?&'); // Remove stray characters at the end of the URI
if($uri !== $_SERVER['REQUEST_URI']) header("Location: {$uri}");

// Includes
require("pdo.php");
require("functions.php");
require("model/video.php");

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

	// Collect values from this row
	$options['comp'][$comp_id] = $compName;
	$options['year'][$year] = $year;
	$options['round'][$round_id] = $round_name;
	$options['level'][$level_id] = $level_name;
	$options['type'][$type_id] = $performance_type_name;
	$options['event'][$event_id] = $event_name;
	$options['dancer'][$entry_lead_id] = $leadName;
	$options['dancer'][$followId] = $followName;
	$options['dancer'][$entry_other_id] = $otherName;
}

// Add "All" to dropdown options, and sort each dropdown's list of options
$dropdownArrayNames = ['comp', 'year', 'round', 'level', 'type', 'event', 'dancer'];
foreach($dropdownArrayNames as $name){
	$options[$name]['all'] = " All";
	asort($options[$name]);
}

// Get dropdown markups (better way)
$dropdownNames = ['comp', 'year', 'round', 'level', 'type', 'event', 'dancer', 'dancer2'];
foreach($dropdownNames as $dName){
	$selectedOption = $_GET[$dName] ?? 'all';
	if($dName === 'dancer2') {
		$arrayName = 'dancer';
	} else {
		$arrayName = $dName;
	}
	$dMarkup[$dName] = dropdown_markup($dName, $options[$arrayName], $selectedOption);
}

// Get dropdown markups (readable way)
//$compDropdown = dropdown_markup('comp', $comps, $_GET['comp'] ?? 'all');
//$yearDropdown = dropdown_markup('year', $years, $_GET['year'] ?? 'all');
//$roundDropdown = dropdown_markup('round', $rounds, $_GET['round'] ?? 'all');
//$levelDropdown = dropdown_markup('level', $levels, $_GET['level'] ?? 'all');
//$typeDropdown = dropdown_markup('type', $types, $_GET['type'] ?? 'all');
//$eventDropdown = dropdown_markup('event', $events, $_GET['event'] ?? 'all');
//$dancerDropdown = dropdown_markup('dancer', $dancers, $_GET['dancer'] ?? 'all');
//$dancer2Dropdown = dropdown_markup('dancer2', $dancers, $_GET['dancer2'] ?? 'all');

// Display filter dropdowns
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
				<td>{$dMarkup['comp']}</td>
				<td>{$dMarkup['level']}</td>
				<td>{$dMarkup['event']}</td>
				<td>{$dMarkup['round']}</td>
				<td>{$dMarkup['type']}</td>
				<td>{$dMarkup['dancer']}</td>
				<td>{$dMarkup['dancer2']}</td>
			</tr>
		</table>
	</form>
		<br />
EOT;

// Display actual table of video data
show_table($videos, $columns);
echo "</div>";

// Hidden display of page render time
$numVideos = count($videos);
$elapsed = microtime(true) - $start;
$milli = 0.1 * floor($elapsed*1000);
echo "<p style='display:none;'>{$numVideos} videos in {$milli} ms</p>";

echo <<<EOT
	</body>
</html>
EOT;
