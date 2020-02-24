<?php

class Comp
{
	public $id;
	public $date;
	public $city;
	public $name;
	public $cityName;
	public $year;
	public $country;
	public $folder;

	function __construct($id=-1, $date="", $city=-1, $name="", $year="", $folder=""){
		$this->id = intval($id);
		$this->date = $date;
		$this->city = intval($city);
		$this->name = $name;
		$this->year = intval($year);
		$this->folder = $folder;

		if($id >= 0 && $date === "" && $name === "") {
			$this->loadFromDb();
		} else if(strlen($name) > 0 && strlen($year) > 0) {
			$this->saveToDb();
		}
	}

	public function loadFromDb() {
		//Fetch from comp table
		$statement = $GLOBALS['pdo']->prepare('SELECT * FROM comp WHERE id = :id');
		$statement->execute(['id' => $this->id]);
		$row = $statement->fetch();

		//Extract from table row
		$this->date = $row['date'];
		$this->city = $row['city'];
		$this->name = $row['name'];
		$this->year = $row['year'];
		$this->folder = $row['folder'];


		//Fetch from city table (via City class)
		$cityObject = new City($this->city);
		$cityDetails = $cityObject->export();
		$this->cityName = $cityDetails['name'];
		$this->country = $cityDetails['country'];

	}

	public function export(){
		return [
			'id' => $this->id,
			'date' => $this->date,
			'city' => $this->city,
			'name' => $this->name,
			'cityName' => $this->cityName,
			'year' => $this->year,
			'country' => $this->country,
			'folder' => $this->folder
		];
	}

	public function saveToDb() {
		$query = "
			INSERT INTO
				comp
			SET
				date = :date,
				city = :city,
				name = :name,
				year = :year,
				folder = :folder
		";

		$statement = $GLOBALS['pdo']->prepare($query);
		$statement->execute([
			'date' => $this->date,
			'city' => $this->city,
			'name' => $this->name,
			'year' => $this->year,
			'folder' => $this->folder
		]);

		$this->id = $GLOBALS['pdo']->lastInsertId();
	}


	public static function getAll() {
		$cities = City::getAll();
		$statement = $GLOBALS['pdo']->query('SELECT * FROM comp ORDER BY date ASC, id ASC');
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
