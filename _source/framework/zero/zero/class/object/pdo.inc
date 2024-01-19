<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* oPDO ~ PDO Utility • VERSION » alpha-0.0.3 ***/

class oPDO extends Database implements CRUD {

	public $name;
	protected $driver = 'PDO';


	//*----------- OPEN-MYSQL -----------*//
	private function openMySQL(){
		if(empty($this->name)){$dsn = 'mysql:host='.$this->host.';charset=utf8';} else {$dsn = 'mysql:dbname='.$this->name.';host='.$this->host.';charset=utf8';}
		$option = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];
		if($this->persist === true){$option[PDO::ATTR_PERSISTENT] = true;}
		try {$pdo = new PDO($dsn, $this->user, $this->password, $option);}
		catch(PDOException $e){return $this->exception($e, ['object' => __METHOD__]);}
		return $pdo;
	}


	//*----------- ERROR -----------*//
	public function error(array $error){
		if(empty($error['object'])){$error['object'] = __CLASS__;}
		return oDBErrorX($error, $error['object']);
	}





	//*----------- EXCEPTION -----------*//
	public function exception($object, array $error, $extra=[]){
		if(!empty($object)){
			if(!empty($object->getCode())){$error['code'] = 'C'.$object->getCode().'DB';}
			if(!empty($object->getMessage())){$error['extra']['reason'] = $object->getMessage();}
			#$error['summary'] = $object->errorInfo[2];
			#$error['trace'] = $object->getTrace();
			#$error['previous'] = $object->getPrevious();
		}
		if(isset($extra['SQL'])){$error['extra']['SQL'] = $extra['SQL'];}
		if(isset($extra['PARAMSET'])){$error['extra']['PARAMSET'] = $extra['PARAMSET'];}
		return $this->error($error);
	}





	//*----------- RESPONSE -----------*//
	public function response($response, &$stmt, $sql, $data, &$exec){
		if($response === 'STMT'){return $stmt;}
		if($response === 'EXEC' || $response === 'BOOL'){return $exec;}
		if(StringX::in($sql, 'INSERT INTO')){
			$data = DataQ::paramToKey($data);
			return DataQ::param($data, $response);
		}
		elseif(self::isObj($stmt, 'PDOStatement')){
			if($response === 'COUNT'){$result = $stmt->rowCount();}
			elseif($response === 'ROW'){$result = $stmt->fetch();}
			else {$result = $stmt->fetchAll();}
			if(isset($result)){
				if(is_numeric($result)){
					if(StringX::in($sql, 'UPDATE ') || StringX::in($sql, 'DELETE ')){return $result;}
					elseif(StringX::in($sql, 'SELECT ')){
						if(empty($result) || $result == 0){return 'NO_RESULT';}
						else {return $result;}
					}
				}
				elseif(is_array($result)){
					if(!empty($result)){
						if(ArrayX::isMulti($result) && ArrayX::isNumericKey($result) && isset($result[0])){$result = ArrayX::reIndexNumeric($result);}
						if($response === 'ROWS' || $response === 'ROW'){return $result;}
						if($response !== 'COUNT'){return DataQ::param($result, $response);}
					}
				}
				if(empty($result)){
					if(StringX::in($sql, 'SELECT ')){$result = 'NO_RESULT';}
				}
				return $result;
			}
		}
		return false;
	}





	//*----------- IS-OBJECT -----------*//
	public function isObj($object, $flag='DBO'){
		if($flag === 'DBO' && is_object($object) && $object instanceof PDO){return true;}
		elseif($flag === 'PDOStatement' && is_object($object) && $object instanceof PDOStatement){return true;}
		return false;
	}





	//*----------- CONNECT -----------*//
	public function connect($pdo=''){
		if(!empty($pdo)){
			if($this->isObj($pdo, 'DBO') === false){
				return $this->exception($pdo, ['code' => 'CE498DB']);
			}
		}
		else {
			if($this->type === 'MySQL'){$pdo = $this->openMySQL();}
		}

		if(!empty($pdo)){
			$this->dbo = $pdo;
			return true;
		}

		return false;
	}





	//*----------- DISCONNECT -----------*//
	public function disconnect(&$pdo=''){
		if(!empty($pdo)){
			if($this->isObj($pdo, 'DBO')){$dbo = null;}
		}
		else {
			if(isset($this->host)){unset($this->host);}
			if(isset($this->name)){unset($this->name);}
			if(isset($this->user)){unset($this->user);}
			if(isset($this->password)){unset($this->password);}
			if(isset($this->persist)){unset($this->persist);}
			if(isset($this->driver)){unset($this->driver);}
			if(isset($this->dbo)){unset($this->dbo);}
		}
		return true;
	}





	//*----------- DBO -----------*//
	public function dbo(){
		return $this->dbo;
	}





	//*----------- EXEC -----------*//
	public function exec($sql, $response){
		if(empty($sql)){return $this->error(['code' => 'C428DE', 'object' => __METHOD__, 'extra' => 'Argument:: SQL Required']);}
		$db = $this->dbo;
		try {
			if(!is_array($sql)){$result = $db->exec($sql);}
			else {
				foreach($sql as $i => $query){
					$o[$i] = $db->exec($query);
				}
				$result = $o;
			}
		}
		catch(PDOException $e){
			return $this->exception($e, ['message' => 'SQL Exec Failed', 'object' => __METHOD__], ['SQL' => $sql]);
		}

		if($response === 'BOOL'){
			if($result !== false){return true;}
			return false;
		}

		return $result;
	}





	//*----------- QUERY ~Prepares and executes an SQL statement without placeholders -----------*//
	public function query($sql, $response){
		$db = $this->dbo;
		try {
			//TODO: When $SQL is an array
			$stmt = $db->query($sql);
		} catch(PDOException $e){
			return $this->exception($e, ['message' => 'SQL Query Failed', 'object' => __METHOD__], ['SQL' => $sql]);
		}
		return $this->response($response, $stmt, $sql, [], $stmt);
	}





	//*----------- EXECUTE -----------*//
	public function execute(&$stmt, $data, $sql){
		try {
			if(empty($data)){$exec = $stmt->execute();}
			elseif(!ArrayX::isMulti($data)){$exec = $stmt->execute($data);}
			else {
				//TODO: To review block!
				foreach($data as $param){$exec[] = $stmt->execute($param);}
			}
		}
		catch(PDOException $e){
			return $this->exception($e, [], ['SQL' => $sql, 'PARAMSET' => $data]);
		}
		return $exec;
	}





	public function multiquery(array $queryset, $pdo=''){
		$rollback = false;
		$dbo = $this->dbo($pdo);
		$dbo->beginTransaction();
		try {
			foreach ($queryset AS $index => $query){
				$sql[$index] = $query['SQL'];
				$param[$index] = $query['PARAMSET'];
				$stmt = $dbo->prepare($sql[$index]);
				$stmt->execute($param[$index]);
				$result = $stmt->rowCount();
				if(!$result){$rollback = true;}
			}
			if($rollback === false){$dbo->commit();} else {$dbo->rollBack();}
		} catch (Exception $e){
			$dbo->rollBack();
			return $this->exception($e, ['message' => 'MultiQuery Failed'], ['SQL' => $sql, 'PARAMSET' => $param]);
		}
		return true;
	}





	//*----------- PREPARE ~ Prepares and executes SQL statement with placeholders -----------*//
	public function prepare($sql, $response, array $param=[]){
		$db = $this->dbo;
		try {
			$stmt = $db->prepare($sql);
		} catch(PDOException $e){
			return $this->exception($e, ['message' => 'SQL Preparation Failed', 'object' => __METHOD__], ['SQL' => $sql, 'PARAMSET' => $param]);
		}
		$exec = $this->execute($stmt, $param, $sql);
		return $this->response($response, $stmt, $sql, $param, $exec);
	}




















































	#COMMIT • Commit changes
	public function commit($i='', $pdo=''){
		$dbo = $this->dbo($pdo);
		if($i === 'AUTO'){return $dbo->autocommit();}
		return $dbo->commit();
	}


	#TRANSACT • Begin a transaction, turning off autocommit
	public function transact($pdo=''){
		$dbo = $this->dbo($pdo);
		return $dbo->beginTransaction();
	}


	#ROLLBACK	• Rollback changes
	public function rollback($pdo=''){
		$dbo = $this->dbo($pdo);
		return $dbo->rollBack();
	}


	#LAST_ID • Return last insert ID
	public function lastid($pdo=''){
		$dbo = $this->dbo($pdo);
		return $dbo->lastInsertId();
	}




} /*** End Of ~oPDO ***/