<?php
namespace Zero\Organizer;

use Zero\API\Response;


class Support {


	// • Information
	public function information() {
		$data = [
			'id' => 'CekESNQ',
			'address' => 'Block C, 4th floor, NNPC Towers, Central Business District Garki Abuja, Nigeria',
			'email' => 'info@haulage.ng',
			'website' => 'https://www.haulage.ng',
			'phone' => '08056860222',
			'whatsapp' => '+2348056860222'
		];
		Response::data($data, 1, null, 'Support Information');
	}
}