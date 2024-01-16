<?php
/*** SQL ~ SQL Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

declare(strict_types=1);

class SQL {

	// ◇ ----- CALL • Non-Existent Method » Error
	public function __call($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CALL_STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- FILTER •  SQL/PARAM from (filter, param, dataset)
	public static function collect($set, $flag) {
		if (!empty($set)) {
			if ($flag === 'SQL' && !empty($set['SQL'])) {
				return $set['SQL'];
			}
			if ($flag === 'PARAM' && !empty($set['PARAM'])) {
				return $set['PARAM'];
			}
		}
		return false;
	}





	// ◇ ----- COLUMN •
	public static function column($var) {
		$sql = '';

		if (VarX::isNotEmpty($var)) {
			$column = '';
		}

		//...String
		if (VarX::stringAcceptable($var)) {
			if (StringX::contain($var, '*')) {
				$column = '*';
			} elseif (StringX::contain($var, '`')) {
				$column = trim($var) . ' ';
			} elseif (StringX::contain($var, ',')) {
				$columns = StringX::toArray($var, ',');
				foreach ($columns as $field) {
					$column .= self::column($field) . ', ';
				}
				$column = StringX::cropEnd($column, ',');
			} else {
				$column .= ' `' . trim($var) . '` ';
			}
		}

		//...Array with numeric key
		elseif (ArrayX::isKeyNumeric($var)) {
			foreach ($var as $label) {
				$column .= '`' . trim($label) . '`, ';
			}
			$column = StringX::cropEnd($column, ',');
		}

		//...Array (with text index)
		elseif (ArrayX::is($var)) {
			foreach ($var as $label => $value) {
				if (is_numeric($label)) {
					$column .= '`' . trim($value) . '`, ';
				} else {
					$column .= '`' . trim($label) . '` ';
					if (!empty($value)) {
						$column .= 'AS `' . $value . '`';
					}
					$column .= ', ';
				}
			}
			$column = StringX::cropEnd($column, ',');
		}


		//...Column & Return SQL formatted
		if (VarX::isNotEmpty($column)) {
			if (StringX::contain($column, ':')) {
				$column = StringX::swap($column, ':', '');
			}
			$sql = trim($column);
		}
		return $sql;
	}





	// ◇ ----- LIMIT •
	public static function limit($var) {
		$sql = '';
		if (VarX::isNotEmpty($var)) {

			if ($var === 'NO_LIMIT') {
				return '';
			} elseif (VarX::isNumeric($var)) {
				$limit = $var;
			} elseif (VarX::stringAcceptable($var)) {
				if (StringX::contain($var, 'LIMIT')) {
					return trim($var);
				} elseif (StringX::contain($var, ',')) {
					$limit = $var;
				}
			}

			//...Array
			elseif (ArrayX::is($var)) {
				if (ArrayX::isKeyNotEmpty($var, 'LIMIT')) {
					$limit = $var['LIMIT'];
				} elseif (ArrayX::isKeyNumeric($var)) {
					$limit = '';
					foreach ($var as $value) {
						$limit .= $value . ', ';
					}
					$limit = StringX::cropEnd($limit, ',');
				}
			}

			//...Limit & Return SQL formatted
			if (VarX::isNotEmpty($limit)) {
				$sql = 'LIMIT ' . trim($limit);
			}
		}

		return $sql;
	}






	// ◇ ----- OFFSET •
	public static function offset($var) {
		$sql = '';
		if (VarX::isNotEmpty($var)) {
			if (VarX::isNumeric($var)) {
				$offset = $var;
			} elseif (VarX::stringAcceptable($var) && StringX::contain($var, 'OFFSET')) {
				return trim($var);
			}

			//...Array
			elseif (ArrayX::is($var)) {
				if (ArrayX::isKeyNotEmpty($var, 'OFFSET') && VarX::isNumeric($var['OFFSET'])) {
					$offset = $var['OFFSET'];
				} elseif (ArrayX::isKeyNumeric($var)) {
					$offset = ArrayX::firstValue($var);
				}
			}


			//...Offset & Return SQL formatted
			if (VarX::isNotEmpty($offset)) {
				$sql = 'OFFSET ' . trim($offset);
			}
		}
		return $sql;
	}





	// ◇ ----- SORT •
	public static function sorting($var = 'auid', $order = 'ASC') {
		$sql = '';

		if (VarX::isNotEmpty($var)) {
			//...No Sorting
			if ($var == 'NO_SORT') {
				return '';
			}

			//...Default Sorting (Framework)
			elseif ($var === 'SORT') {
				$sort = 'ORDER BY `auid` DESC';
			}

			//TODO: Test & Improve
			elseif (ArrayX::is($var) && (ArrayX::isValue($var, 'ASC') || ArrayX::isValue($var, 'DESC'))) {
				$sort = '';
				foreach ($var as $input => $order) {
					$sort .= self::column($input) . ' ' . $order . ', ';
				}
				$sort = StringX::cropEnd($sort, ',');
			} else {
				$colum = self::column($var);
				if (VarX::isNotEmpty($colum)) {
					$sort = 'ORDER BY ' . $colum;
					if (VarX::isNotEmpty($order)) {
						$sort .= ' ' . $order;
					}
				}
			}

			//...Offset & Return SQL formatted
			if (VarX::isNotEmpty($sort)) {
				$sql = trim($sort);
			}
		}
		return $sql;
	}





	// ◇ ----- PARAM •
	public static function param($dataset, $append = '') {
		if ($append === 'FILTER') {
			$append = 'filter_';
		}

		if (VarX::stringAcceptable($dataset)) {
			return ':' . $dataset;
		} elseif (ArrayX::isNotEmpty($dataset)) {
			foreach ($dataset as $bind => $value) {
				if (VarX::isNumeric($bind)) {
					$param[':' . $value] = $value;
				} else {
					$param[':' . $append . $bind] = $value;
				}
				unset($dataset[$bind]);
			}
			if (VarX::isNotEmpty($param)) {
				return $param;
			}
		}
		return false;
	}





	// ◇ ----- INSERT •
	public static function insert($dataset) {
		if (ArrayX::isNotEmpty($dataset)) {
			$column = '';
			$param = '';
			foreach ($dataset as $field => $value) {
				if (VarX::isNumeric($field)) {
					unset($dataset[$field]);
				} else {
					$column .= trim(self::column($field)) . ', ';
					$param .= trim(self::param($field)) . ', ';
				}
			}

			if (VarX::isNotEmpty($column) && VarX::isNotEmpty($param)) {
				$column = StringX::cropEnd($column, ',');
				$param = StringX::cropEnd($param, ',');
				$bind = self::param($dataset);
				$sql = "({$column}) VALUES ({$param})";
				return ['SQL' => $sql, 'PARAM' => $bind];
			}
		}
		return false;
	}





	// ◇ ----- EDIT •
	public static function edit($dataset) {
		if (ArrayX::isNotEmpty($dataset)) {
			$sql = '';
			foreach ($dataset as $field => $value) {
				if (VarX::isNumeric($field)) {
					unset($dataset[$field]);
				} else {
					$sql .= trim(self::column($field)) . ' = ' . self::param($field) . ', ';
				}
			}
			$bind = self::param($dataset);
			if (VarX::isNotEmpty($sql)) {
				$sql = StringX::cropEnd($sql, ',');
				return ['SQL' => trim($sql), 'PARAM' => $bind];
			}
		}
		return false;
	}





	// ◇ ----- FILTER •
	public static function filter($dataset, $symbol = '=', $separator = 'AND') {
		if (ArrayX::isNotEmpty($dataset)) {
			if ($dataset === 'NO_FILTER') {
				return ['SQL' => '', 'PARAM' => ''];
			}

			//...Array
			elseif (ArrayX::is($dataset)) {
				$sql = '';
				$bind = [];
				$param = self::param($dataset, 'FILTER');
				foreach ($param as $column => $value) {
					$sql .= '`' . StringX::swap($column, ':filter_', '') . '` ' . $symbol . " {$column} {$separator} ";
				}
				$sql = StringX::cropEnd($sql, "{$separator}");
				if (VarX::isNotEmpty($param)) {
					$bind = $param;
				}
			}

			if (VarX::isNotEmpty($sql)) {
				return ['SQL' => trim($sql), 'PARAM' => $bind];
			}
		}
		return false;
	}





	// ◇ ----- WHERE •  SQL and/or PARAM
	public static function where($input, $symbol = '=', $separator = 'AND') {
		if (VarX::isNotEmpty($input)) {
			if ($input === 'NO_FILTER') {
				return '';
			} elseif (ArrayX::is($input)) {
				$filter = self::filter($input, $symbol, $separator);
				if (!empty($filter['SQL'])) {
					$filter['SQL'] = 'WHERE ' . $filter['SQL'];
				}
				return $filter;
			} elseif (VarX::stringAcceptable($input)) {
				if (StringX::contain($input, 'WHERE')) {
					return ['SQL' => $input];
				}
				return ['SQL' => 'WHERE ' . $input];
			}
		}
		return false;
	}





	// ◇ ----- JSON •
	public static function json($command, $table, string $column, $input, $filter) {
		if (ArrayX::isNotEmpty($input)) {
			$where = self::where($filter);
			$whereSQL = self::collect($where, 'SQL');
			$sql = "{$command} `{$table}` SET `{$column}` = JSON_SET(`{$column}`, ";
			foreach ($input as $index => $value) {
				$sql .= "'$.{$index}', :" . $index . ", ";
				$bind[':' . $index] = $value;
			}
			$sql = StringX::cropEnd($sql, ', ');
			$sql .= ") " . $whereSQL;
			return ['SQL' => trim($sql), 'PARAM' => $bind];
		}
		return false;
	}





	// ◇ ----- CREATE • Create Record
	public static function create($table, $input) {
		if (VarX::isNotEmpty($table) && VarX::isNotEmpty($input)) {
			$set = self::insert($input);
			$sql = "INSERT INTO `{$table}` " . self::collect($set, 'SQL');
			return ['SQL' => trim($sql), 'PARAM' => self::collect($set, 'PARAM')];
		}
		return false;
	}





	// ◇ ----- SEARCH • Find Record
	public static function search($table, $filter, $column, $limit = 1, $sort = 'NO_SORT') {
		$filter = self::where($filter);
		$sql = 'SELECT ' . self::column($column) . " FROM `{$table}` " . self::collect($filter, 'SQL');
		if (!empty($sort)) {
			$sql .= ' ' . self::sorting($sort);
		}
		if (!empty($limit)) {
			$sql .= ' ' . self::limit($limit);
		}
		return ['SQL' => trim($sql), 'PARAM' => self::collect($filter, 'PARAM')];
	}





	// ◇ ----- UPDATE • Update Record
	public static function update($table, $filter, $input, $limit = 1) {
		$filter = self::where($filter);
		$update = self::edit($input);
		$updateSQL = self::collect($update, 'SQL');
		$filterSQL = self::collect($filter, 'SQL');
		$updateParam = self::collect($update, 'PARAM');
		$filterParam = self::collect($filter, 'PARAM');
		if (!empty($filterParam)) {
			$param = array_merge($updateParam, $filterParam);
		} else {
			$param = $updateParam;
		}
		$sql = "UPDATE `{$table}` SET " . $updateSQL . ' ' . $filterSQL;
		if (!empty($limit)) {
			$sql .= ' ' . self::limit($limit);
		}
		return ['SQL' => trim($sql), 'PARAM' => $param];
	}





	// ◇ ----- DELETE • Delete Record
	public static function delete($table, $filter, $limit = 1) {
		if (VarX::isNotEmpty($table) && VarX::isNotEmpty($filter)) {
			$filter = self::where($filter);
			$sql = "DELETE FROM `{$table}` " . self::collect($filter, 'SQL');
			if (!empty($limit)) {
				$sql .= ' ' . self::limit($limit);
			}
			return ['SQL' => trim($sql), 'PARAM' => self::collect($filter, 'PARAM')];
		}
		return false;
	}





	// ◇ ----- GUID • Populate & append PUID|SUID|TUID to DATASET
	public static function guid($dataset = [], $flag = 'AUTO') {
		if (!$flag) {
			return $dataset;
		} else {
			if ((!array_key_exists('puid', $dataset) && $flag === 'AUTO') || ($flag === 'PUID')) {
				$dataset['puid'] = Random::puid();
			}
			if ((!array_key_exists('suid', $dataset) && $flag === 'AUTO') || ($flag === 'SUID')) {
				$dataset['suid'] = Random::suid();
			}
			if ((!array_key_exists('tuid', $dataset) && $flag === 'AUTO') || ($flag === 'TUID')) {
				$dataset['tuid'] = Random::tuid();
			}

			//...Return dataset
			if (VarX::isNotEmpty($dataset)) {
				return $dataset;
			}
		}
		return false;
	}

} // End Of Class ~ SQL









class SQLTable {

	// ◇ ----- CALL • Non-Existent Method » Error
	public function __call($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CALL_STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CREATE TABLE • Create Table
	public static function create($table, $engine = 'InnoDB', $safely = true, $charset = 'utf8mb4_unicode_ci') {
		if (VarX::isNotEmpty($table)) {
			$append = '';
			if ($safely === true) {
				$append = ' IF NOT EXISTS';
			}
			$sql = "CREATE TABLE {$append} `{$table}` (
				`auid` BIGINT NOT NULL AUTO_INCREMENT,
				`puid` CHAR(20) NULL DEFAULT NULL COLLATE '{$charset}',
				`suid` CHAR(40) NULL DEFAULT NULL COLLATE '{$charset}',
				`tuid` CHAR(70) NULL DEFAULT NULL COLLATE '{$charset}',
				`luid` VARCHAR(70) NULL DEFAULT NULL COLLATE '{$charset}',
				`entry` VARCHAR(80) NULL DEFAULT 'ORIGIN' COLLATE '{$charset}',
				`author` VARCHAR(90) NULL DEFAULT 'ORIGIN' COLLATE '{$charset}',
				`created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
				`updated` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
				`oauthid` CHAR(70) NULL DEFAULT NULL COLLATE '{$charset}',
				`string` VARCHAR(100) NULL DEFAULT NULL COLLATE '{$charset}',
				`money` DECIMAL(13,2) NULL DEFAULT NULL,
				`integer` INT(10) NULL DEFAULT NULL,
				`status` ENUM('PENDING','INACTIVE','ACTIVE', 'DELIST') NULL DEFAULT 'PENDING' COLLATE 'utf8mb4_unicode_ci',
				PRIMARY KEY (`auid`) USING BTREE,
				UNIQUE INDEX `puid` (`puid`) USING BTREE,
				UNIQUE INDEX `suid` (`suid`) USING BTREE,
				UNIQUE INDEX `tuid` (`tuid`) USING BTREE,
				INDEX `luid` (`luid`) USING BTREE,
				INDEX `created` (`created`) USING BTREE,
				INDEX `updated` (`updated`) USING BTREE,
				INDEX `entry` (`entry`) USING BTREE,
				INDEX `author` (`author`) USING BTREE,
				INDEX `oauthid` (`oauthid`) USING BTREE,
				INDEX `status` (`status`) USING BTREE)
				COLLATE='{$charset}' ENGINE={$engine} ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1";
			return $sql;
		}
		return false;
	}





	// ◇ ----- FIND • Find Table
	public static function search($table, $database) {
		if (VarX::isNotEmpty($table) && VarX::isNotEmpty($database)) {
			return "SELECT `TABLE_NAME` AS `table` FROM information_schema.tables WHERE table_schema = '{$database}' AND table_name = '{$table}' LIMIT 1";
		}
		return false;
	}




	// ◇ ----- ALL • Retrieve All Table
	public static function all($database) {
		if (VarX::isNotEmpty($database)) {
			return "SELECT `TABLE_NAME` AS `table` FROM information_schema.tables WHERE table_schema = '{$database}'";
		}
		return false;
	}





	// ◇ ----- RENAME • Rename Table
	public static function rename($table, $rename) {
		if (VarX::isNotEmpty($table) && VarX::isNotEmpty($rename)) {
			$sql = "ALTER TABLE {$table} RENAME TO {$rename}";
			return $sql;
		}
		return false;
	}





	// ◇ ----- truncate • Wipe Table
	public static function truncate($table, $ignoreFK = true) {
		if (VarX::isNotEmpty($table)) {
			if ($ignoreFK === true) {
				$sql = "SET FOREIGN_KEY_CHECKS = 0;";
				$sql .= "TRUNCATE TABLE `{$table}`;";
				$sql .= "SET FOREIGN_KEY_CHECKS = 1;";
				return $sql;
			} else {
				return "TRUNCATE TABLE `{$table}`";
			}
		}
		return false;
	}





	// ◇ ----- RE-INDEX • ReIndex Table
	public static function reIndex($table, $column = 'auid') {
		if (VarX::isNotEmpty($table)) {
			$sql[] = "SET FOREIGN_KEY_CHECKS = 0";
			$sql[] = "SET @NewID = 0";
			$sql[] = "UPDATE `{$table}` SET `{$column}`=(@NewID := @NewID +1) ORDER BY `{$column}`";
			$sql[] = "ALTER TABLE `{$table}` AUTO_INCREMENT = 1";
			$sql[] = "SET FOREIGN_KEY_CHECKS = 1";
			return $sql;
		}
		return false;
	}





	// ◇ ----- DROP • Delete Table
	public static function drop($table, $safely = true, $ignoreFK = false) {
		if (VarX::isNotEmpty($table)) {
			$append = '';
			if ($safely) {
				$append = ' IF EXISTS ';
			}
			if ($ignoreFK) {
				$sql[] = "SET FOREIGN_KEY_CHECKS = 0";
				$sql[] = "DROP TABLE {$append} `{$table}`";
				$sql[] = "SET FOREIGN_KEY_CHECKS = 1";
				return $sql;
			} else {
				return "DROP TABLE {$append} `{$table}`";
			}
		}
		return false;
	}

} // End Of Class ~ SQLTable










class SQLDatabase {

	// ◇ ----- CALL • Non-Existent Method » Error
	public function __call($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CALL_STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CREATE • Create Database
	public static function create($database, $safely = true) {
		if (VarX::isNotEmpty($database)) {
			$append = '';
			if ($safely) {
				$append = ' IF NOT EXISTS ';
			}
			return "CREATE DATABASE {$append} `{$database}` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
		}
		return false;
	}





	// ◇ ----- ADOPT • Adopt Database
	public static function adopt($database) {
		if (VarX::isNotEmpty($database)) {
			return "USE `{$database}`";
		}
		return false;
	}





	// ◇ ----- SEARCH • Find Database
	public static function search($database) {
		if (VarX::isNotEmpty($database)) {
			return "SELECT SCHEMA_NAME AS `database` FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '{$database}'";
		}
		return false;
	}





	// ◇ ----- DROP • Delete Database
	public static function drop($database, $safely = true) {
		if (VarX::isNotEmpty($database)) {
			$append = '';
			if ($safely) {
				$append = ' IF EXISTS ';
			}
			return "DROP DATABASE {$append} `{$database}`";
		}
		return false;
	}

} // End Of Class ~ SQLDatabase