<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* ParishModel ~ Profile Modelizr • VERSION » alpha-0.0.5 ***/

class ParishModel extends Modelizr {

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





	//*----------- INSTALL PARISH -----------*//
	public function installParish(){
		return $this->install('PARISH');
	}





	//*----------- MAKE PARISH -----------*//
	public function makeParish($dataset, $response='IDs', $guid=''){
		return $this->make('PARISH', $dataset, $response, $guid);
	}





	//*----------- IN PARISH -----------*//
	public function inParish($filter, $column='puid', $limit=1){
		return $this->in('PARISH', $filter, $column, $limit);
	}





	//*----------- FIND PARISH -----------*//
	public function findParish($filter, $column, $response='ROW', $limit=1, $sort='NO_SORT'){
		return $this->find('PARISH', $filter, $column, $response, $limit, $sort);
	}





	//*----------- ALL PARISH -----------*//
	public function allParish($column, $limit, $sort='NO_SORT'){
		return $this->all('PARISH', $column, $limit, $sort);
	}





	//*----------- UPDATE PARISH -----------*//
	public function updateParish($filter, $dataset, $response='BOOL', $limit=1){
		$table = $this->tables['PARISH'];
		return $this->update($filter, $dataset, $response, $limit, $table);
	}





	//*----------- MODIFY PARISH -----------*//
	public function modifyParish($filter, $column, $dataset, $response='COUNT', $limit=1){
		return $this->modify('PARISH', $filter, $column, $dataset, $response, $limit);
	}





	//*----------- MAINTAIN PARISH -----------*//
	public function maintainParish($filter, $column, $dataset=[], $guid='AUTO', $response='COUNT', $limit=1){
		return $this->maintain('PARISH', $filter, $column, $dataset, $guid, $response, $limit);
	}





	//*----------- REMOVE PARISH-----------*//
	public function removeParish($filter, $column, $response='COUNT', $limit=1){
		return $this->remove('PARISH', $filter, $column, $response, $limit);
	}





	//*----------- RE-INDEX PARISH -----------*//
	public function reindexParish($column='auid', $response='BOOL'){
		$table = $this->tables['PARISH'];
		return $this->reindex($column, $response, $table);
	}





	//*----------- RESET PARISH -----------*//
	public function resetParish($ignoreFK=false, $response='BOOL'){
		$table = $this->tables['PARISH'];
		return $this->reset($ignoreFK, $response, $table);
	}

} /*** End Of ~ParishModel ***/