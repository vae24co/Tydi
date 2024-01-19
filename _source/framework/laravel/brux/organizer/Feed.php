<?php
namespace Zero\Organizer;

use Zero\API\Response;


class Feed {


	// • Pricing
	public function pricing() {
		$data = [
			[
				"id" => "43XTXyOi97743",
				"product" => "Diesel",
				"price" => 848,
				"timestamp" => "Nov 13, 2023  2:47 AM",
				"marketer" => [
					"id" => "Yet3874",
					"title" => "NNPC Depot",
					"city" => "Port Harcourt",
					"dp" => "https://cloud.haulage.com.ng/nnpc.jpg",
					"phone" => "08026636728",
					"whatsapp" => "+2348026636728"
				]
			],
			[
				"id" => "257375IUISHiw",
				"product" => "Kerosine",
				"price" => 568,
				"timestamp" => "Nov 13, 2023  01:47 AM",
				"marketer" => [
					"id" => "457GSYw",
					"title" => "NNPC Depot",
					"city" => "Ikeja",
					"dp" => "https://cloud.haulage.com.ng/nnpc.jpg",
					"phone" => "08036636728",
					"whatsapp" => ""
				]
			]
		];
		Response::data($data, null, null, 'Pricing Updates');
	}
}