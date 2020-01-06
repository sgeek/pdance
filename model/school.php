<?php

class School
{
	public $id;
	public $city;
	public $name;
	public $cityName;
	public $country;

	function __construct($id=-1, $city=0, $name=""){
		$this->id = $id;
		$this->city = $city;
		$this->name = $name;

		if($id >= 0 && $city === 0 && $name === "") {
			$this->loadFromDb();
		} else if($city > 0 && strlen($name) > 0) {
			$this->saveToDb();
		}
	}

	public function loadFromDb() {
		//Fetch from comp table
		$statement = $GLOBALS['pdo']->prepare('SELECT * FROM school WHERE id = :id');
		$statement->execute(['id' => $this->id]);
		$row = $statement->fetch();

		//Extract from table row
		$this->city = $row['city'];
		$this->name = $row['name'];

		//Fetch from city table (via City class)
		$cityObject = new City($this->city);
		$cityDetails = $cityObject->export();
		$this->cityName = $cityDetails['name'];
		$this->country = $cityDetails['country'];

	}

	public function export(){
		return [
			'id' => $this->id,
			'city' => $this->city,
			'name' => $this->name,
			'cityName' => $this->cityName,
			'country' => $this->country,
		];
	}

	public function saveToDb() {

	}

	public static function getAll() {
		$cities = City::getAll();
		$statement = $GLOBALS['pdo']->query('SELECT * FROM school ORDER BY id ASC');
		$rows = [];
		while($row = $statement->fetch()){
			$id = $row['id'];
			$city = $row['city'];
			$currentCity = $cities[$city] ?? false;
			if($currentCity) {
				$row['cityName'] = $currentCity['name'];
				$row['country'] = $currentCity['country'];
				$rows[] = $row;
			}
		}
		return $rows;
	}

}
