<?php

class Dancer
{
	public $id;
	public $city;
	public $firstName;
	public $lastName;
	public $cityName;
	
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
	
	public function export(){
		return [
			'id' => $this->id,
			'name' => $this->name,
			'country' => $this->country
		];
	}
	
	public function saveToDb() {
		
	}

	public static function getAll() {
		$cities = City::getAll();
		$statement = $GLOBALS['pdo']->query('SELECT * FROM dancer ORDER BY id ASC');
		$rows = [];
		while($row = $statement->fetch()){
			$id = $row['id'];
			$row['cityName'] = $cities[$id]['name'];
			$row['country'] = $cities[$id]['country'];
			$rows[] = $row;
		}
		return $rows;
	}
	
}
