<?php
/*** Database ~ Database Abstract » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

abstract class DatabaseAbstract {

	// ◇ PROPERTY
	protected $persist;
	protected $driver;
	protected $type;
	protected $host;
	protected $name;
	protected $user;
	protected $password;
	protected $tables;
	protected $guid;
	protected $dbo;





	// ◇ ----- CALL • Non-Existent Method
	public function __call($method, $argument) {

		// + Check & run database object's method ~ [$pdo->query()]
		if (is_object($this->dbo) && method_exists($this->dbo, $method)) {
			return $this->dbo->$method(...$argument);
		}

		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CONSTRUCT •
	public function __construct($config = []) {
		$this->guid = 'AUTO';
		if (VarX::isNotEmpty($config)) {
			$this->ignite($config);
		}
	}





	// ◇ ----- PARAM • Get Parameters from Set » Array
	protected function param($set) {
		$param = SQL::collect($set, 'PARAM');
		if (VarX::hasNoData($param)) {
			return [];
		}
		return $param;
	}





	// ◇ ----- SQL • Get SQL from Set » String
	protected function sql($set) {
		$sql = SQL::collect($set, 'SQL');
		if (VarX::hasNoData($sql)) {
			return '';
		}
		return $sql;
	}





	// ◇ ----- GUID •
	public function guid($guid = null) {
		if (VarX::hasNoData($guid)) {
			$guid = $this->guid;
		}
		return $guid;
	}





	// ◇ ----- ERROR • Error Handler
	public function error($error, $method = '') {
		$error = array_merge($error, ['HAS_ERROR' => true]);
		if (VarX::isNotEmpty($method) && ArrayX::isNotKey($error, 'object')) {
			$method = __CLASS__ . '→' . $method . '()';
			$error['object'] = $method;
		}
		return Tydi::handler(ErrorX::data($error), 'DB_ERROR');
	}




	// ◇ ----- TABLE •
	public function table($req, $table = null) {

		// + Set $tables
		if ($req === 'SET') {
			$this->tables = $table;
		}

		// + Get $table
		if ($req === 'DATA') {
			return $this->tables;
		}

		// + Get $table from $tables
		if ($req === 'IS') {
			if (ArrayX::isKey($this->tables, $table)) {
				return $this->tables[$table];
			}
			return $table;
		}

	}





	// ◇ ----- IGNITE • Initialize, Verify, Connect (and Set $dbo Property)
	public function ignite($config = []) {
		$this->initialize($config);
		$this->verify();
		$this->connect();
		return true;
	}





	// ◇ ----- PROPERTY • Set Specific Properties & Get Properties
	public function property($var, $req) {

		// + Set Properties
		if ($req === 'SET') {
			if (VarX::isNotEmptyArray($var)) {
				$objects = ['host', 'driver', 'persist', 'user', 'password', 'type', 'name', 'tables', 'table'];
				if (count($var) == 1) {
					$label = ArrayX::firstKey($var);
					if (ArrayX::isValue($objects, $label)) {
						$this->$label = $var[$label];
					}
				} else {
					foreach ($objects as $object) {
						if (ArrayX::isKeyNotEmpty($var, $object)) {
							$this->$object = $var[$object];
						}
					}
				}
			}
			return true;
		}

		// + Get Properties
		if ($req === 'GET') {
		}
	}





	// ◇ ----- CREATE • Create Record
	public function create($table, $input, $yield = 'puid', $guid = null) {
		$guid = $this->guid($guid);
		if ($this->type === 'SQL') {
			$set = SQL::create($table, SQL::guid($input, $guid));
			return $this->prepare($this->sql($set), $yield, $this->param($set));
		}
		return false;
	}





	// ◇ ----- SEARCH • Find & Read Record
	public function search($table, $filter, $column, $limit = 20, $yield = 'ROWS', $sort = 'SORT') {
		if ($this->type === 'SQL') {
			$set = SQL::search($table, $filter, $column, $limit, $sort);
			return $this->prepare($this->sql($set), $yield, $this->param($set));
		}
		return false;
	}





	// ◇ ----- EXIST • Check if Record Exist » BOOLEAN
	public function exist($table, $filter, $column = 'auid') {
		if (VarX::isArray($column)) {
			if (ArrayX::isKeyNumeric($column)) {
				$column = ArrayX::firstValue($column);
			} else {
				$column = ArrayX::firstKey($column);
			}
		}
		$row = $this->search($table, $filter, $column, 1);
		if (DataQ::isRowColumn($row, $column)) {
			return true;
		}
		return false;
	}





	// ◇ ----- COUNT • Count Record Found » NUMERIC
	public function count($table, $filter, $column = 'auid') {
		return $this->search($table, $filter, $column, 'NO_LIMIT', 'COUNT', 'NO_SORT');
	}





	// ◇ ----- UPDATE • Update Record
	public function update($table, $filter, $input, $yield = 'BOOL', $limit = 1) {
		if ($this->type === 'SQL') {
			$set = SQL::update($table, $filter, $input, $limit);
			$sql = $this->sql($set);
			$param = $this->param($set);
			if ($yield === 'BOOL' || $yield === 'COUNT' || $yield === 'STRING') {
				return $this->prepare($sql, $yield, $param);
			} else {
				$update = $this->prepare($sql, 'COUNT', $param);
				if (VarX::isNumeric($update) && $update > 0) {
					if ($yield === 'ROW' || $yield === 'ROWS') {
						$column = ArrayX::keys($filter);
					} else {
						$column = $yield;
					}
					if ($limit == 1) {
						$yield = 'ROW';
					} else {
						$yield = 'ROWS';
					}
					return $this->search($table, $filter, $column, $limit, 'NO_SORT', $yield);
				}
				return $update;
			}
		}
		return false;
	}





	// ◇ ----- DELETE • Delete Record
	public function delete($table, $filter, $limit = 1, $yield = 'BOOL') {
		if ($this->type === 'SQL') {
			$set = SQL::delete($table, $filter, $limit);
			return $this->prepare($this->sql($set), $yield, $this->param($set));
		}
		return false;
	}










	// ◇ ----- oCREATE •
	// public function oCreate($input, $response = 'puid', $guid = null) {
	// 	return $this->create($this->table, $input, $this->oGUID($guid), $response);
	// }





	// ◇ ----- oFIND • Find record in table
	// public function oFind($filter, $column = '*', $response = 'ROWS', $limit = 'NO_LIMIT', $sort = 'SORT') {
	// 	return $this->search($this->table, $filter, $column, $limit, $sort, $response);
	// }





	// ◇ ----- oFIND ONE • Find one record matching filter in table
	// public function oFindOne($filter, $column = '*', $sort = 'SORT') {
	// 	return $this->search($this->table, $filter, $column, 1, $sort, 'ROW');
	// }





	// ◇ ----- oFIND EVERY • Find every record that match filter in table
	// public function oFindEvery($filter, $column = '*', $sort = 'SORT') {
	// 	return $this->search($this->table, $filter, $column, 'NO_LIMIT', $sort, 'ROWS');
	// }





	// ◇ ----- oFIND ALL • Find all record in table
	// public function oFindAll($column = '*', $sort = 'SORT') {
	// 	return $this->search($this->table, 'NO_FILTER', $column, 'NO_LIMIT', $sort, 'ROWS');
	// }





	// ◇ ----- oEXIST • Check if record exist in table
	// public function oExist($filter, $column = 'auid') {
	// 	return $this->exist($this->table, $filter, $column);
	// }





	// ◇ ----- oCOUNT •
	// public function oCount($filter, $column = 'auid') {
	// 	return $this->count($this->table, $filter, $column);
	// }





	// ◇ ----- oUPDATE •
	// public function oUpdate($filter, $input, $response = 'COUNT', $limit = 'NO_LIMIT') {
	// 	$find = $this->oExist($filter);
	// 	if (VarX::isFalse($find)) {
	// 		return 'CANT_UPDATE';
	// 	}

	// 	$update = $this->update($this->table, $filter, $input, $limit, $response);
	// 	if ($response === 'COUNT' && VarX::isZero($update)) {
	// 		return 'NO_UPDATE';
	// 	} elseif ($response === 'BOOL' && VarX::isFalse($update)) {
	// 		return 'NO_UPDATE';
	// 	}

	// 	return $update;
	// }





	// ◇ ----- oUPDATE ONE •
	// public function oUpdateOne($filter, $input, $response = 'COUNT') {
	// 	return $this->oUpdate($filter, $input, $response, 1);
	// }





	// ◇ ----- oUPDATE EVERY •
	// public function oUpdateEvery($filter, $input, $response = 'COUNT') {
	// 	return $this->oUpdate($filter, $input, $response, 'NO_LIMIT');
	// }





	// ◇ ----- oUPDATE ALL •
	// public function oUpdateAll($input, $response = 'COUNT') {
	// 	return $this->oUpdate('NO_FILTER', $input, $response, 'NO_LIMIT');
	// }





	// ◇ ----- oSAVE •
	// public function oSave($filter, $column, $input, $response = 'COUNT', $guid = null) {
	// 	$find = $this->exist($this->table, $filter);
	// 	if (VarX::isFalse($find)) {
	// 		return $this->oCreate($input, $response, $guid);
	// 	}

	// 	$save = $this->update($this->table, $filter, $input, 1, $response);
	// 	if ($response === 'COUNT' && VarX::isZero($update)) {
	// 		return 'NO_SAVE';
	// 	} elseif ($response === 'BOOL' && VarX::isFalse($update)) {
	// 		return 'NO_SAVE';
	// 	}

	// 	return $save;
	// }





	// ◇ ----- oDELETE •
	// public function oDelete($filter, $response = 'COUNT', $limit = 'NO_LIMIT') {
	// 	$find = $this->oExist($filter);
	// 	if (VarX::isFalse($find)) {
	// 		return 'CANT_DELETE';
	// 	}

	// 	$delete = $this->delete($this->table, $filter, $limit, $response);
	// 	if ($response === 'COUNT' && VarX::isZero($delete)) {
	// 		return 'NO_DELETE';
	// 	} elseif ($response === 'BOOL' && VarX::isFalse($delete)) {
	// 		return 'NO_DELETE';
	// 	}

	// 	return $delete;
	// }










	// ◇ ----- CREATE TABLE •
	// public function createTable($table, $engine = 'InnoDB', $safely = true) {
	// 	if ($this->type === 'SQL') {
	// 		$sql = SQLTable::create($table, $engine, $safely);
	// 		return $this->exec($sql);
	// 	}
	// 	return false;
	// }





	// ◇ ----- FIND TABLE • Find a Table
	// public function findTable($table, $database = null, $response = 'ROW') {

	// 	if (VarX::hasNoData($database)) {
	// 		$database = $this->name;
	// 	}

	// 	if ($this->type === 'SQL') {
	// 		$sql = SQLTable::search($table, $database);
	// 		return $this->query($sql, $response);
	// 	}
	// 	return false;
	// }





	// ◇ ----- FIND TABLES • Find all Tables
	// public function findTables($database = null) {

	// 	if (VarX::hasNoData($database)) {
	// 		$database = $this->name;
	// 	}

	// 	if ($this->type === 'SQL') {
	// 		$sql = SQLTable::all($database);
	// 		return $this->query($sql, 'ROWS');
	// 	}
	// 	return false;
	// }





	// ◇ ----- IS TABLE •
	// public function isTable($table, $database = null) {
	// 	$result = $this->findTable($table, $database);
	// 	if (!empty($result['table']) && $result['table'] === $table) {
	// 		return true;
	// 	}
	// 	return false;
	// }






	// ◇ ----- RENAME TABLE •
	// public function renameTable($table, $rename) {
	// 	if ($this->type === 'SQL') {
	// 		$sql = SQLTable::rename($table, $rename);
	// 		return $this->exec($sql);
	// 	}
	// 	return false;
	// }





	// ◇ ----- RE INDEX TABLE • Reset Table Index
	// public function reIndexTable($table, $column = 'auid') {
	// 	if ($this->type === 'SQL') {
	// 		$sql = SQLTable::reIndex($table, $column);
	// 		return $this->exec($sql);
	// 	}
	// 	return false;
	// }





	// ◇ ----- WIPE TABLE • Reset (truncate) Table
	// public function wipeTable($table, $ignoreFK = true) {
	// 	if ($this->type === 'SQL') {
	// 		$sql = SQLTable::wipe($table, $ignoreFK);
	// 		return $this->exec($sql);
	// 	}
	// 	return false;
	// }





	// ◇ ----- DROP TABLE • Delete Table
	// public function dropTable($table, $safely = true) {
	// 	if ($this->type === 'SQL') {
	// 		$sql = SQLTable::drop($table, $safely);
	// 		return $this->exec($sql);
	// 	}
	// 	return false;
	// }










	// ◇ ----- DATABASE • Database Operation
	// public function database($req, $database = null, $safely = true) {

	// 	if (VarX::hasNoData($database)) {
	// 		$database = $this->name;
	// 	}

	// 	if ($this->type === 'SQL') {

	// 		// * create database
	// 		if (strtoupper($req) === 'CREATE') {
	// 			$sql = SQLDatabase::create($database, $safely);
	// 		}

	// 		// * search for a database
	// 		if (strtoupper($req) === 'SEARCH') {
	// 			$sql = SQLDatabase::search($database);
	// 			return $this->query($sql, 'ROW');
	// 		}

	// 		// * find a database
	// 		if (strtoupper($req) === 'FIND') {
	// 			$row = $this->database('SEARCH', $database);
	// 			if (!empty($row['database']) && $row['database'] == $database) {
	// 				return true;
	// 			}
	// 		}

	// 		// * adopt (use) database
	// 		if (strtoupper($req) === 'ADOPT') {
	// 			$sql = SQLDatabase::adopt($database);
	// 		}

	// 		// * drop database
	// 		if (strtoupper($req) === 'DROP') {
	// 			$sql = SQLDatabase::drop($database, $safely);
	// 		}

	// 		// > execute sql query
	// 		if (VarX::hasData($sql)) {
	// 			return $this->exec($sql);
	// 		}
	// 	}
	// 	return false;
	// }











	// ◇ ----- ABSTRACT METHOD •
	abstract public function prepare($sql, $yield, array $param = [], $dbo = null);
	abstract public function query($sql, $yield, $dbo = null);
	abstract public function commit($yield = null, $dbo = null);
	abstract public function transact($dbo = null);
	abstract public function rollback($dbo = null);

} // End Of Abstract ~ Database