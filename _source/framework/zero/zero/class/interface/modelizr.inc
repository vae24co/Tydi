<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* Modelizr ~ Modelizr Abstract • VERSION » alpha-0.0.5 ***/

abstract class Modelizr {

	protected $database;
	protected $db;

	protected $guid = 'AUTO';



	//*----------- CONSTRUCT -----------*//
	public function __construct(){
		$this->initialize();
	}





	//*----------- INITIALIZE -----------*//
	abstract protected function initialize();





	//*----------- CONNECT -----------*//
	protected function connect(array $auth, string $database=''){
		if(empty($auth['name']) && !empty($database)){$auth['name'] = $database;}
		if(empty($auth['driver'])){$auth['driver'] = 'PDO';}

		$this->database = $auth['name'];
		$this->driver = $auth['driver'];

		if($this->driver === 'PDO'){
			$pdo = new oPDO;
			$pdo->initialize($auth);
			$pdo->verify();
			if($pdo->connect() === true){
				$this->db = $pdo;
				return true;
			}
		}
		return false;
	}





	//*----------- DATABASE -----------*//
	protected function database($database=''){
		if(empty($database) && !empty($this->database)){$database = $this->database;}
		if(empty($database)){
			//TODO: Improve Error Reporting
			oTraceX('DB:: Missing Database Name - in Modelizr');
			exit;
		}
		return $database;
	}





	//*----------- TABLE -----------*//
	protected function table($table=''){
		if(empty($table) && !empty($this->table)){$table = $this->table;}
		if(empty($table)){
			//TODO: Improve Error Reporting
			oTraceX('DB Query:: Missing Table Name - in Modelizr');
			exit;
		}
		return $table;
	}





	//*----------- SETUP -----------*//
	protected function setup($method, $table, $response='BOOL', $database=''){
		$table = $this->table($table);
		$database = $this->database($database);
		$result = $this->db->isTable($table, $database);
		if($result === false){
			$sql = oSetup::{$method}($table, 'CREATE');
			return $this->db->exec($sql, $response);
		}
		return $result;
	}





	//*----------- INSTALL -----------*//
	public function install($table, $response='BOOL', $database=''){
		$methodSQL = ucwords(strtolower($table), '_').'SQL';
		$methodSQL = StringX::swap($methodSQL, '_', '');
		$table = $this->tables[$table];
		return $this->setup($methodSQL, $table, $response, $table);
	}





	//*----------- CREATE -----------*//
	public function create($dataset, $response='BOOL', $guid='', $table=''){
		if(empty($guid) && !empty($this->guid)){$guid = $this->guid;}
		return $this->db->createRecord($this->table($table), $dataset, $guid, $response);
	}





	//*----------- RETRIEVE -----------*//
	public function retrieve($filter, $column, $response='ROWS', $limit='NO_LIMIT', $sort='NO_SORT', $table=''){
		return $this->db->retrieveRecord($this->table($table), $column, $filter, $limit, $sort, $response);
	}





	//*----------- HAS -----------*//
	public function has($filter, $column, $limit=1, $table=''){
		return $this->db->hasRecord($this->table($table), $column, $filter, $limit);
	}





	//*----------- COUNT -----------*//
	public function count($filter, $column, $limit='NO_LIMIT', $table=''){
		return $this->db->countRecord($this->table($table), $column, $filter, $limit);
	}





	//*----------- UPDATE -----------*//
	public function update($filter, $dataset, $response='BOOL', $limit=1, $table=''){
		return $this->db->updateRecord($this->table($table), $dataset, $filter, $limit, $response);
	}





	//*----------- SAVE -----------*//
	public function save($filter, $column, $dataset=[], $limit=1, $guid='AUTO', $response='COUNT', $table=''){
		return $this->db->saveRecord($this->table($table), $filter, $column, $dataset, $limit, $guid, $response);
	}





	//*----------- DELETE -----------*//
	public function delete($filter, $response='BOOL', $limit=1, $table=''){
		return $this->db->deleteRecord($this->table($table), $filter, $limit, $response);
	}





	//*----------- RE-INDEX -----------*//
	public function reindex($column='auid', $response='BOOL', $table=''){
		return $this->db->reindexTable($this->table($table), $column, $response);
	}





	//*----------- RESET -----------*//
	public function reset($ignoreFK=false, $response='BOOL', $table=''){
		return $this->db->resetTable($this->table($table), $ignoreFK, $response);
	}





	//*----------- MAKE -----------*//
	public function make($table, $dataset, $response='BIND', $guid=''){
		$table = $this->tables[$table];
		if($response === 'BIND'){$return = ['tuid'];}
		elseif($response === 'ID'){$return = ['puid'];}
		elseif($response === 'IDs'){$return = ['puid', 'tuid'];}
		else {$return = $response;}
		$result = $this->create($dataset, $return, $guid, $table);
		if($response === 'BIND' && isset($result['tuid'])){
			$result['bind'] = $result['tuid'];
			unset($result['tuid']);
		}
		if($response === 'ID' && isset($result['puid'])){
			$result['id'] = $result['puid'];
			unset($result['puid']);
		}
		if($response === 'IDs'){
			if(isset($result['puid'])){$result['id'] = $result['puid']; unset($result['puid']);}
			if(isset($result['tuid'])){$result['bind'] = $result['tuid']; unset($result['tuid']);}
		}
		return $result;
	}





	//*----------- IN -----------*//
	public function in($table, $filter, $column='puid', $limit=1){
		$table = $this->tables[$table];
		return $this->has($filter, $column, $limit, $table);
	}





	//*----------- FIND -----------*//
	public function find($table, $filter, $column, $response='ROWS', $limit='NO_LIMIT', $sort='NO_SORT'){
		$table = $this->tables[$table];
		return $this->retrieve($filter, $column, $response, $limit, $sort, $table);
	}





	//*----------- ALL -----------*//
	public function all($table, $column, $limit, $sort='NO_SORT'){
		$table = $this->tables[$table];
		return $this->retrieve('NO_FILTER', $column, 'ROWS', $limit, $sort, $table);
	}





	//*----------- MODIFY -----------*//
	public function modify($table, $filter, $column, $dataset, $response='COUNT', $limit=1){
		$table = $this->tables[$table];
		$result = $this->count($filter, $column, $limit, $table);
		if(is_numeric($result) && $result > 0){$result = $this->update($filter, $dataset, $response, $limit, $table);}
		return $result;
	}





	//*----------- MAINTAIN -----------*//
	public function maintain($table, $filter, $column, $dataset=[], $guid='AUTO', $response='COUNT', $limit=1){
		$table = $this->tables[$table];
		return $this->save($filter, $column, $dataset, $limit, $guid, $response, $table);
	}





	//*----------- REMOVE -----------*//
	public function remove($table, $filter, $column, $response='COUNT', $limit=1){
		$table = $this->tables[$table];
		$result = $this->count($filter, $column, $limit, $table);
		if(is_numeric($result) && $result > 0){$result = $this->delete($filter, $response, $limit, $table);}
		return $result;
	}

} /*** End Of ~Modelizr ***/