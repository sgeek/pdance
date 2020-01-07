<?php

class Round
{
	public $id;
	public $name;

	function __construct($id=-1, $name=""){
		$this->id = $id;
		$this->name = $name;

		if($id >= 0 && $name === "") {
			$this->loadFromDb();
		} else if($id >= 0 && strlen($name) > 0) {
			$this->saveToDb();
		}
	}

	public function loadFromDb() {
		$statement = $GLOBALS['pdo']->prepare('SELECT * FROM round WHERE id = :id');
		$statement->execute(['id' => $this->id]);
		$row = $statement->fetch();

		$this->name = $row['name'];
	}

	public function export(){
		return [
			'id' => $this->id,
			'name' => $this->name,
		];
	}

	public function saveToDb() {

	}

	public static function getAll() {
		$statement = $GLOBALS['pdo']->query('SELECT * FROM round ORDER BY id ASC');
		$rows = [];
		while($row = $statement->fetch()){
			$id = $row['id'];
			$rows[$id] = $row;
		}
		return $rows;
	}

}
