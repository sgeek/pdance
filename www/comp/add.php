<?php

require("../../main.php");

// ==================
// == Form handler ==
// ==================

if(isset($_POST) && isset($_POST['compDate'])) {
	$date = $_POST['compDate'];
	$city = $_POST['compCity'];
	$name = $_POST['compName'];
	$year = $_POST['compYear'];
	$folder = $_POST['compFolder'];
	
	$comp = new Comp(-1, $date, $city, $name, $year, $folder);
	
	$id = $comp->id;
	
	header("Location: index.php?id={$id}");
	die();

}

 
// ==================
// == Form display ==
// ==================

$title = "Add Comp";
require("../head.php");

// Fetch cities, prepare for use in dropdowns
$cities = City::getAll();
$cityNames = [];
foreach($cities as $key => $city) {
	$id = $city['id'];
	$cityNames[$id] = $city['name'] . " " . $city['country'];
}

$cities_dropdown = dropdown_markup('compCity', $cityNames, 'none', false);

echo <<<EOT
<form action="" method="post">
	<p style="width:10em; margin-left:auto; margin-right:auto;">
		Date (ISO):
		<input type='text' name='compDate' /><br />
		<br />
		City:
		{$cities_dropdown}
		<br />
		<br />
		Name:
		<input type='text' name='compName' /><br />
		<br />
		Year:
		<input type='text' name='compYear' /><br />
		<br />
		Folder:
		<input type='text' name='compFolder' /><br />
		<br />
		<input type='submit' name='Add' />
	</p>
</form>
EOT;