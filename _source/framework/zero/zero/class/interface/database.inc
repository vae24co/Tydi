<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* Database ~ Database Abstract • VERSION » alpha-0.0.3 ***/

abstract class Database {

	protected $type;
	protected $persist;
	protected $host;
	protected $user;
	protected $password;
	protected $dbo = false;


	//*----------- abstract method -----------*//
	abstract public function error(array $error);
	abstract public function response($response, &$stmt, $sql, $data, &$exec);
	abstract public function isObj($object, $flag);
	abstract public function connect($dbo);

	abstract public function disconnect(&$dbo);

	abstract public function dbo();

	abstract public function exec($sql, $response);

	abstract public function query($sql, $response);

	abstract function execute(&$stmt, $data, $sql);
	abstract function multiquery(array $queryset, $pdo='');
	abstract public function prepare($sql, $response, array $data=[]);






	//*----------- VERIFY -----------*//
	public function verify(){
		if(empty($this->host)){return $this->error(['code' => 'CE428DB', 'extra' => 'ERROR:: SERVER Required']);}
		if(empty($this->driver)){return $this->error(['code' => 'CE428DB', 'extra' => 'ERROR:: DRIVER Required']);}
		if(!isset($this->persist)){return $this->error(['code' => 'CE428DB', 'extra' => 'ERROR:: PERSIST Required']);}
		if(!isset($this->user)){return $this->error(['code' => 'CE428DB', 'extra' => 'ERROR:: USER Required']);}
		if(!isset($this->password)){return $this->error(['code' => 'CE428DB', 'extra' => 'ERROR:: PASSWORD Required']);}
		return true;
	}





	//*----------- INITIALIZE -----------*//
	public function initialize($config=[]){
		if(empty($config)){return $this->error(['code' => 'CE428DB', 'extra' => 'Config:: DATA Required']);}
		if(!is_array($config)){return $this->error(['code' => 'CE428DB', 'extra' => 'Config:: ARRAY Expected, NOT '.gettype($config)]);}
		if(empty($config['user'])){return $this->error(['code' => 'CE428DB', 'extra' => 'Config:: USER Required']);}
		if(!isset($config['password'])){return $this->error(['code' => 'CE428DB', 'extra' => 'Config:: PASSWORD Required']);}

		if(empty($config['host'])){$config['host'] = 'localhost';}
		if(empty($config['type'])){$config['type'] = 'MySQL';}
		if(empty($config['persist'])){$config['persist'] = false;}

		$objects = ['host', 'driver', 'persist', 'user', 'password', 'type', 'name'];
		foreach($objects as $object){
			if(isset($config[$object])){
				$this->{$object} = $config[$object];
			}
		}

		return true;
	}





	//*----------- PARAM -----------*//
	private function param($query){
		$param = SQLQ::collect($query, 'PARAMSET');
		if(!$param){return [];}
		return $param;
	}





	//*----------- CREATE DATABASE -----------*//
	public function createDatabase($database, $safe, $response='BOOL'){
		if($this->type === 'MySQL'){
			$sql = SQLQ::createDatabase($database, $safe);
			return $this->exec($sql, $response);
		}
		return false;
	}





	//*----------- RETRIEVE DATABASE -----------*//
	public function retrieveDatabase($database, $response='ROW'){
		if($this->type === 'MySQL'){
			$sql = SQLQ::retrieveDatabase($database);
			return $this->query($sql, $response);
		}
		return false;
	}





	//*----------- IS DATABASE -----------*//
	public function isDatabase($database){
		$result = $this->retrieveDatabase($database);
		if(!empty($result['database']) && $result['database'] == $database){return true;}
		return false;
	}





	//*----------- ADOPT DATABASE -----------*//
	public function adoptDatabase($database, $response='BOOL'){
		if($this->type === 'MySQL'){
			$sql = SQLQ::adoptDatabase($database);
			return $this->query($sql, $response);
		}
		return false;
	}





	//*----------- DELETE DATABASE -----------*//
	public function deleteDatabase($database, $safe, $response='BOOL'){
		if($this->type === 'MySQL'){
			$sql = SQLQ::deleteDatabase($database, $safe);
			return $this->query($sql, $response);
		}
		return false;
	}










	//*----------- CREATE TABLE -----------*//
	public function createTable($table, $safe, $response='BOOL'){
		if($this->type === 'MySQL'){
			$sql = SQLQ::createTable($table, $safe);
			return $this->query($sql, $response);
		}
		return false;
	}





	//*----------- RETRIEVE TABLE -----------*//
	public function retrieveTable($table, $database, $response='ROW'){
		if($this->type === 'MySQL'){
			$sql = SQLQ::retrieveTable($table, $database);
			return $this->query($sql, $response);
		}
		return false;
	}





	//*----------- IS TABLE -----------*//
	public function isTable($table, $database){
		$result = $this->retrieveTable($table, $database);
		if(!empty($result['TABLE']) && $result['TABLE'] == $table){return true;}
		return false;
	}






	//*----------- RENAME TABLE -----------*//
	public function renameTable($table, $rename, $response='BOOL'){
		if($this->type === 'MySQL'){
			$sql = SQLQ::renameTable($table, $rename);
			return $this->query($sql, $response);
		}
		return false;
	}





	//*----------- DELETE TABLE -----------*//
	public function deleteTable($table, $safe, $response='BOOL'){
		if($this->type === 'MySQL'){
			$sql = SQLQ::deleteTable($table, $safe);
			return $this->query($sql, $response);
		}
		return false;
	}





	//*----------- RE-INDEX TABLE -----------*//
	public function reindexTable($table, $column='auid', $response='BOOL'){
		if($this->type === 'MySQL'){
			$sql = SQLQ::reindexTable($table, $column);
			return $this->exec($sql, $response);
		}
		return false;
	}





	//*----------- RESET TABLE -----------*//
	public function resetTable($table, $ignoreFK=true, $response='BOOL'){
		if($this->type === 'MySQL'){
			$sql = SQLQ::resetTable($table, $ignoreFK);
			return $this->query($sql, $response);
		}
		return false;
	}










	//*----------- CREATE -----------*//
	public function createRecord($table, $input, $guid, $response='BOOl'){
		if($this->type === 'MySQL'){
			$input = SQLQ::guid($input, $guid);
			$query = SQLQ::createRow($table, $input);
			$sql = SQLQ::collect($query, 'SQL');
			$param = $this->param($query);
			return $this->prepare($sql, $response, $param);
		}
		return false;
	}





	//*----------- RETRIEVE RECORD -----------*//
	public function retrieveRecord($table, $column, $filter, $limit, $sort, $response='ROWS'){
		if($this->type === 'MySQL'){
			$query = SQLQ::retrieveRow($table, $column, $filter, $limit, $sort);
			$sql = SQLQ::collect($query, 'SQL');
			$param = $this->param($query);
			return $this->prepare($sql, $response, $param);
		}
		return false;
	}





	//*----------- ALL RECORD -----------*//
	public function allRecord($table, $column, $limit, $sort='NO_SORT', $response='ROWS'){
		return $this->retrieveRecord($table, $column, 'NO_FILTER', $limit, $sort, $response);
	}





	//*----------- HAS RECORD -----------*//
	public function hasRecord($table, $column, $filter, $limit=1){
		if(is_array($column)){
			if(ArrayX::isNumericKey($column)){$column = ArrayX::value($column, 'FIRST');}
			else {$column = ArrayX::key($column, 'FIRST');}
		}
		$record = $this->retrieveRecord($table, $column, $filter, $limit, 'NO_SORT', 'ROW');
		if(isset($record[$column])){return true;}
		return false;
	}





	//*----------- COUNT RECORD -----------*//
	public function countRecord($table, $column, $filter, $limit='NO_LIMIT'){
		return $this->retrieveRecord($table, $column, $filter, $limit, 'NO_SORT', 'COUNT');
	}





	//*----------- UPDATE RECORD -----------*//
	public function updateRecord($table, $input, $filter, $limit, $response='BOOL'){
		if($this->type === 'MySQL'){
			$query = SQLQ::updateRow($table, $input, $filter, $limit);
			$sql = SQLQ::collect($query, 'SQL');
			$param = $this->param($query);
			return $this->prepare($sql, $response, $param);
		}
		return false;
	}





	//*----------- SAVE RECORD -----------*//
	public function saveRecord($table, $filter, $column, $input=[], $limit=1, $guid='AUTO', $response='COUNT'){
		$record = $this->hasRecord($table, $column, $filter, $limit);
		if($record === false){
			$input = array_merge($input, $filter);
			return $this->createRecord($table, $input, $guid, $response);
		}
		elseif($record === true){
			return $this->updateRecord($table, $input,  $filter, $limit, $response);
		}
		return false;
	}





	//*----------- DELETE RECORD -----------*//
	public function deleteRecord($table, $filter, $limit, $response='BOOL'){
		if($this->type === 'MySQL'){
			$query = SQLQ::deleteRow($table, $filter, $limit);
			$sql = SQLQ::collect($query, 'SQL');
			$param = $this->param($query);
			return $this->prepare($sql, $response, $param);
		}
		return false;
	}

} /*** End Of ~Database ***/