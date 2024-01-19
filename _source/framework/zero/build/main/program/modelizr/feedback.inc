<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* FeedbackModel ~ Profile Modelizr • VERSION » alpha-0.0.5 ***/

class FeedbackModel extends Modelizr {

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





	//*----------- INSTALL FEEDBACK -----------*//
	public function installFeedback(){
		return $this->install('FEEDBACK');
	}





	//*----------- MAKE FEEDBACK -----------*//
	public function makeFeedback($dataset, $response='IDs', $guid=''){
		return $this->make('FEEDBACK', $dataset, $response, $guid);
	}





	//*----------- IN FEEDBACK -----------*//
	public function inFeedback($filter, $column='puid', $limit=1){
		return $this->in('FEEDBACK', $filter, $column, $limit);
	}





	//*----------- FIND FEEDBACK -----------*//
	public function findFeedback($filter, $column, $response='ROW', $limit=1, $sort='NO_SORT'){
		return $this->find('FEEDBACK', $filter, $column, $response, $limit, $sort);
	}





	//*----------- ALL FEEDBACK -----------*//
	public function allFeedback($column, $limit, $sort='NO_SORT'){
		return $this->all('FEEDBACK', $column, $limit, $sort);
	}





	//*----------- UPDATE FEEDBACK -----------*//
	public function updateFeedback($filter, $dataset, $response='BOOL', $limit=1){
		$table = $this->tables['FEEDBACK'];
		return $this->update($filter, $dataset, $response, $limit, $table);
	}





	//*----------- MODIFY FEEDBACK -----------*//
	public function modifyFeedback($filter, $column, $dataset, $response='COUNT', $limit=1){
		return $this->modify('FEEDBACK', $filter, $column, $dataset, $response, $limit);
	}





	//*----------- MAINTAIN FEEDBACK -----------*//
	public function maintainFeedback($filter, $column, $dataset=[], $guid='AUTO', $response='COUNT', $limit=1){
		return $this->maintain('FEEDBACK', $filter, $column, $dataset, $guid, $response, $limit);
	}





	//*----------- REMOVE FEEDBACK-----------*//
	public function removeFeedback($filter, $column, $response='COUNT', $limit=1){
		return $this->remove('FEEDBACK', $filter, $column, $response, $limit);
	}





	//*----------- RE-INDEX FEEDBACK -----------*//
	public function reindexFeedback($column='auid', $response='BOOL'){
		$table = $this->tables['FEEDBACK'];
		return $this->reindex($column, $response, $table);
	}





	//*----------- RESET FEEDBACK -----------*//
	public function resetFeedback($ignoreFK=false, $response='BOOL'){
		$table = $this->tables['FEEDBACK'];
		return $this->reset($ignoreFK, $response, $table);
	}

} /*** End Of ~FeedbackModel ***/