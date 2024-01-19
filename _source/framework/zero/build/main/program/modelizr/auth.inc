<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* AuthModel ~ Authentication Modelizr • VERSION » alpha-0.0.7 ***/

class AuthModel extends Modelizr {

	//*----------- INITIALIZE -----------*//
	public function initialize(){
		$setting = SETTING['NETWORK'];
		if(!empty($setting['DATABASE'])){
			$settingDB = $setting['DATABASE'];
			if(isset($settingDB['USER'])){$init['user'] = $settingDB['USER'];}
			if(isset($settingDB['PASSWORD'])){$init['password'] = $settingDB['PASSWORD'];}
			if(isset($settingDB['NAME'])){$init['name'] = $settingDB['NAME'];}
			if(!empty($init)){$this->connect($init);}
			if(!empty($settingDB['TABLE'])){$this->tables = $settingDB['TABLE'];}
		}
	}





	//*----------- INSTALL AUTH -----------*//
	public function installAuth(){
		return $this->install('AUTH');
	}





	//*----------- MAKE AUTH -----------*//
	public function makeAuth($dataset, $response='BIND', $guid=''){
		if(empty($dataset['tuid'])){
			$dataset['tuid'] = RandomX::tuid();
			$dataset['oauthid'] = $dataset['tuid'];
		}
		return $this->make('AUTH', $dataset, $response, $guid);
	}





	//*----------- IN AUTH -----------*//
	public function inAuth($filter, $column='puid', $limit=1){
		return $this->in('AUTH', $filter, $column, $limit);
	}





	//*----------- FIND AUTH -----------*//
	public function findAuth($filter, $column, $response='ROW', $limit=1, $sort='NO_SORT'){
		return $this->find('AUTH', $filter, $column, $response, $limit, $sort);
	}





	//*----------- ALL AUTH -----------*//
	public function allAuth($column, $limit, $sort='NO_SORT'){
		return $this->all('AUTH', $column, $limit, $sort);
	}





	//*----------- UPDATE AUTH -----------*//
	public function updateAuth($filter, $dataset, $response='BOOL', $limit=1){
		$table = $this->tables['AUTH'];
		return $this->update($filter, $dataset, $response, $limit, $table);
	}





	//*----------- MODIFY AUTH -----------*//
	public function modifyAuth($filter, $column, $dataset, $response='COUNT', $limit=1){
		return $this->modify('AUTH', $filter, $column, $dataset, $response, $limit);
	}





	//*----------- MAINTAIN AUTH -----------*//
	public function maintainAuth($filter, $column, $dataset=[], $guid='AUTO', $response='COUNT', $limit=1){
		return $this->maintain('AUTH', $filter, $column, $dataset, $guid, $response, $limit);
	}





	//*----------- REMOVE AUTH -----------*//
	public function removeAuth($filter, $column, $response='COUNT', $limit=1){
		return $this->remove('AUTH', $filter, $column, $response, $limit);
	}





	//*----------- RE-INDEX AUTH -----------*//
	public function reindexAuth($column='auid', $response='BOOL'){
		$table = $this->tables['AUTH'];
		return $this->reindex($column, $response, $table);
	}





	//*----------- RESET AUTH -----------*//
	public function resetAuth($ignoreFK=false, $response='BOOL'){
		$table = $this->tables['AUTH'];
		return $this->reset($ignoreFK, $response, $table);
	}

} /*** End Of ~AuthModel ***/