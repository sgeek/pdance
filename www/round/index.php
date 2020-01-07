<?php

require("../../main.php");

$title = "Round";
require("../head.php");

$id = $_GET['id'] ?? -1;
$id = (int) $id;


if($id === -1) {
	$rounds = Round::getAll();
	show_table($rounds);
} else {
	$round = new Round($id);
	$round_array = $round->export();
	show_table([$round_array]);
}
