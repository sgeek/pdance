<?php

class City
{
	public $id;
	public $name;
	public $country;
	
	function __construct($id=0, $name="", $country=""){
		$this->id = $id;
		$this->name = $name;
		$this->country = $country;
		
		if($id > 0 && $name === "" && $country === "") {
			$this->loadFromDb();
		} else if(strlen($name) > 0 && strlen($country) > 0) {
			$this->saveToDb();
		}
	}

	public function loadFromDb() {
		$statement = $GLOBALS['pdo']->prepare('SELECT * FROM city WHERE id = :id');
		$statement->execute(['id' => $this->id]);
		$row = $statement->fetch();
		
		$this->name = $row['name'];
		$this->country = $row['country'];
	}
	
	public function saveToDb() {
		
	}

	public static function getAll() {
		$statement = $GLOBALS['pdo']->query('SELECT * FROM city ORDER BY id ASC');
		$rows = [];
		while($row = $statement->fetch()){
			$rows[] = $row;
		}
		return $rows;
	}
	
}
