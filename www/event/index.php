<?php

require("../../main.php");

$title = "Event";
require("../head.php");

$id = $_GET['id'] ?? -1;
$id = (int) $id;


if($id === -1) {
	$events = Event::getAll();
	show_table($events);
} else {
	$event = new Event($id);
	$event_array = $event->export();
	show_table([$event_array]);
}
