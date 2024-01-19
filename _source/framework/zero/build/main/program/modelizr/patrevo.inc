<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* PatrevoModel ~ Authentication Modelizr • VERSION » alpha-0.0.5 ***/

class PatrevoModel extends Modelizr {

	//*----------- INITIALIZE -----------*//
	public function initialize(){
		$setting = SETTING['PATREVO'];
		if(!empty($setting['DATABASE'])){
			$settingDB = $setting['DATABASE'];
			if(isset($settingDB['USER'])){$init['user'] = $settingDB['USER'];}
			if(isset($settingDB['PASSWORD'])){$init['password'] = $settingDB['PASSWORD'];}
			if(isset($settingDB['NAME'])){$init['name'] = $settingDB['NAME'];}
			if(!empty($init)){$this->connect($init);}
			if(!empty($settingDB['TABLE'])){$this->tables = $settingDB['TABLE'];}
		}
	}





	//*----------- INSTALL USER -----------*//
	public function installUser(){
		return $this->install('CUPID');
	}





	//*----------- MAKE USER -----------*//
	public function makeUser($dataset, $response='BIND', $guid=''){
		return $this->make('CUPID', $dataset, $response, $guid);
	}





	//*----------- IN USER -----------*//
	public function inUser($filter, $column='puid', $limit=1){
		return $this->in('CUPID', $filter, $column, $limit);
	}





	//*----------- FIND USER -----------*//
	public function findUser($filter, $column, $response='ROW', $limit=1, $sort='NO_SORT'){
		return $this->find('CUPID', $filter, $column, $response, $limit, $sort);
	}





	//*----------- ALL USER -----------*//
	public function allUser($column, $limit, $sort='NO_SORT'){
		return $this->all('CUPID', $column, $limit, $sort);
	}





	//*----------- UPDATE USER -----------*//
	public function updateUser($filter, $dataset, $response='BOOL', $limit=1){
		$table = $this->tables['CUPID'];
		return $this->update($filter, $dataset, $response, $limit, $table);
	}





	//*----------- MODIFY USER -----------*//
	public function modifyUser($filter, $column, $dataset, $response='COUNT', $limit=1){
		return $this->modify('CUPID', $filter, $column, $dataset, $response, $limit);
	}





	//*----------- MAINTAIN USER -----------*//
	public function maintainUser($filter, $column, $dataset=[], $guid='AUTO', $response='COUNT', $limit=1){
		return $this->maintain('CUPID', $filter, $column, $dataset, $guid, $response, $limit);
	}





	//*----------- REMOVE USER -----------*//
	public function removeUser($filter, $column, $response='COUNT', $limit=1){
		return $this->remove('CUPID', $filter, $column, $response, $limit);
	}





	//*----------- RE-INDEX USER -----------*//
	public function reindexUser($column='auid', $response='BOOL'){
		$table = $this->tables['CUPID'];
		return $this->reindex($column, $response, $table);
	}





	//*----------- RESET USER -----------*//
	public function resetUser($ignoreFK=false, $response='BOOL'){
		$table = $this->tables['CUPID'];
		return $this->reset($ignoreFK, $response, $table);
	}

} /*** End Of ~PatrevoModel ***/