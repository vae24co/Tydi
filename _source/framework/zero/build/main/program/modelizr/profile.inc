<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* ProfileModel ~ Profile Modelizr • VERSION » alpha-0.0.5 ***/

class ProfileModel extends Modelizr {

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





	//*----------- INSTALL PROFILE -----------*//
	public function installProfile(){
		return $this->install('PROFILE');
	}





	//*----------- MAKE PROFILE -----------*//
	public function makeProfile($dataset, $response='BIND', $guid=''){
		if(empty($dataset['tuid'])){
			$dataset['tuid'] = RandomX::tuid();
			$dataset['oauthid'] = $dataset['tuid'];
		}
		return $this->make('PROFILE', $dataset, $response, $guid);
	}





	//*----------- IN PROFILE -----------*//
	public function inProfile($filter, $column='puid', $limit=1){
		return $this->in('PROFILE', $filter, $column, $limit);
	}





	//*----------- FIND PROFILE -----------*//
	public function findProfile($filter, $column, $response='ROW', $limit=1, $sort='NO_SORT'){
		return $this->find('PROFILE', $filter, $column, $response, $limit, $sort);
	}





	//*----------- ALL PROFILE -----------*//
	public function allProfile($column, $limit, $sort='NO_SORT'){
		return $this->all('PROFILE', $column, $limit, $sort);
	}





	//*----------- UPDATE PROFILE -----------*//
	public function updateProfile($filter, $dataset, $response='BOOL', $limit=1){
		$table = $this->tables['PROFILE'];
		return $this->update($filter, $dataset, $response, $limit, $table);
	}





	//*----------- MODIFY PROFILE -----------*//
	public function modifyProfile($filter, $column, $dataset, $response='COUNT', $limit=1){
		return $this->modify('PROFILE', $filter, $column, $dataset, $response, $limit);
	}





	//*----------- MAINTAIN PROFILE -----------*//
	public function maintainProfile($filter, $column, $dataset=[], $guid='AUTO', $response='COUNT', $limit=1){
		return $this->maintain('PROFILE', $filter, $column, $dataset, $guid, $response, $limit);
	}





	//*----------- REMOVE PROFILE-----------*//
	public function removeProfile($filter, $column, $response='COUNT', $limit=1){
		return $this->remove('PROFILE', $filter, $column, $response, $limit);
	}





	//*----------- RE-INDEX PROFILE -----------*//
	public function reindexProfile($column='auid', $response='BOOL'){
		$table = $this->tables['PROFILE'];
		return $this->reindex($column, $response, $table);
	}





	//*----------- RESET PROFILE -----------*//
	public function resetProfile($ignoreFK=false, $response='BOOL'){
		$table = $this->tables['PROFILE'];
		return $this->reset($ignoreFK, $response, $table);
	}

} /*** End Of ~ProfileModel ***/