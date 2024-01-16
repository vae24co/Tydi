<?php
class AaceModel extends ModelizrAbstract {

	// ∞ PROPERTY •
	// protected $database;





	// ∞ ----- INITIALIZE •
	protected function initialize(mixed $config = []) {

		// + Set Default Database Name
		$this->database = Env::property('config')['database']['aace']['name'];

		// + Connect Default Database (if no connection exists)
		if (!is_object($this->dbco) && VarX::hasNoData($config)) {
			$init = Env::property('config')['database'];
			if (ArrayX::isKeyNotEmpty($init, $this->database)) {
				$dba = $init[$this->database];
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





	// // • ----- INIT •
	// public function init($table) {
	// 	// + Create Table (if it doesn't exists)
	// 	if (!$this->isTable($this->table, $this->database)) {
	// 		$this->install($this->table);
	// 		$installFile = SOURCE['setzr'] . $this->table . '.php';
	// 		if (File::is($installFile)) {
	// 			$sql = require($installFile);
	// 			$this->exec($sql);
	// 		}
	// 	}
	// }





	public function hmo() {
		parent::oTable('hmo', 'USE');
	}

} // End Of Class ~ AaceModel