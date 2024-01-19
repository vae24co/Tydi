<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* CRUD ~ CRUD Abstract • VERSION » alpha-0.0.5 ***/

interface CRUD {

	//*----------- DATABASE -----------*//
	public function createDatabase($database, $safe);
	public function retrieveDatabase($database);
	public function isDatabase($database);
	public function adoptDatabase($database, $response);
	public function deleteDatabase($database, $safe);





	//*----------- TABLE -----------*//
	public function createTable($table, $safe);
	public function retrieveTable($table, $database);
	public function isTable($table, $database);
	public function renameTable($table, $rename);
	public function deleteTable($table, $safe);
	public function reindexTable($table, $column);
	public function resetTable($table, $ignoreFK);





	//*----------- RECORD -----------*//
	public function createRecord($table, $input, $response);
	public function retrieveRecord($table, $column, $filter, $limit, $sort, $response);
	public function hasRecord($table, $column, $filter, $limit);
	public function countRecord($table, $column, $filter, $limit);
	public function updateRecord($table, $input, $filter, $limit, $response);
	public function saveRecord($table, $filter, $column, $input, $limit, $guid, $response);
	public function deleteRecord($table, $filter, $limit, $response);





	//*----------- COLUMN -----------*//

} /*** End Of ~CRUD ***/