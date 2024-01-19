<?php
namespace Zero\Organizer;

use Zero\API\Response;


class Marketer {


	// • Profile
	public function profile() {
		$data = [
			"id" => "Yet3874",
			"title" => "NNPC Depot",
			"about" => "By enhancing our upstream production, expanding our gas processing and transportation services for domestic consumption, and exports. We will also revamp and expand our refining assets portfolio through greenfield projects with chemicals production integration and leverage equity partnerships.",
			"city" => "FCT",
			"address" => "Block C, 4th floor, NNPC Towers, Central Business District Garki Abuja, Nigeria",
			"dp" => "https://cloud.haulage.com.ng/nnpc.jpg",
			"cp" => "https://cloud.haulage.com.ng/nnpc-cover.jpg",
			"phone" => "08026636728",
			"whatsapp" => "+2348026636728",
			"email" => "info@nnpcgroup.com",
			"website" => "https://www.nnpcgroup.com"
		];
		Response::data($data, null, null, 'Marketer Profile');
	}
}