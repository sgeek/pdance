<?php

require("../../main.php");

$title = "Event";
require("../head.php");

$id = $_GET['id'] ?? 0;
$id = (int) $id;


if($id === 0) {
	$events = Event::getAll();
	show_table($events);
} else {
	$event = new Event($id);
	$event_array = $event->export();
	show_table([$event_array]);
}
