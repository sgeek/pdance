<?php

require("../../main.php");

// Fetch comps, prepare for use in dropdowns
$comps = Comp::getAll();
$compNames = [];
foreach($comps as $key => $comp) {
	$id = $comp['id'];
	$compNames[$id] = $comp['name'] . " " . $comp['year'];
}
$compNames[0] = "--";

// Fetch events, prepare for use in dropdowns
$events = Event::getAll();
$eventNames = [];
foreach($events as $key => $event) {
	$id = $event['id'];
	$eventNames[$id] = $event['name'];
}
$eventNames[0] = "--";

// Fetch levels, prepare for use in dropdowns
$levels = Level::getAll();
$levelNames = [];
foreach($levels as $key => $level) {
	$id = $level['id'];
	$levelNames[$id] = $level['name'];
}

// Fetch dancers, prepare for use in dropdowns
$dancers = Dancer::getAll();
$dancerNames = [];
foreach($dancers as $key => $dancer) {
	$id = $dancer['id'];
	$dancerNames[$id] = $dancer['firstName'] . ' ' . $dancer['lastName'];
}
$dancerNames[0] = "--";


// ==================
// == Form handler ==
// ==================

// Do we have form data to process?
if(isset($_POST['lead0']) || isset($_POST['follow0'])) {
//	var_dump($_POST['event']); die();

	// Grab whole-form parameters (comp, event, level)
	$comp = $_POST['comp'] ?? -1;
	$event = $_POST['event'] ?? -1;
	$level = $_POST['level'] ?? -1;

//	function __construct($id=-1, $comp=-1, $event=-1, $level=-1, $lead=-1, $follow=-1, $other=-1){

	// Go through the rows
	$i = 0;
	while($_POST["lead{$i}"] > 0 || $_POST["follow{$i}"] > 0){
		$lead = $_POST["lead{$i}"];
		$follow = $_POST["follow{$i}"];
		$other = $_POST["other{$i}"];


		$entry = new Entry(-1, $comp, $event, $level, $lead, $follow, $other);
		$id = $entry->id ?? 0;
		
		if($id > 0) {
			echo "<i style='background-color:lightgreen;'>
				Added Entry for
				{$levelNames[$level]}
				{$eventNames[$event]}
				at {$compNames[$comp]}
				({$dancerNames[$lead]},
				{$dancerNames[$follow]},
				{$dancerNames[$other]})<br />";
		} else {
			echo "<b style='background-color:lightcoral;'>
				Failed to add Entry for
				{$levelNames[$level]}
				{$eventNames[$event]}
				at {$compNames[$comp]}
				({$dancerNames[$lead]},
				{$dancerNames[$follow]},
				{$dancerNames[$other]})</b><br />";
		}
		
		$i++;
	}
}
 
// ==================
// == Form display ==
// ==================

$title = "Add Entries";
require("../head.php");

	$comps_dropdown = dropdown_markup("comp", $compNames, 0, false);
	$events_dropdown = dropdown_markup("event", $eventNames, 0, false);
	$levels_dropdown = dropdown_markup("level", $levelNames, 0, false);

echo <<<EOT
<form action="" method="post">
	<p>Comp: {$comps_dropdown}</p>
	<p>Event: {$events_dropdown}</p>
	<p>Level: {$levels_dropdown}</p>
	
	<table style="max-width: 20em;">
		<tr>
			<th>Lead</th>
			<th>Follow</th>
			<th>Other</th>
		</tr>
EOT;

for($i=0;$i<10;$i++){
	$leads_dropdown = dropdown_markup("lead{$i}", $dancerNames, 0, false);
	$follows_dropdown = dropdown_markup("follow{$i}", $dancerNames, 0, false);
	$others_dropdown = dropdown_markup("other{$i}", $dancerNames, 0, false);
	echo <<<EOT
		<tr>
			<td>{$leads_dropdown}</td>
			<td>{$follows_dropdown}</td>
			<td>{$others_dropdown}</td>
		</tr>
EOT;
}

echo <<<EOT
		<tr>
			<td colspan="5" style="text-align:right;"><input type="submit" value="Add" /></td>
		</tr>
	</table>
</form>
EOT;
