<?php
/*** Database ~ Database Interface » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

interface DatabaseInterface {

	// ◇ ----- MORE •
	public function verify();
	public function validate($object, $req);
	public function initialize(array $config = []);
	public function dbo($var = null);
	public function guid($guid = null);
	public function table($req, $table = null);
	public function connect(&$dbo = null);
	public function property($var, $req);
	public function disconnect(&$var = null);





	// ◇ ----- CRUD • Data Manipulation
	public function create($table, $input, $yield = 'puid', $guid = null);
	public function search($table, $filter, $column, $limit = 20, $yield = 'ROWS', $sort = 'SORT');
	public function exist($table, $filter, $column = 'auid');
	public function count($table, $filter, $column = 'auid');
	public function update($table, $filter, $input, $yield = 'BOOL', $limit = 1);
	public function delete($table, $filter, $limit = 1, $yield = 'BOOL');

} // End Of Interface ~ Database