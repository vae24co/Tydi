<?php
/*** oPDO ~ MySQLi Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

class oPDO extends DatabaseAbstract implements DatabaseInterface {

	// ◇ ----- VERIFY •
	public function verify() {
		if (VarX::isEmpty($this->host)) {
			return $this->error(['code' => 'C428DB', 'detail' => 'Connection :: Server Required']);
		} elseif (VarX::isEmpty($this->type)) {
			return $this->error(['code' => 'C428DB', 'message' => 'Connection :: Type Required']);
		} elseif (VarX::isEmpty($this->persist)) {
			return $this->error(['code' => 'C428DB', 'message' => 'Connection :: Persist Required']);
		} elseif (VarX::isEmpty($this->user)) {
			return $this->error(['code' => 'C428DB', 'message' => 'Connection :: User Required']);
		} elseif (VarX::isEmpty($this->password)) {
			return $this->error(['code' => 'C428DB', 'message' => 'Connection :: Password Required']);
		} elseif (VarX::isEmpty($this->driver)) {
			return $this->error(['code' => 'C428DB', 'message' => 'Connection :: Driver Required']);
		}
		return true;
	}





	// ◇ ----- INITIALIZE •
	public function initialize(array $config = []) {

		// + Set available properties
		if (VarX::isNotEmptyArray($config)) {
			$this->property($config, 'SET');
		}

		// + Set driver if unavailable
		if (VarX::isNull($this->driver)) {
			$this->driver = 'PDO';
		}

		// + Set type
		if (VarX::isNull($this->type)) {
			$this->type = 'SQL';
		}

		// + Set host
		if (VarX::isNull($this->host) && $this->type == 'SQL') {
			$this->host = 'localhost';
		}

		// + Set persistence
		if (VarX::isNull($this->persist)) {
			$this->persist = false;
		}

		return true;
	}





	// ◇ ----- EXCEPTION • PDO Class Error Handler
	protected function exception($object, array $error, $extra = []) {
		if (!empty($object)) {
			if (!empty($object->getCode())) {
				$error['code'] = 'C' . $object->getCode() . 'DB';
			}

			$error['detail']['summary'] = $object->errorInfo[2];

			if (!empty($object->getMessage())) {
				$error['detail']['reason'] = $object->getMessage();
			}
			#$error['detail']['trace'] = $object->getTrace();
			#$error['detail']['previous'] = $object->getPrevious();
		}
		if (isset($extra['SQL'])) {
			$error['detail']['sql'] = $extra['SQL'];
		}
		if (isset($extra['PARAM'])) {
			$error['detail']['param'] = $extra['PARAM'];
		}
		return $this->error($error);
	}





	// ◇ ----- OPEN MYSQL •
	protected function openMySQL() {
		if (VarX::isEmpty($this->name)) {
			$dsn = 'mysql:host=' . $this->host . ';charset=utf8';
		} else {
			$dsn = 'mysql:dbname=' . $this->name . ';host=' . $this->host . ';charset=utf8';
		}
		$option = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];
		if ($this->persist === true) {
			$option[PDO::ATTR_PERSISTENT] = true;
		}
		try {
			$pdo = new PDO($dsn, $this->user, $this->password, $option);
			$pdo->exec("SET time_zone = '" . Time::is('GMT') . "'");
		} catch (PDOException $error) {
			return $this->exception($error, ['object' => __METHOD__]);
		}

		// * Clear user, password & host from class properties
		unset($this->user, $this->password, $this->host);

		return $pdo;
	}





	// ◇ ----- SEQUEL •
	protected function sequel($yield, &$stmt, $sql, $dataset, &$execute) {

		if ($yield === 'STRING') {
			$yield = 'COUNT';
		}

		// * The Number of Rows Affected
		$rowCount = $stmt->rowCount();

		// * Response is RAW
		if ($yield === 'RAW') {
			$result['SQL'] = $sql;
			$result['STMT'] = $stmt;
			$result['DATA'] = $dataset;
			$result['EXEC'] = $execute;
			$result['COUNT'] = $rowCount;
			return $result;
		}


		// * Response is STMT
		elseif ($yield === 'STMT') {
			return $stmt;
		}


		// * Response is EXEC
		elseif ($yield === 'EXEC') {
			return $execute;
		}


		// * PDOStatement is valid
		elseif (self::validate($stmt, 'PDOStatement')) {

			// > COUNT
			if ($yield === 'COUNT') {
				$result = $rowCount;
			}

			// > BOOL
			elseif ($yield === 'BOOL') {
				if (!StringX::begin($sql, 'SELECT')) {
					if ($rowCount > 0) {
						return true;
					}
					return false;
				}
			}


			if (StringX::begin($sql, 'SELECT')) {
				// > Fetch Row
				if ($yield === 'ROW') {
					$result = $stmt->fetch();
				}

				// > Fetch All Rows » Array (empty or with data)
				else {
					$result = $stmt->fetchAll();
				}
			}

			// * For Insert Record
			if (StringX::contain($sql, 'INSERT INTO')) {
				if ($yield === 'auid') {
					return $this->lastEntryID();
				}
				$result = DataQ::unbind($dataset);
			}

			if (ArrayX::isMultiAndKeyNumeric($result)) {
				$result = ArrayX::reKeysNumeric($result);
			}
		}


		// * Response :: COUNT
		if ($yield === 'COUNT') {
			if (VarX::isNumeric($result)) {
				return (int) $result;
			} elseif (ArrayX::isMultiAndKeyNumeric($result)) {
				$count = count($result);
				return (int) $count;
			} elseif (VarX::isNotEmptyArray($result)) {
				return 1;
			}
			return 0;
		}

		// * Response :: BOOL
		elseif ($yield === 'BOOL') {
			if (VarX::isBoolean($result)) {
				return $result;
			} elseif (VarX::isNotEmptyArray($result)) {
				return true;
			}
			return false;
		}

		// * Response :: ROW (empty or with values)
		elseif ($yield === 'ROW') {
			if (ArrayX::isMultiAndKeyNumeric($result)) {
				return ArrayX::firstValue($result);
			} elseif (VarX::isArray($result)) {
				return $result;
			}
			return 'NO_RESULT';
		}

		// * Response :: ROWS » ARRAY
		elseif ($yield === 'ROWS') {
			if (ArrayX::isMultiAndKeyNumeric($result)) {
				return $result;
			} elseif (VarX::isNotEmptyArray($result)) {
				return [1 => $result];
			}
			return 'NO_RESULT';
		}

		// * Response :: FIELD & FIELDS for INSERT
		elseif (VarX::isArray($result) && StringX::contain($sql, 'INSERT INTO')) {
			return DataQ::collect($result, $yield, false);
		}

		// * Return
		if (VarX::isEmpty($result)) {
			$result = 'NO_RESULT';
		}

		return $result;
	}





	// ◇ ----- VALIDATE •
	public function validate($object, $req) {
		if (is_object($object)) {
			if ($req === 'DBO' && $object instanceof PDO) {
				return true;
			} elseif ($req === 'PDOStatement' && $object instanceof PDOStatement) {
				return true;
			}
		}
		return false;
	}





	// ◇ ----- DBO •
	public function dbo($var = null) {

		// + Return DBO
		if (VarX::hasNoData($var)) {
			return $this->dbo;
		}

		// + Check if $this->dbo is valid
		elseif ($var === 'VALIDATE') {
			return $this->validate($this->dbo, 'DBO');
		}

		// + Set DBO
		elseif ($this->validate($var, 'DBO')) {
			$this->dbo = $var;
			return $this->dbo;
		}

		return false;
	}





	// ◇ ----- CONNECT • Connect & Set $dbo
	public function connect(&$pdo = null) {
		if (VarX::isNotEmpty($pdo)) {
			if ($this->validate($pdo, 'DBO')) {
				$this->dbo = $pdo;
			}
			return $this->exception($pdo, ['code' => 'C498DB']);
		}

		if ($this->type === 'SQL') {
			$this->dbo = $this->openMySQL();
		}

		return $this->dbo;
	}





	// ◇ ----- EXECUTE •
	protected function execute(&$stmt, $dataset, $sql) {
		try {
			if (VarX::isEmpty($dataset)) {
				$execute = $stmt->execute();
			} elseif (!ArrayX::isMulti($dataset)) {
				$execute = $stmt->execute($dataset);
			} else {
				//TODO: To review block!
				foreach ($dataset as $param) {
					$execute[] = $stmt->execute($param);
				}
			}
		}

		//...Throw Exception Error!
		catch (PDOException $e) {
			return $this->exception($e, [], ['SQL' => $sql, 'PARAM' => $dataset]);
		}

		return $execute;
	}






	// ◇ ----- PREPARE • Prepares and executes SQL statement with placeholders
	public function prepare($sql, $yield, array $param = [], $dbo = null) {
		$pdo = $this->dbo($dbo);
		try {
			$stmt = $pdo->prepare($sql);
		} catch (PDOException $e) {
			$error = ['message' => 'SQL Preparation Failed', 'object' => __METHOD__];
			return $this->exception($e, $error, ['SQL' => $sql, 'PARAMSET' => $param]);
		}
		$execute = $this->execute($stmt, $param, $sql);
		return $this->sequel($yield, $stmt, $sql, $param, $execute);
	}





	// ◇ ----- EXEC •
	public function exec($sql, $dbo = null) {

		// * $sql cannot be empty
		if (VarX::isEmpty($sql)) {
			$error = ['code' => 'C428DE', 'object' => __METHOD__, 'detail' => 'Argument:: SQL Required'];
			return $this->error($error);
		}

		// * Database Connection
		$pdo = $this->dbo($dbo);

		try {
			//...Single string SQL query
			if (VarX::stringAcceptable($sql)) {
				$result = $pdo->exec($sql);
			}

			//...Array SQL query
			elseif (VarX::isArray($sql)) {
				foreach ($sql as $i => $query) {
					$result[$i] = $pdo->exec($query);
				}
			}
		}

		//...Throw Exception Error!
		catch (PDOException $e) {
			return $this->exception($e, ['message' => 'SQL Exec Failed', 'object' => __METHOD__], ['SQL' => $sql]);
		}


		// * Return $result
		return $result;
	}





	// ◇ ----- QUERY • Prepares and executes an SQL statement without placeholders
	public function query($sql, $yield, $dbo = null) {

		// * $sql cannot be empty
		if (VarX::isEmpty($sql)) {
			return $this->error(['code' => 'C428DE', 'object' => __METHOD__, 'detail' => 'Argument:: SQL Required']);
		}

		// * $yield cannot be empty
		if (VarX::isEmpty($yield)) {
			return $this->error(['code' => 'C428DE', 'object' => __METHOD__, 'detail' => 'Argument:: REQ is Required']);
		}

		//...Database connection
		$pdo = $this->dbo($dbo);

		try {
			//TODO: When $SQL is an array
			$stmt = $pdo->query($sql);
		}

		//...Throw Exception Error!
		catch (PDOException $e) {
			return $this->exception($e, ['message' => 'SQL Query Failed', 'object' => __METHOD__], ['SQL' => $sql]);
		}

		return $this->sequel($yield, $stmt, $sql, [], $stmt);
	}





	// ◇ ----- MULTI • Prepare and execute multiple SQL statements »
	public function multi(array $querySet, $dbo = null) {

		$pdo = $this->dbo($dbo);

		try {
			$pdo->beginTransaction();

			if (ArrayX::isMultiAndKeyNumeric($querySet)) {

				foreach ($querySet as $key => $query) {
					if (ArrayX::isKeyNotEmpty($query[$key], 'SQL')) {
						$stmt = $pdo->prepare($query[$key]['SQL']);
					}
					if (ArrayX::isKeyNotEmpty($query[$key], 'PARAMSET')) {
						$stmt->execute($query[$key]['PARAMSET']);
					} else {
						$stmt->execute();
					}
				}

			} elseif (ArrayX::is($querySet)) {
				foreach ($querySet as $query) {
					if (ArrayX::isKeyNotEmpty($query, 'SQL')) {
						$stmt = $pdo->prepare($query['SQL']);
					}
					if (ArrayX::isKeyNotEmpty($query, 'PARAMSET')) {
						$stmt->execute($query['PARAMSET']);
					} else {
						$stmt->execute();
					}
				}
			}

			$pdo->commit();
		} catch (PDOException $error) {
			$pdo->rollBack();
			$error = get_object_vars($error);
			return $this->exception($pdo, $error, $querySet);
		}
	}





	// ◇ ----- COMMIT • Commit Changes or Set Autocommit on or off
	public function commit($yield = null, $dbo = null) {
		$pdo = $this->dbo($dbo);
		if ($yield === 'AUTO') {
			return $pdo->autocommit();
		} elseif ($yield === 'OFF') {
			return $pdo->autocommit(false);
		}
		return $pdo->commit();
	}





	// ◇ ----- TRANSACT • Begin a transaction, turning off autocommit
	public function transact($dbo = null) {
		$pdo = $this->dbo($dbo);
		return $pdo->beginTransaction();
	}





	// ◇ ----- ROLLBACK	• Rollback Changes
	public function rollback($dbo = null) {
		$pdo = $this->dbo($dbo);
		return $pdo->rollBack();
	}





	// ◇ ----- LAST ID • Return last insert ID
	public function lastEntryID($dbo = null) {
		$pdo = $this->dbo($dbo);
		return ['auid' => $pdo->lastInsertId()];
	}





	// ◇ ----- DISCONNECT •
	public function disconnect(&$pdo = null) {

		// + Check if $pdo exist
		if (VarX::isNotEmpty($pdo) && $this->validate($pdo, 'DBO')) {
			unset($pdo);
			return true;
		}

		// + Check for Object
		elseif ($this->validate($this->dbo, 'DBO')) {
			$unset = ['dbo', 'host', 'name', 'password', 'persist', 'type', 'driver', 'tables', 'table', 'guid'];
			foreach ($unset as $property) {
				if (isset($this->$property)) {
					unset($this->$property);
				}
			}
			return true;
		}

		// + Return :: Error
		$error = ['code' => 'C498DB', 'title' => 'Disconnection Failed', 'message' => 'No Valid Connection', 'object' => 'PDO'];
		return $this->exception($pdo, $error);
	}

} // End Of Class ~ oPDO