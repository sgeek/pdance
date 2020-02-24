<?php

class Dancer
{
	public $id;
	public $city;
	public $firstName;
	public $lastName;
	public $name;
	public $cityName;
	public $country;

	function __construct($id=-1, $firstName="", $lastName="", $city=0){
		$this->id = $id;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->city = $city;

		if($id >= 0 && $firstName === "" && $lastName === "") {
			$this->loadFromDb();
		} else if(strlen($firstName) > 0 && strlen($lastName) > 0) {
			$this->saveToDb();
		}
	}

	public function loadFromDb() {
		//Fetch from dancer table
		$statement = $GLOBALS['pdo']->prepare('SELECT * FROM dancer WHERE id = :id');
		$statement->execute(['id' => $this->id]);
		$row = $statement->fetch();

		//Extract from table row
		$this->firstName = $row['firstName'];
		$this->lastName = $row['lastName'];
		$this->name = $row['firstName'] . " " . $row['lastName'];
		$this->city = $row['city'];

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
			'firstName' => $this->firstName,
			'lastName' => $this->lastName,
			'name' => $this->name,
			'cityName' => $this->cityName,
			'country' => $this->country
		];
	}

	public function saveToDb() {
		$query = "
			INSERT INTO
				dancer
			SET
				firstName = :firstName,
				lastName = :lastName,
				city = :city
		";

		$statement = $GLOBALS['pdo']->prepare($query);
		$statement->execute([
			'firstName' => $this->firstName,
			'lastName' => $this->lastName,
			'city' => $this->city,
		]);

		$this->id = $GLOBALS['pdo']->lastInsertId();

	}

	public static function getAll() {
		$cities = City::getAll();
		$statement = $GLOBALS['pdo']->query('SELECT * FROM dancer ORDER BY firstName ASC, lastName ASC');
		$rows = [];
		while($row = $statement->fetch()){
			$id = $row['id'];
			$city = $row['city'];
			$currentCity = $cities[$city] ?? false;
			if($currentCity) {
				$row['cityName'] = $currentCity['name'];
				$row['country'] = $currentCity['country'];
				$rows[$id] = $row;
			}
		}
		return $rows;
	}

}
