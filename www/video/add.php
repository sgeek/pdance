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

// Fetch rounds, prepare for use in dropdowns
$rounds = Round::getAll();
$roundNames = [];
foreach($rounds as $key => $round) {
	$id = $round['id'];
	$roundNames[$id] = $round['name'];
}

// Fetch types, prepare for use in dropdowns
$types = PerformanceType::getAll();
$typeNames = [];
foreach($types as $key => $type) {
	$id = $type['id'];
	$typeNames[$id] = $type['name'];
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

	// Grab whole-form parameters (comp, event, level)
	$comp = $_POST['comp'] ?? -1;
	$event = $_POST['event'] ?? -1;
	$level = $_POST['level'] ?? -1;
	$round = $_POST['round'] ?? -1;
	$heat = $_POST['heat'] ?? 0;
	$type = $_POST['type'] ?? -1;


	// Go through the rows
	$i = 0;
	while($_POST["lead{$i}"] > 0 || $_POST["follow{$i}"] > 0){
		$code = $_POST["code{$i}"];
		$lead = $_POST["lead{$i}"];
		$follow = $_POST["follow{$i}"];
		$other = $_POST["other{$i}"];
		$seconds = $_POST["seconds{$i}"];

		$args = [
			"comp" => $comp,
			"event" => $event,
			"level" => $level,
			"lead" => $lead,	
		];
		
		$entry = Entry::query($args);
		
		if($entry === false) {
			$leadName = $dancerNames[$lead] ?? "--";
			$followName = $dancerNames[$follow] ?? "--";
			$otherName = $dancerNames[$other] ?? "--";
			echo "<b style='background-color:lightcoral;'>
				Entry not found! 
				Failed to add Video for
				{$roundNames[$round]} {$heat}
				of {$levelNames[$level]}
				{$eventNames[$event]}
				at {$compNames[$comp]}
				({$leadName},
				{$followName},
				{$otherName})</b><br />";
		} else {
//	function __construct($id=-1, $entry=-1, $follow=0, $round=-1, $heat=0, $type=-1, $perm_lead=0, $perm_follow=0, $perm_other=0, $seconds=-1, $code='', $filename='', $file_extension='', $url='', $note=''){

			$video = new Video(-1, $entry, $follow, $round, $heat, $type, 0,0,0, $seconds, $code);
			$id = $video->id ?? 0;

			if($id > 0) {
				echo "<i style='background-color:lightgreen;'>
				Added Video for
				{$roundNames[$round]} {$heat}
				of {$levelNames[$level]}
				{$eventNames[$event]}
				at {$compNames[$comp]}
				({$dancerNames[$lead]},
				{$dancerNames[$follow]},
				{$dancerNames[$other]})</b><br />";
			} else {
			echo "<b style='background-color:lightcoral;'>
				Failed to add Video for
				{$roundNames[$round]} {$heat}
				of {$levelNames[$level]}
				{$eventNames[$event]}
				at {$compNames[$comp]}
				({$dancerNames[$lead]},
				{$dancerNames[$follow]},
				{$dancerNames[$other]})</b><br />";
			}
		}


		
		$i++;
	}
}
 
// ==================
// == Form display ==
// ==================

$title = "Add Videos";
require("../head.php");

	$comps_dropdown = dropdown_markup("comp", $compNames, 0, false);
	$events_dropdown = dropdown_markup("event", $eventNames, 0, false);
	$levels_dropdown = dropdown_markup("level", $levelNames, 0, false);
	$rounds_dropdown = dropdown_markup("round", $roundNames, 0, false);
	$types_dropdown = dropdown_markup("type", $typeNames, 0, false);

echo <<<EOT
<form action="" method="post">
	<p>Comp: {$comps_dropdown}</p>
	<p>Event: {$events_dropdown}</p>
	<p>Level: {$levels_dropdown}</p>
	<p>Round: {$rounds_dropdown} <input type="text" name="heat" size="4" /></p>
	<p>Type: {$types_dropdown}</p>
	
	<table style="max-width: 20em;">
		<tr>
			<th>Code</th>
			<th>Lead</th>
			<th>Follow</th>
			<th>Other</th>
			<th>Seconds</th>
		</tr>
EOT;

for($i=0;$i<10;$i++){
	$leads_dropdown = dropdown_markup("lead{$i}", $dancerNames, 0, false);
	$follows_dropdown = dropdown_markup("follow{$i}", $dancerNames, 0, false);
	$others_dropdown = dropdown_markup("other{$i}", $dancerNames, 0, false);
	echo <<<EOT
		<tr>
			<td><input type="text" name="code{$i}" size="4"/></td>
			<td>{$leads_dropdown}</td>
			<td>{$follows_dropdown}</td>
			<td>{$others_dropdown}</td>
			<td><input type="text" name="seconds{$i}" size="4" /></td>
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
