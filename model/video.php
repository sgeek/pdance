<?php

class Video
{
	// Direct properties (stored in `video` table)
	public $id;
	public $entry;
	public $follow;
	public $round;
	public $heat;
	public $type;
	public $perm_lead;
	public $perm_follow;
	public $perm_other;
	public $perm_final;
	public $seconds;
	public $code;
	public $filename;
	public $file_extension;
	public $url;
	public $note;

	// Indirect properties from Entry
	public $comp;
	public $compName;
	public $event;
	public $eventName;
	public $level;
	public $levelCode;
	public $lead;
	public $leadName;
	public $followName; //follow ID already exists in `video` table
	public $other;
	public $otherName;

	// misc indirect
	public $roundName;
	public $performanceType;
	public $linkMarkup;

	function __construct($id=-1, $entry=-1, $follow=-1, $round=-1, $heat=-1, $type=-1, $perm_lead=0, $perm_follow=0, $perm_other=0, $perm_final=0, $seconds=-1, $code='', $filename='', $file_extension='', $url='', $note=''){
		$this->id = $id;
		$this->entry = $entry;
		$this->follow = $follow;
		$this->round = $round;
		$this->heat = $round;
		$this->type = $type;
		$this->perm_lead = $perm_lead;
		$this->perm_follow = $perm_follow;
		$this->perm_other = $perm_other;
		$this->perm_final = $perm_final;
		$this->seconds = $seconds;
		$this->code = $code;
		$this->filename = $filename;
		$this->file_extension = $file_extension;
		$this->url = $url;
		$this->note = $note;

		if($id >= 0 && $entry === -1 && $follow === -1) {
			$this->loadFromDb();
		} else if($id === -1 && $entry >= 0 && $follow >= 0) {
			$this->saveToDb();
		}
	}

	public function loadFromDb() {
		//Fetch from entry table
		$statement = $GLOBALS['pdo']->prepare('SELECT * FROM video WHERE id = :id');
		$statement->execute(['id' => $this->id]);
		$row = $statement->fetch();

		//Extract from table row
		$this->entry = $row['entry'];
		$this->follow = $row['follow'];
		$this->round = $row['round'];
		$this->heat = $row['heat'];
		$this->type = $row['type'];
		$this->perm_lead = $row['perm_lead'];
		$this->perm_follow = $row['perm_follow'];
		$this->perm_other = $row['perm_other'];
		$this->perm_final = $row['perm_final'];
		$this->seconds = $row['seconds'];
		$this->code = $row['code'];
		$this->filename = $row['filename'];
		$this->file_extension = $row['file_extension'];
		$this->url = $row['url'];
		$this->note = $row['note'];

		if($this->url){
			$this->linkMarkup = "<a href='{$this->url}'>{$this->url}</a>";
		} else {
			$this->linkMarkup = "";
		}

		$this->loadEntry();
		$this->loadFollow();
		$this->loadRound();
		$this->loadType();

	}


	public function loadEntry() {
		//Fetch from entry table and others (via Entry class)
		$entryObject = new Entry($this->entry);
		$entryDetails = $entryObject->export();
		$this->comp = $entryDetails['comp'];
		$this->compName = $entryDetails['compName'];
		$this->event = $entryDetails['event'];
		$this->eventName = $entryDetails['eventName'];
		$this->level = $entryDetails['level'];
		$this->levelCode = $entryDetails['levelCode'];
		$this->lead = $entryDetails['lead'];
		$this->leadName = $entryDetails['leadName'];
		if($this->follow === 0) {
			$this->follow = $entryDetails['follow'];
			$this->followName = $entryDetails['followName'];
		}
		$this->other = $entryDetails['other'];
		$this->otherName = $entryDetails['otherName'];
	}

	public function loadFollow() {
		if(strlen($this->followName) > 0) return; //If we already have a follow name, call it good
		if($this->follow === 0) { // if we don't have a follow ID, then set follow name blank and call it good
			$this->followName = "";
			return;
		}

		//Fetch from dancer table (via Dancer class)
		$dancerObject = new Dancer($this->follow);
		$dancerDetails = $dancerObject->export();
		$this->followName = $dancerDetails['firstName'] . ' ' . $dancerDetails['lastName'];
	}

	public function loadRound() {
		//Fetch from round table (via Round class)
		$roundObject = new Round($this->round);
		$roundDetails = $roundObject->export();
		$this->roundName = $roundDetails['name'];
	}

	public function loadType() {
		//Fetch from performance_type table (via PerformanceType class)
		$typeObject = new PerformanceType($this->type);
		$typeDetails = $typeObject->export();
		$this->performanceType = $typeDetails['name'];
	}


	public function export(){
		return [
			'id' => $this->id,
			'entry' => $this->entry,
			'follow' => $this->follow,
			'round' => $this->round,
			'heat' => $this->heat,
			'type' => $this->type,
			'perm_lead' => $this->perm_lead,
			'perm_follow' => $this->perm_follow,
			'perm_other' => $this->perm_other,
			'perm_final' => $this->perm_final,
			'seconds' => $this->seconds,
			'code' => $this->code,
			'filename' => $this->filename,
			'file_extension' => $this->file_extension,
			'url' => $this->url,
			'note' => $this->note,

			//via Entry
			'comp' => $this->comp,
			'compName' => $this->compName,
			'event' => $this->event,
			'eventName' => $this->eventName,
			'level' => $this->level,
			'levelCode' => $this->levelCode,
			'lead' => $this->lead,
			'leadName' => $this->leadName,
			'followName' => $this->followName,
			'other' => $this->other,
			'otherName' => $this->otherName,

			// misc indirect
			'roundName' => $this->roundName,
			'performanceType' => $this->performanceType,
			'linkMarkup' => $this->linkMarkup,
		];
	}

	public function saveToDb() {

	}

	public static function getAll() {
		$entries = Entry::getAll();
		$rounds = Round::getAll();
		$performanceTypes = PerformanceType::getAll();
		$dancers = Dancer::getAll();

		$statement = $GLOBALS['pdo']->query('SELECT * FROM video ORDER BY id ASC');
		$rows = [];
		while($row = $statement->fetch()){
			$id = $row['id'];

			// Look up entry details
			$currentEntry = $row['entry'];
			$entryRow = $entries[$currentEntry] ?? false;

			$row['comp'] = $entryRow['comp'] ?? "";
			$row['compName'] = $entryRow['compName'] ?? "";
			$row['event'] = $entryRow['event'] ?? "";
			$row['eventName'] = $entryRow['eventName'] ?? "";
			$row['level'] = $entryRow['level'] ?? "";
			$row['levelCode'] = $entryRow['levelCode'] ?? "";
			$row['lead'] = $entryRow['lead'] ?? "";
			$row['leadName'] = $entryRow['leadName'] ?? "";
			$row['other'] = $entryRow['other'] ?? "";
			$row['otherName'] = $entryRow['otherName'] ?? "";

			if($row['follow'] === 0 && $entryRow['follow'] > 0) {
				$row['follow'] = $entryRow['follow'];
				$row['followName'] = $entryRow['followName'];
			}

			if($row['follow'] > 0 && !isset($row['followName'])) {
				$currentFollow = $row['follow'];
				$followRow = $dancers[$currentFollow];
				$row['followName'] = $followRow['firstName'] . ' ' . $followRow['lastName'];
			}

			// misc
			$currentRound = $row['round'];
			$row['roundName'] = $rounds[$currentRound]['name'];
			$currentType = $row['type'];
			$row['performanceType'] = $performanceTypes[$currentType]['name'];
			$row['linkMarkup'] = "<a href='{$row['url']}'>{$row['url']}</a>";

			$rows[$id] = $row;
		}
		return $rows;
	}

}
