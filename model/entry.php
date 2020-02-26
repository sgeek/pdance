<?php

class Entry
{
	//Direct properties (stored in `entry` table)
	public $id;
	public $comp;
	public $event;
	public $level;
	public $lead;
	public $follow;
	public $other;

	//Indirect properties (stored in other tables)
	public $compName;
	public $eventName;
	public $levelCode;
	public $leadName;
	public $followName;
	public $otherName;

	function __construct($id=-1, $comp=-1, $event=-1, $level=-1, $lead=-1, $follow=-1, $other=-1){
		$this->id = $id;
		$this->comp = $comp;
		$this->event = $event;
		$this->level = $level;
		$this->lead = $lead;
		$this->follow = $follow;
		$this->other = $other;

		if($id >= 0 && $comp === -1 && $event === -1) {
			$this->loadFromDb();
		} else if($id === -1 && $comp >= 0 && $event >= 0) {
			$this->saveToDb();
		}
	}

	public function loadFromDb() {
		//Fetch from entry table
		$statement = $GLOBALS['pdo']->prepare('SELECT * FROM entry WHERE id = :id');
		$statement->execute(['id' => $this->id]);
		$row = $statement->fetch();

		//Extract from table row
		$this->comp = $row['comp'];
		$this->event = $row['event'];
		$this->level = $row['level'];
		$this->lead = $row['lead'];
		$this->follow = $row['follow'];
		$this->other = $row['other'];

		$this->loadComp();
		$this->loadEvent();
		$this->loadLevel();
		$this->loadDancers();

	}


	public function loadComp() {
		//Fetch from comp table (via Comp class)
		$compObject = new Comp($this->comp);
		$compDetails = $compObject->export();
		$this->compName = $compDetails['name'] . " " . $compDetails['year'];
	}

	public function loadEvent() {
		//Fetch from event table (via Event class)
		$eventObject = new Event($this->event);
		$eventDetails = $eventObject->export();
		$this->eventName = $eventDetails['name'];
	}

	public function loadLevel() {
		//Fetch from level table (via Level class)
		$levelObject = new Level($this->level);
		$levelDetails = $levelObject->export();
		$this->levelCode = $levelDetails['code'];
	}

	public function loadDancers() {
		$this->leadName = $this->getDancerName($this->lead);
		$this->followName = $this->getDancerName($this->follow);
		$this->otherName = $this->getDancerName($this->other);
	}

	public function getDancerName($id) {
		$dancerObject = new Dancer($id);
		$dancerDetails = $dancerObject->export();
		return $dancerDetails['firstName'] . ' ' . $dancerDetails['lastName'];

	}

	public function export(){
		return [
			'id' => $this->id,
			'comp' => $this->comp,
			'event' => $this->event,
			'level' => $this->level,
			'lead' => $this->lead,
			'follow' => $this->follow,
			'other' => $this->other,
			'compName' => $this->compName,
			'eventName' => $this->eventName,
			'levelCode' => $this->levelCode,
			'leadName' => $this->leadName,
			'followName' => $this->followName,
			'otherName' => $this->otherName,
		];
	}

	public function saveToDb() {
		$query = "
			INSERT INTO
				entry
			SET
				comp = :comp,
				event = :event,
				level = :level,
				`lead` = :lead,
				follow = :follow,
				other = :other
		";

		$statement = $GLOBALS['pdo']->prepare($query);
		$statement->execute([
			'comp' => $this->comp,
			'event' => $this->event,
			'level' => $this->level,
			'lead' => $this->lead,
			'follow' => $this->follow,
			'other' => $this->other,
		]);

		$this->id = $GLOBALS['pdo']->lastInsertId();

	}

	public static function getAll() {
		$comps = Comp::getAll();
		$events = Event::getAll();
		$levels = Level::getAll();
		$dancers = Dancer::getAll();

		$statement = $GLOBALS['pdo']->query('SELECT * FROM entry ORDER BY id ASC');
		$rows = [];
		while($row = $statement->fetch()){
			$id = $row['id'];

			// Look up comp name
			$currentComp = $row['comp'];
			$compRow = $comps[$currentComp] ?? false;
			if($compRow) {
				$row['compName'] = $compRow['name'] . " " . $compRow['year'];
			} else {
				$row['compName'] = "";
			}

			// Look up event name
			$currentEvent = $row['event'];
			$row['eventName'] = $events[$currentEvent]['name'] ?? '';

			// Look up level code
			$currentLevel = $row['level'];
			$row['levelCode'] = $levels[$currentLevel]['code'] ?? false;

			// Look up lead name
			$currentLead = $row['lead'];
			$leadRow = $dancers[$currentLead] ?? false;
			if($leadRow) {
				$row['leadName'] = $leadRow['firstName'] . " " . $leadRow['lastName'];
			} else {
				$leadName = "";
			}

			// Look up Follow name
			$currentFollow = $row['follow'];
			$followRow = $dancers[$currentFollow] ?? false;
			if($followRow) {
				$row['followName'] = $followRow['firstName'] . " " . $followRow['lastName'];
			} else {
				$row['followName'] = "";
			}

			// Look up Other name
			$currentOther = $row['other'];
			$otherRow = $dancers[$currentOther] ?? false;
			if($otherRow) {
				$row['otherName'] = $otherRow['firstName'] . " " . $otherRow['lastName'];
			} else {
				$row['otherName'] = "";
			}

			$rows[$id] = $row;
		}
		return $rows;
	}

}
