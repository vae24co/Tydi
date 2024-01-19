<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* IndexApp ~ Index API Organizr • VERSION » alpha-0.0.7 ***/

class IndexApp extends AppOrganizr {

	//*----------- INITIALIZE -----------*//
	public function initialize(){

	}





	//*----------- LANDING -----------*//
	public function landing(&$object){
		RedirectX::goto('admin/login/');
	}



















} /*** End Of ~IndexApp ***/

// public function example(&$object){
	// $view = APP_VIEWZR.$object->model.'.inc';
	// $spet = new SpetX();
	// $spet->Tag('SLICE', $spet->content(APP_VIEWZR.'slice.inc'));
	// $spet->Tag('author', 'Anthony Osawere');

	// $bio['age'] = '35';
	// $bio['sex'] = 'Male';
	// $bio['location']['city'] = 'FCT';

	// $bio = [
		// 	1 => ['Name' => 'John Doe', 'age' => 22],
		// 	2 => ['Name' => 'Jane Doe', 'age' => 25],
		// ];
		// $label = array(
			// 	'location' => 'West-Africa',
			// 	'role' => 'Software Engineer',
			// 	'username' => 'iamodao'
			// );
			// $spet->doTags($label);
			// $spet->render(APP_VIEWZR.$object->model.'.inc', $bio);
			// }