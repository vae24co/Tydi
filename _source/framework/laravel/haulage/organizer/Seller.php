<?php
namespace Zero\Organizer;

use Zero\API\Response;


class Seller {


	// • Listing
	public function listing() {
		$data = [
			[
				'id' => '7364BD',
				'serial' => '2921',
				'product' => "Petrol",
				"litre" => 30000,
				"city" => "Benin City",
				"timestamp" => "Nov 13, 2023  7:23 AM",
				"address" => "88, Morgan Street",
				"status" => "AVAILABLE",
				'proposal' => [
					"submitted" => 4,
					"photos" => [
						"I" => "https://cloud.haulage.com.ng/face-i.jpg",
						"II" => "https://cloud.haulage.com.ng/face-ii.jpg",
						"III" => "https://cloud.haulage.com.ng/face-iii.jpg",
					]
				],

				"seller" => [
					"id" => "43523eq",
					"dp" => "https://cloud.haulage.com.ng/seller.jpg",
					"cp" => "https://cloud.haulage.com.ng/seller-cover.jpg",
					"phone" => "05096636728",
					"whatsapp" => "+2348056676728",
					"email" => "mark@gmail.com",
					"website" => "https://mark.com"
				]
			],



			[
				'id' => '738yGST',
				'serial' => '64563',
				'product' => "Diesel",
				"litre" => 45000,
				"city" => "Port Harcourt",
				"timestamp" => "Nov 12, 2023  4:23 PM",
				"address" => "36, Kelvin Street",
				"status" => "AVAILABLE",
				'proposal' => [
					"submitted" => 4,
					"photos" => [
						"I" => "https://cloud.haulage.com.ng/face-iv.jpg",
						"II" => "https://cloud.haulage.com.ng/face-iii.jpg",
						"III" => "https://cloud.haulage.com.ng/face-v.jpg",
					]
				],

				"seller" => [
					"id" => "uYE37S",
					"dp" => "https://cloud.haulage.com.ng/seller.jpg",
					"cp" => "https://cloud.haulage.com.ng/seller-cover.jpg",
					"phone" => "08026636823",
					"whatsapp" => "+2348026636823",
					"email" => "john@gmail.com",
					"website" => ""
				]
			],


		];
		Response::data($data, null, null, 'Seller Listing');
	}
}