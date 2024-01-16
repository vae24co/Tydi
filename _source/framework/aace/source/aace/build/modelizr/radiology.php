<?php
class RadiologyModel extends ModelizrAbstract {

	// ∞ PROPERTY •
	// protected $database;
	protected $table = 'radiology';





	// ∞ ----- INITIALIZE •
	protected function initialize($config = null) {

		// + Set Default Database Name
		$dbKey = 'aace';
		$this->database = Env::property('config')['database']['aace']['name'];

		// + Connect Default Database (if no connection exists)
		if (!is_object($this->dbco) && VarX::hasNoData($config)) {

			$init = Env::property('config')['database'];
			if (ArrayX::isKeyNotEmpty($init, $dbKey)) {
				$dba = $init[$dbKey];
				if (ArrayX::isKey($dba, 'name')) {
					unset($dba['name']);
					$this->connect($dba);
				}

				// ~ Create Database (if it doesn't exists)
				if (!$this->database('EXIST', $this->database)) {
					$this->database('CREATE', $this->database);
				}

				// ~ Use Database
				$this->database('ADOPT', $this->database);
			}
		}

		return true;
	}





	// • ----- INIT •
	public function init() {
		// + Create Table (if it doesn't exists)
		if (!$this->isTable($this->table, $this->database)) {
			$this->install($this->table);
			$installFile = SOURCE['setzr'] . $this->table . '.php';
			if (File::is($installFile)) {
				$sql = require($installFile);
				$this->exec($sql);
			}
		}
	}

} // End Of Class ~ RadiologyModel