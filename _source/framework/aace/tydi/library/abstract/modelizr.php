<?php
/*** Modelizr ~ Modelizer Abstract » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

abstract class ModelizrAbstract {

	// ◇ USE •
	use SQLDatabaseTrait;
	use CRUDTrait;





	// ◇ PROPERTY
	protected $dbco;
	protected $table;
	protected $database;





	// ◇ ----- CALL • Handle Non-Existent Method »
	public function __call($method, $argument) {

		// + Check :: Run database class's method ~ [$oPDO->query()]
		if (is_object($this->dbco) && method_exists($this->dbco, $method)) {
			return $this->dbco->$method(...$argument);
		}

		// + Return :: Error
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CONSTRUCT •
	public function __construct($config = [], $table = null) {
		if (VarX::isNotEmptyArray($config)) {

			// + Set database class object (if available)
			if (ArrayX::isKeyNotEmpty($config, 'dbco') && is_object($config['dbco'])) {
				$dbco = DataQ::extricateValue($config, 'dbco');
				$this->dbco($dbco);
			}

			// + Connect to database (if database config available)
			elseif (ArrayX::isKey($config, 'database') && VarX::isNotEmptyArray($config['database'])) {
				$dba = DataQ::extricateValue($config, 'database');
				$this->connect($dba);
			}
		}

		// + Set Table
		if (VarX::hasData($table)) {
			$this->oTable($table, 'SET');
		}

		// + Run Initialize of Child's Class
		$this->initialize($config);
	}





	// ◇ ----- CONNECT • Create Database Connection
	public function connect(array $dba) {
		$driver = DataQ::extricateValue($dba, 'driver');
		SetQ::isNullOrEmpty($driver, 'PDO');

		// + PDO class connection
		if ($driver === 'PDO') {
			$this->dbco = new oPDO($dba);
		}

		// + MySQLi class connection
		if ($driver === 'MySQLi') {
			#$this->dbco = new oMySQLi($dba);
		}

		return $this->dbco;
	}





	// ◇ ----- DBCO • Set/Get Database Class Object
	public function dbco(&$var = null) {

		// + Set DBCO
		if (is_object($var)) {
			$this->dbco = $var;
			return true;
		}

		// + Get DBCO
		elseif (VarX::isEmpty($var) && VarX::is($this->dbco)) {
			return $this->dbco;
		}

		return false;
	}





	// ◇ ----- MODEL •
	public function model($model, $method, ...$argument) {
		if (StringX::begin($method, 'o')) {
			$this->oTable(strtolower($model), 'USE');
			if (VarX::hasData($argument)) {
				return $this->$method(...$argument);
			}
			return $this->$method();
		} else {
			$table = $this->oTable(strtolower($model), 'IS');
			if (VarX::hasData($argument)) {
				return $this->$method($table, ...$argument);
			}
			return $this->$method($table);
		}
	}





	// ◇ ----- DISCONNECT • Destroy Database Connection
	public function disconnect(&$dbco = null) {
		if (VarX::hasData($dbco)) {
			unset($dbco);
		} elseif (is_object($this->dbco)) {
			$this->dbco->disconnect();
			unset($this->dbco);
		}
		return true;
	}





	// ◇ ----- TABLE •
	public function oTable($table = 'TABLE', $req = 'DATA') {

		// + Get $table
		if ($table === 'TABLE' && $req === 'DATA') {
			return $this->table;
		}

		// + DBCO & Tables
		elseif (is_object($this->dbco)) {

			// * Get $tables
			if ($table === 'TABLES' && $req === 'DATA') {
				return $this->dbco->table('DATA');
			}

			// * Set $tables
			if ($req === 'SET' && ArrayX::isNotEmpty($table)) {
				$this->dbco->table('SET', $table);
			}

			// * Set $table
			elseif ($req === 'SET' && VarX::stringAcceptable($table)) {
				$this->table = $table;
			}

			// * Get $table from $tables
			if ($req === 'IS') {
				return $this->dbco->table('IS', $table);
			}

			// * Use $table
			if ($req === 'USE') {
				$this->table = $this->dbco->table('IS', $table);
				return true;
			}
		}

		return false;
	}





	// ◇ ----- oSETUP •
	public function oSetup($table) {
		if (!$this->isTable($table, $this->database)) {
			$install = SOURCE['setzr'] . 'install' . DS . $table . '.php';
			if (File::is($install)) {
				$this->exec(require($install));
			}

			$sqldata = SOURCE['setzr'] . 'sqldata' . DS . $table . '.php';
			if (File::is($sqldata)) {
				$this->exec(require($sqldata));
			}
		}
		return true;
	}





	// ◇ ----- oMODEL •
	public function oModel($table) {
		$table = $this->oTable($table, 'IS');
		if ($this->oSetup($table)) {
			$this->oTable($table, 'USE');
		}
		return $this;
	}





	// ◇ ----- ABSTRACT •
	abstract protected function initialize($config = null);

} // End Of Abstract ~ Modelizr