<?php
/*** SQLDatabase ~ SQL Database Trait » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

trait SQLDatabaseTrait {

	// ◇ ----- DATABASE • Database Operation
	public function database($req, $database = null, $safely = true) {

		if (VarX::hasNoData($database)) {
			$database = $this->name;
		}


		// + Create database
		if (strtoupper($req) === 'CREATE') {
			$sql = SQLDatabase::create($database, $safely);
		}

		// + Search for a database
		if (strtoupper($req) === 'SEARCH') {
			$sql = SQLDatabase::search($database);
			return $this->query($sql, 'ROW');
		}

		// + Check if database exists
		if (strtoupper($req) === 'EXIST') {
			$row = $this->database('SEARCH', $database);
			if (!empty($row['database']) && $row['database'] == $database) {
				return true;
			}
		}

		// + Adopt (use) database
		if (strtoupper($req) === 'ADOPT' || strtoupper($req) === 'USE') {
			$sql = SQLDatabase::adopt($database);
		}

		// + Drop database
		if (strtoupper($req) === 'DROP') {
			$sql = SQLDatabase::drop($database, $safely);
		}

		// > execute sql query
		if (VarX::hasData($sql)) {
			return $this->exec($sql);
		}
		return false;
	}





	// ◇ ----- CREATE TABLE •
	public function createTable($table, $engine = 'InnoDB', $safely = true) {
		$sql = SQLTable::create($table, $engine, $safely);
		return $this->exec($sql);
	}




	// ◇ ----- FIND TABLE • Find a Table
	public function findTable($table, $database, $response = 'ROW') {
		$sql = SQLTable::search($table, $database);
		return $this->query($sql, $response);
	}




	// ◇ ----- FIND TABLES • Find all Tables
	public function findTables($database) {
		$sql = SQLTable::all($database);
		return $this->query($sql, 'ROWS');
	}





	// ◇ ----- IS TABLE •
	public function isTable($table, $database) {
		$row = $this->findTable($table, $database);
		if (!empty($row['table']) && $row['table'] === $table) {
			return true;
		}
		return false;
	}





	// ◇ ----- renameTable • Rename Table
	public function renameTable($table, $rename) {
		$sql = SQLTable::rename($table, $rename);
		return $this->exec($sql);
	}





	// ◇ ----- reIndexTable • Reset Table Index
	public function reIndexTable($table, $column = 'auid') {
		$sql = SQLTable::reIndex($table, $column);
		return $this->exec($sql);
	}





	// ◇ ----- clearTable • Truncate/Clear Table
	public function clearTable($table, $ignoreFK = true) {
		$sql = SQLTable::truncate($table, $ignoreFK);
		return $this->exec($sql);
	}





	// ◇ ----- dropTable • Delete Table
	public function dropTable($table, $safely = true) {
		$sql = SQLTable::drop($table, $safely);
		return $this->exec($sql);
	}

} // End Of Trait ~ SQLDatabase