<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* SQLQ ~ SQL Utility • VERSION » alpha-0.0.3 ***/

class SQLQ {

	//*----------- COLUMN ~Prepare column as SQL -----------*//
	public static function column($input){
		$sql = '';
		if(!StringX::empty($input)){
			$column = '';
			if($input === 'ALL' || $input === '*'){$column .= '*';}
			elseif(!is_array($input)){
				if(StringX::in($input, '`')){$column .= trim($input).' ';}
				else {
					if(StringX::in($input, ',')){
						$columns = StringX::toArray($input, ',');
						foreach($columns as $field){
							$column .= self::column($field).', ';
						}
						$column = StringX::swap($column, ',', '', 'LAST');
					}
					else {
						$column .= ' `'.trim($input).'` ';
					}
				}
			}
			else {
				if(ArrayX::isNumericKey($input)){
					foreach($input as $label){$column .= '`'.trim($label).'`, ';}
					$column = StringX::swap($column, ',', '', 'LAST');
				}
				else {
					foreach($input as $label => $value){
						if(is_numeric($label)){$column .= '`'.trim($value).'`, ';}
						else {
							$column .= '`'.trim($label).'` ';
							if(!empty($value)){$column .= 'AS `'.$value.'`';}
							$column .= ', ';
						}
					}
					$column = StringX::swap($column, ',', '', 'LAST');
				}
			}
			if(isset($column)){
				if(StringX::in($column, ':')){$column = StringX::swap($column, ':', '');}
				$sql = trim($column);
			}
		}
		return $sql;
	}





	//*----------- LIMIT -----------*//
	public static function limit($input){
		$sql = '';
		if(!StringX::empty($input)){
			if($input === 'NO_LIMIT'){return '';}
			elseif(is_numeric($input)){$limit = $input;}
			elseif(is_string($input) && StringX::in($input, ',')){$limit = $input;} //? for offset e.g Limit 0, 4
			elseif(is_array($input)){
				if(isset($input['LIMIT']) && is_numeric($input['LIMIT'])){$limit = $input['LIMIT'];}
				if(ArrayX::isNumericKey($input) && count($input) == 2){
					$limit = '';
					foreach($input as $index => $value){$limit .= $value.', ';}
					$limit = StringX::swap($limit, ',', '', 'LAST');
				}
			}
			if(isset($limit)){$sql = 'LIMIT '.trim($limit);}
		}
		return $sql;
	}





	//*----------- OFFSET -----------*//
	public static function offset($input){
		$sql = '';
		if(!StringX::empty($input)){
			if(is_numeric($input)){$offset = $input;}
			if(is_array($input) && isset($input['OFFSET']) && is_numeric($input['OFFSET'])){$offset = $input['OFFSET'];}
			if(isset($offset)){$sql = 'OFFSET '.trim($offset);}
		}
		return $sql;
	}





	//*----------- SORTING -----------*//
	public static function sorting($input, $sort='ASC'){
		$sql = '';
		if(!StringX::empty($input)){
			if(!is_array($input)){
				if($input == 'NO_SORT'){return '';}
				if(StringX::in($input, 'ORDER BY')){$sort = $input;}
				else {
					$column = self::column($input);
					if(!empty($column)){$sort = "ORDER BY {$column} {$sort}";}
				}
			}
			else {
				$sort = '';
				if(ArrayX::isNumericKey($input)){
					foreach($input as $label){$sort .= ' `'.$label.'`, ';}
				}
				else {
					foreach($input as $label => $order){
						if(is_numeric($label)){$sort .= ' `'.$order.'`, ';}
						else {$sort .= ' `'.$label.'` '.$order.', ';}
					}
				}
				$sort = StringX::swap($sort, ',', '', 'LAST');
				$sort = trim($sort);
				if(!empty($sort)){$sort = 'ORDER BY '.$sort;}
			}
			if(isset($sort)){$sql = $sort;}
		}
		return $sql;
	}





	//*----------- GUID ~ Populate & apend PUID|EUID|SUID to DATASET -----------*//
	public static function guid(array $data=[], $flag='AUTO'){
		if($flag === 'NONE'){return $data;}
		else {
			if((!array_key_exists('puid', $data) && $flag === 'AUTO') || ($flag === 'PUID')){$data['puid'] = RandomX::puid();}
			if((!array_key_exists('suid', $data) && $flag === 'AUTO') || ($flag === 'SUID')){$data['suid'] = RandomX::suid();}
			if((!array_key_exists('tuid', $data) && $flag === 'AUTO') || ($flag === 'TUID')){$data['tuid'] = RandomX::tuid();}
			if(!empty($data)){return $data;}
		}
		return false;
	}





	//*----------- PARAMSET ~ Prepare BINDPARAM -----------*//
	public static function paramset($data){
		if(!empty($data)){
			if(!is_array($data)){return ':'.$data;}
			foreach($data as $bind => $value){
				if(is_numeric($bind)){$param[':'.$value] = $value;}
				else {$param[':'.$bind] = $value;}
				unset($data[$bind]);
			}
			if(!empty($param)){return $param;}
		}
		return false;
	}





	//*----------- INSERTSET ~ Prepare SQL with BINDPARAM for insert -----------*//
	public static function insertset(array $dataset){
		if(!empty($dataset)){
			$column = ''; $param = '';
			foreach($dataset as $field => $value){
				if(!is_numeric($field)){
					$column .= trim(self::column($field)).', ';
					$param .= trim(self::paramset($field)).', ';
				}
				else {
					unset($dataset[$field]);
				}
			}
			$column = StringX::swap($column, ', ', '', 'LAST');
			$param = StringX::swap($param, ', ', '', 'LAST');
			$bind = self::paramset($dataset);
			$sql = "({$column}) VALUES ({$param})";
			return ['SQL' => $sql, 'PARAMSET' => $bind];
		}
		return false;
	}





	//*----------- UPDATESET ~ Prepare SQL with BINDPARAM for update -----------*//
	public static function updateset(array $dataset){
		if(!empty($dataset)){
			$sql = '';
			foreach($dataset as $field => $value){
				if(!is_numeric($field)){
					$sql .= trim(self::column($field)).' = '.self::paramset($field).', ';
				}
				else {
					unset($dataset[$field]);
				}
			}
			$bind = self::paramset($dataset);
			$sql = StringX::swap($sql, ',', '', 'LAST');
			return ['SQL' => trim($sql), 'PARAMSET' => $bind];
		}
		return false;
	}






	//*----------- FILTERSET ~ Prepare SQL with BINDPARAM for filter -----------*//
	public static function filterset($dataset, $symbol='=', $separator='AND'){
		if(!empty($dataset)){
			if($dataset === 'NO_FILTER'){return ['SQL' => '', 'PARAMSET' => ''];}
			$sql = ''; $bind = [];
			if(is_array($dataset)){
				$data = self::paramset($dataset);
				foreach($data as $column => $value){
					$sql .= '`'.StringX::swap($column, ':', '').'` '.$symbol." {$column} {$separator} ";
				}
				$sql = StringX::swap($sql, " {$separator} ", '', 'LAST');
				if(!empty($data)){$bind = $data;}
			}

			if(!empty($sql)){
				return ['SQL' => trim($sql), 'PARAMSET' => $bind];
			}
		}
		return false;
	}





	//*----------- JSONSET -----------*//
	public static function jsonset($command, $table, $column, $input, $filter){
		if(!StringX::empty($input)){
			if(is_array($input)){
				$where = self::where($filter);
				$whereSQL = self::collect($where, 'SQL');
				$sql = "{$command} `{$table}` SET `{$column}` = JSON_SET(`{$column}`, ";
				foreach($input as $index => $value){
					$sql .= "'$.{$index}', :".$index.", ";
					$bind[':'.$index] = $value;
				}
				$sql = StringX::swap($sql, ', ', '', 'LAST');
				$sql .= ") ".$whereSQL;
				return ['SQL' => trim($sql), 'PARAMSET' => $bind];
			}
		}
		return false;
	}





	//*----------- WHERE ~ SQL and/or PARAMSET -----------*//
	public static function where($input, $symbol='=', $separator='AND'){
		if(!StringX::empty($input)){
			if($input === 'NO_FILTER'){return '';}
			elseif(is_array($input)){
				$filterset = self::filterset($input, $symbol, $separator);
				if(!empty($filterset['SQL'])){
					$filterset['SQL'] = 'WHERE '.$filterset['SQL'];
				}
				return $filterset;
			}
			elseif(is_string($input)){
				if(StringX::in($input, 'WHERE')){return ['SQL' => $input];}
				return ['SQL' => 'WHERE '.$input];
			}
		}
		return false;
	}





	//*----------- COLLECT ~ SQL/PARAMSET from (filter, param, dataset) -----------*//
	public static function collect($set, $option){
		if(!empty($set)){
			if($option === 'SQL' && !empty($set['SQL'])){return $set['SQL'];}
			if($option === 'PARAMSET' && !empty($set['PARAMSET'])){return $set['PARAMSET'];}
		}
		return false;
	}










	//*----------- CREATE DATABASE -----------*//
	public static function createDatabase($database, $safe=true){
		if(!empty($database)){
			if($safe === true){$append = ' IF NOT EXISTS ';} else {$append = '';}
			return "CREATE DATABASE {$append} `{$database}` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci";
		}
		return false;
	}





	//*----------- RETRIEVE DATABASE -----------*//
	public static function retrieveDatabase($database){
		if(!empty($database)){
			#"SHOW DATABASES LIKE '%{$database}%'";
			return "SELECT SCHEMA_NAME AS `DATABASE` FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '{$database}'";
		}
		return false;
	}






	//*----------- ADOPT DATABASE -----------*//
	public static function adoptDatabase($database){
		if(!empty($database)){
			return "USE `{$database}`";
		}
		return false;
	}





	//*----------- DELETE DATABASE -----------*//
	public static function deleteDatabase($database, $safe=true){
		if(!empty($database)){
			if($safe === true){$append = ' IF EXISTS ';} else {$append = '';}
			return "DROP DATABASE {$append} `{$database}`";
		}
		return false;
	}










	//*----------- CREATE TABLE -----------*//
	public static function createTable($table, $safe=true, $engine='InnoDB', $charset='utf8_unicode_ci'){
		if(!empty($table)){
			if($safe === true){$append = ' IF NOT EXISTS';} else {$append = '';}
			$sql = "CREATE TABLE {$append} `{$table}`
			(`auid` BIGINT(20) NOT NULL AUTO_INCREMENT,
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
			`Integer` INT(10) NULL DEFAULT NULL,
			PRIMARY KEY (`auid`) USING BTREE,
			UNIQUE INDEX `puid` (`puid`) USING BTREE,
			UNIQUE INDEX `suid` (`suid`) USING BTREE,
			UNIQUE INDEX `tuid` (`tuid`) USING BTREE,
			INDEX `luid` (`luid`) USING BTREE,
			INDEX `created` (`created`) USING BTREE,
			INDEX `updated` (`updated`) USING BTREE,
			INDEX `entry` (`entry`) USING BTREE,
			INDEX `author` (`author`) USING BTREE,
			INDEX `oauthid` (`oauthid`) USING BTREE
			)
			COLLATE='{$charset}' ENGINE={$engine} ROW_FORMAT=DYNAMIC";
			return $sql;
		}
		return false;
	}





	//*----------- RETRIEVE TABLE -----------*//
	public static function retrieveTable($table, $database){
		if(!empty($table) && !empty($database)){
			return "SELECT `TABLE_NAME` AS `TABLE` FROM information_schema.tables WHERE table_schema = '{$database}' AND table_name = '{$table}' LIMIT 1";
		}
		return false;
	}





	//*----------- RENAME TABLE -----------*//
	public static function renameTable($table, $rename){
		if(!empty($table) && !empty($rename)){
			$sql = "ALTER TABLE {$table} RENAME TO {$rename}";
			return $sql;
		}
		return false;
	}





	//*----------- DELETE TABLE -----------*//
	public static function deleteTable($table, $safe=true, $ignoreFK=false){
		if(!empty($table)){
			if($safe === true){$append = ' IF EXISTS ';} else {$append = '';}
			if($ignoreFK){
				$sql[] = "SET FOREIGN_KEY_CHECKS = 0";
				$sql[] = "DROP TABLE {$append} `{$table}`";
				$sql[] = "SET FOREIGN_KEY_CHECKS = 1";
				return $sql;
			}
			else {
				return "DROP TABLE {$append} `{$table}`";
			}
		}
		return false;
	}





	//*----------- RE-INDEX TABLE -----------*//
	public static function reindexTable($table, $column='auid'){
		if(!empty($table)){
			$sql[] = "SET FOREIGN_KEY_CHECKS = 0";
			$sql[] = "SET @NewID = 0";
			$sql[] = "UPDATE `{$table}` SET `{$column}`=(@NewID := @NewID +1) ORDER BY `{$column}`";
			$sql[] = "ALTER TABLE `{$table}` AUTO_INCREMENT = 1";
			$sql[] = "SET FOREIGN_KEY_CHECKS = 1";
			return $sql;
		}
		return false;
	}





	//*----------- RESET TABLE -----------*//
	public static function resetTable($table, $ignoreFK=true){
		if(!empty($table)){
			if($ignoreFK === true){
				$sql[] = "SET FOREIGN_KEY_CHECKS = 0";
				$sql[] = "TRUNCATE TABLE `{$table}`";
				$sql[] = "SET FOREIGN_KEY_CHECKS = 1";
				return $sql;
			}
			else {
				return "TRUNCATE TABLE `{$table}`";
			}
		}
		return false;
	}










	//*----------- CREATE ROW -----------*//
	public static function createRow($table, $input){
		if(!empty($table) && !empty($input)){
			$set = self::insertset($input);
			$sql = "INSERT INTO `{$table}` ".self::collect($set, 'SQL');
			return ['SQL' => trim($sql), 'PARAMSET' => self::collect($set, 'PARAMSET')];
		}
		return false;
	}





	//*----------- RETRIEVE ROW -----------*//
	public static function retrieveRow($table, $column, $filter, $limit, $sort){
		$filter = self::where($filter);
		$sql = 'SELECT '.self::column($column)." FROM `{$table}` ".self::collect($filter, 'SQL');
		if(!empty($sort)){$sql .= ' '.self::sorting($sort);}
		if(!empty($limit)){$sql .= ' '.self::limit($limit);}
		return ['SQL' => trim($sql), 'PARAMSET' => self::collect($filter, 'PARAMSET')];
	}





	//*----------- UPDATE ROW -----------*//
	public static function updateRow($table, $input, $filter, $limit){
		$update = self::updateset($input);
		$filter = self::where($filter);
		$updateSQL = self::collect($update, 'SQL');
		$filterSQL = self::collect($filter, 'SQL');
		$updateParam = self::collect($update, 'PARAMSET');
		$filterParam = self::collect($filter, 'PARAMSET');
		if(!empty($filterParam)){$param = array_merge($updateParam, $filterParam);} else {$param = $updateParam;}
		$sql = "UPDATE `{$table}` SET ".$updateSQL.' '.$filterSQL;
		if(!empty($limit)){$sql .= ' '.self::limit($limit);}
		return ['SQL' => trim($sql), 'PARAMSET' => $param];
	}





	//*----------- DELETE ROW -----------*//
	public static function deleteRow($table, $filter, $limit){
		$filter = self::where($filter);
		$sql = "DELETE FROM `{$table}` ".self::collect($filter, 'SQL');
		if(!empty($limit)){$sql .= ' '.self::limit($limit);}
		return ['SQL' => trim($sql), 'PARAMSET' => self::collect($filter, 'PARAMSET')];
	}

} /*** End Of ~SQLQ ***/
