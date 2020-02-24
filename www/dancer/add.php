<?php

require("../../main.php");

// Fetch cities, prepare for use in dropdowns
$cities = City::getAll();
$cityNames = [];
foreach($cities as $key => $city) {
	$id = $city['id'];
	$cityNames[$id] = $city['name'] . " " . $city['country'];
}


// ==================
// == Form handler ==
// ==================

$newDancers = [];
$i = 0;
while(isset($_POST["firstName{$i}"]) && $_POST["firstName{$i}"] !== ""){
	$firstName = $_POST["firstName{$i}"];
	$lastName = $_POST["lastName{$i}"];
	$city = $_POST["city{$i}"];
	
	$dancer = new Dancer(-1, $firstName, $lastName, $city);
	$id = $dancer->id ?? 0;
	
	if($id > 0) {
		echo "Added dancer {$id}: {$firstName} {$lastName} ({$cityNames[$city]})<br />";
	} else {
		echo "Failed to add dancer: {$firstName} {$lastName} ({$cityNames[$city]})";
	}
	
	$i++;
}

 
// ==================
// == Form display ==
// ==================

$title = "Add Dancers";
require("../head.php");

echo <<<EOT
<form action="" method="post">
	<table style="max-width: 20em;">
		<tr>
			<th>First Name</th>
			<th>Last Name</th>
			<th>City</th>
		</tr>
EOT;

for($i=0;$i<10;$i++){
	$cities_dropdown = dropdown_markup("city{$i}", $cityNames, 'All', false);
	echo <<<EOT
		<tr>
			<td><input type="text" name="firstName{$i}" /></td>
			<td><input type="text" name="lastName{$i}" /></td>
			<td>{$cities_dropdown}</td>
		</tr>
EOT;
}

echo <<<EOT
		<tr>
			<td colspan="3" style="text-align:right;"><input type="submit" name="Add" /></td>
		</tr>
	</table>
</form>
EOT;
