<?php
function show_table($data, $columns=[]) {
	if(!is_array($data) || !$data || !is_array(array_values($data)[0])) {
    echo "Error: Cannot display table<br />\n";
    return false;
  }
	echo "<table><tr>";

	//If columns aren't specified, use array keys instead
	if(!$columns) {
		$columns = array_keys(array_values($data)[0]); // get column headings (key names from the first row of data)
	}

	//Display table headings
	foreach($columns as $key => $name) {
		echo "<th>{$name}</th>";
	}
	echo "</tr>\n";
	foreach($data as $row){
		echo "<tr>";
		foreach($columns as $key => $name){
			if(is_numeric($key)) $key = $name;
      $value = $row[$key] ?? "";
			echo "<td>{$value}</td>";
		}
		echo "</tr>\n";
	}

	return true;
}

function dropdown_markup($name="", $options=[], $default='all'){
	if($name === "" || $options === []) return "";

	$markup = "<select name='{$name}' onchange='this.form.submit()'>";
	$selected_already = false;
	foreach($options as $key => $value){
		if(strlen(trim($value)) > 0){
			$selected = $key == $default && !$selected_already ? "selected" : "";
			if($selected) $selected_already = true;
			$markup .= "\t<option value='{$key}' {$selected}>{$value}</option>";
		}
	}
	$markup .= "</select>";
	return $markup;
}
