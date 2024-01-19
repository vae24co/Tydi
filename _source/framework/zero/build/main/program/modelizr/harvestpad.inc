<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* HarvestpadModel ~ Profile Modelizr • VERSION » alpha-0.0.5 ***/

class HarvestpadModel extends Modelizr {

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





	//*----------- INSTALL HARVESTPAD USER -----------*//
	public function installHarvespadUser(){
		return $this->install('HARVESTPAD_USER');
	}





	//*----------- MAKE HARVESTPAD -----------*//
	public function makeUser($dataset, $response='BIND', $guid=''){
		return $this->make('HARVESTPAD_USER', $dataset, $response, $guid);
	}





	//*----------- IN HARVESTPAD -----------*//
	public function inUser($filter, $column='puid', $limit=1){
		return $this->in('HARVESTPAD_USER', $filter, $column, $limit);
	}





	//*----------- FIND HARVESTPAD USER -----------*//
	public function findUser($filter, $column, $response='ROW', $limit=1, $sort='NO_SORT'){
		return $this->find('HARVESTPAD_USER', $filter, $column, $response, $limit, $sort);
	}





	//*----------- ALL HARVESTPAD -----------*//
	public function allUser($column, $limit, $sort='NO_SORT'){
		return $this->all('HARVESTPAD_USER', $column, $limit, $sort);
	}





	//*----------- UPDATE HARVESTPAD -----------*//
	public function updateUser($filter, $dataset, $response='BOOL', $limit=1){
		$table = $this->tables['HARVESTPAD_USER'];
		return $this->update($filter, $dataset, $response, $limit, $table);
	}





	//*----------- MODIFY HARVESTPAD -----------*//
	public function modifyUser($filter, $column, $dataset, $response='COUNT', $limit=1){
		return $this->modify('HARVESTPAD_USER', $filter, $column, $dataset, $response, $limit);
	}





	//*----------- MAINTAIN HARVESTPAD -----------*//
	public function maintainUser($filter, $column, $dataset=[], $guid='AUTO', $response='COUNT', $limit=1){
		return $this->maintain('HARVESTPAD_USER', $filter, $column, $dataset, $guid, $response, $limit);
	}





	//*----------- REMOVE HARVESTPAD-----------*//
	public function removeUser($filter, $column, $response='COUNT', $limit=1){
		return $this->remove('HARVESTPAD_USER', $filter, $column, $response, $limit);
	}





	//*----------- RE-INDEX HARVESTPAD -----------*//
	public function reindexUser($column='auid', $response='BOOL'){
		$table = $this->tables['HARVESTPAD_USER'];
		return $this->reindex($column, $response, $table);
	}





	//*----------- RESET HARVESTPAD -----------*//
	public function resetUser($ignoreFK=false, $response='BOOL'){
		$table = $this->tables['HARVESTPAD_USER'];
		return $this->reset($ignoreFK, $response, $table);
	}

} /*** End Of ~HarvestpadModel ***/