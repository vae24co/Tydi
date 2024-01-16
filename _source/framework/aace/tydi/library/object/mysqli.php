<?php
/*** oMySQLi ~ MySQLi Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

class oMySQLi extends DatabaseAbstract implements DatabaseInterface {





	// ◇ ----- DISCONNECT •
	public function disconnect(&$mysqli = null) {

		// + Check if $mysqli exist
		if (VarX::isNotEmpty($mysqli) && $this->validate($mysqli, 'DBO')) {
			$mysqli->close();
			unset($mysqli);
			return true;
		}

		// + Check for Object
		elseif ($this->validate($this->dbo, 'DBO')) {
			$this->dbo->close();
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
		return $this->exception($mysqli, $error);
	}
} // End Of Class ~ oMySQLi