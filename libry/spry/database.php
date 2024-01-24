<?php //*** DatabaseX » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

class DatabaseX {

	// • protected
	private static $pdo;





	// • ==== call → handler - undefined method » error
	public function __call($method, $argument) {
		$caller = __CLASS__ . '→' . $method . '()';
		return DebugX::oversight(__CLASS__, 'method unreachable', $caller);
	}





	// • ==== callStatic → handler - undefined static method » error
	public static function __callStatic($method, $argument) {
		$caller = __CLASS__ . '::' . $method . '()';
		return DebugX::oversight(__CLASS__, 'static: method unreachable', $caller);
	}





	// • ==== exception → ... »
	private static function exception($e, $label = 'PDO Error') {
		$code = $e->errorInfo[1];
		$message = $e->errorInfo[2];
		return DebugX::oversight($label, $code, $message);
		// return DebugX::oversight($label, $e->getMessage(), $e->errorInfo[1]);
	}





	// • ==== connect → ... »
	public static function connect($database, $username, $password, $host = 'localhost') {
		try {
			$dsn = "mysql:host=$host;dbname=$database";
			self::$pdo = new PDO($dsn, $username, $password);
			self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			return self::exception($e, 'Connection Failed');
		}
	}





	// • ==== create → ... »
	public static function create($data, $table) {
		$data = DataX::create($data);
		$columns = implode(", ", array_keys($data));
		$values = ":" . implode(", :", array_keys($data));

		$sql = "INSERT INTO $table ($columns) VALUES ($values)";
		$stmt = self::$pdo->prepare($sql);

		try {
			$stmt->execute($data);
			return true;
		} catch (PDOException $e) {
			return self::exception($e);
		}
	}





	// • ==== find → ... »
	public function find($table, $columns, $condition = null) {
		$sql = "SELECT $columns FROM $table";
		if (!empty($condition)) {
			$sql .= " WHERE $condition";
		}
		$stmt = self::$pdo->query($sql);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}





	// • ==== findAll → ... »
	public static function findAll($table, $condition = null){
		return self::find($table, '*', $condition);
	}





	// • ==== update → ... »
	public function update($table, $data, $condition) {
		$set = [];
		foreach ($data as $key => $value) {
			$set[] = "$key = :$key";
		}

		$setClause = implode(", ", $set);
		$query = "UPDATE $table SET $setClause WHERE $condition";
		$stmt = self::$pdo->prepare($query);

		try {
			$stmt->execute($data);
			return true;
		} catch (PDOException $e) {
			return self::exception($e);
		}
	}





	// • ==== save → ... »
	public function save($table, $data, $condition) {
		$record = $this->findAll($table, $condition);
		if (empty($record)) {
			return $this->create($table, $data);
		} else {
			return $this->update($table, $data, $condition);
		}
	}





	// • ==== delete → ... »
	public function delete($table, $condition) {
		$query = "DELETE FROM $table WHERE $condition";
		$stmt = self::$pdo->prepare($query);

		try {
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			return self::exception($e);
		}
	}





	// • ==== disconnect → ... »
	public function disconnect() {
		self::$pdo = null;
	}

} //> end of DatabaseX