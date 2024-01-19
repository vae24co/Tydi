<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* WOWCatholicModel ~ WOWCatholic Modelizr • VERSION » alpha-0.0.5 ***/

class WOWCatholicModel extends Modelizr {

	//*----------- INITIALIZE -----------*//
	public function initialize(){
		$setting = SETTING['WOWCATHOLIC'];
		if(!empty($setting['DATABASE'])){
			$settingDB = $setting['DATABASE'];
			if(isset($settingDB['USER'])){$init['user'] = $settingDB['USER'];}
			if(isset($settingDB['PASSWORD'])){$init['password'] = $settingDB['PASSWORD'];}
			if(isset($settingDB['NAME'])){$init['name'] = $settingDB['NAME'];}
			if(!empty($init)){$this->connect($init);}
			if(!empty($settingDB['TABLE'])){$this->tables = $settingDB['TABLE'];}
		}
	}





	//*----------- COUNTRY -----------*//
	public function country($id, $column='country', $response='ROW'){
		if(is_numeric($id)){
			$table = $this->tables['COUNTRY'];
			$result = $this->retrieve(['auid' => $id], $column, $response, 'NO_LIMIT', 'NO_SORT', $table);
			if($response === 'country' && isset($result[1]['country'])){return $result[1]['country'];}
			return $result;
		}
		return false;
	}










	//*----------- MAKE USER -----------*//
	public function makeUser($dataset, $response='BIND', $guid=''){
		return $this->make('USER', $dataset, $response, $guid);
	}





	//*----------- IN USER -----------*//
	public function inUser($filter, $column='puid', $limit=1){
		return $this->in('USER', $filter, $column, $limit);
	}





	//*----------- FIND USER -----------*//
	public function findUser($filter, $column, $response='ROW', $limit=1, $sort='NO_SORT'){
		return $this->find('USER', $filter, $column, $response, $limit, $sort);
	}





	//*----------- ALL USER -----------*//
	public function allUser($column, $limit, $sort='NO_SORT'){
		return $this->all('USER', $column, $limit, $sort);
	}





	//*----------- UPDATE USER -----------*//
	public function updateUser($filter, $dataset, $response='BOOL', $limit=1){
		$table = $this->tables['USER'];
		return $this->update($filter, $dataset, $response, $limit, $table);
	}





	//*----------- MODIFY USER -----------*//
	public function modifyUser($filter, $column, $dataset, $response='COUNT', $limit=1){
		return $this->modify('USER', $filter, $column, $dataset, $response, $limit);
	}





	//*----------- MAINTAIN USER -----------*//
	public function maintainUser($filter, $column, $dataset=[], $guid='AUTO', $response='COUNT', $limit=1){
		return $this->maintain('USER', $filter, $column, $dataset, $guid, $response, $limit);
	}





	//*----------- REMOVE USER -----------*//
	public function removeUser($filter, $column, $response='COUNT', $limit=1){
		return $this->remove('USER', $filter, $column, $response, $limit);
	}






	//*----------- GET USER INFO -----------*//
	public function getUserInfo($filter, $column, $response='ROW', $limit=1, $sort='NO_SORT'){
		$result = $this->findUser($filter, $column, $response, $limit, $sort);
		if(!empty($result) && is_array($result)){
			if(ArrayX::isMulti($result) && ArrayX::isNumericKey($result)){
				foreach($result as $index => $row){
					if(!empty($row['country']) && is_numeric($row['country'])){
						$country = $this->country($row['country'], 'country', 'country');
						if(!empty($country)){$row['country'] = oCleanX($country, 'UPPERCASE_WORD');}
					}
					$result[$index] = $row;
				}
			}
			else {
				foreach($result as $key => $value){
					if(!empty($key === 'country') && is_numeric($value)){
						$country = $this->country($result['country'], 'country', 'country');
						if(!empty($country)){$result['country'] = oCleanX($country, 'UPPERCASE_WORD');}
					}
				}
			}
		}
		return $result;
	}

} /*** End Of ~WOWCatholicModel ***/