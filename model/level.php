<?php

class Level
{
	public $id;
	public $code;
	public $name;

	function __construct($id=-1, $code="", $name=""){
		$this->id = $id;
		$this->code = $code;
		$this->name = $name;

		if($id >= 0 && $code === "" && $name === "") {
			$this->loadFromDb();
		} else if($id >= 0 && strlen($code) > 0 && strlen($name) > 0) {
			$this->saveToDb();
		}
	}

	public function loadFromDb() {
		$statement = $GLOBALS['pdo']->prepare('SELECT * FROM level WHERE id = :id');
		$statement->execute(['id' => $this->id]);
		$row = $statement->fetch();

		$this->code = $row['code'];
		$this->name = $row['name'];
	}

	public function export(){
		return [
			'id' => $this->id,
			'code' => $this->code,
			'name' => $this->name,
		];
	}

	public function saveToDb() {

	}

	public static function getAll() {
		$statement = $GLOBALS['pdo']->query('SELECT * FROM level ORDER BY id ASC');
		$rows = [];
		while($row = $statement->fetch()){
			$id = $row['id'];
			$rows[$id] = $row;
		}
		return $rows;
	}

}
