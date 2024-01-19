<?php
namespace Zero\Organizer;

use Zero\API\Response;


class Haulage {


	// • Listing
	public function listing() {
		$data = [
			[
				'id' => 'CekESNQ',
				'title' => "Mark Pinnacle",
				"capacity" => 35000,
				"rating" => "4.5",
				"dp" => "https://cloud.haulage.com.ng/haulage-i.jpg",
				'phone' => '08056860222',
				'whatsapp' => '+2348056860222',
				'route' => [
					'origin' => 'Lagos',
					'destination' => 'Abuja',
					'price' => 1250000
				]
			],


			[
				'id' => 'XH44IK',
				'title' => "Man TGX",
				"capacity" => 40000,
				"rating" => "4.2",
				"dp" => "https://cloud.haulage.com.ng/haulage-ii.jpg",
				'phone' => '09078899307',
				'whatsapp' => '+2349078899307',
				'route' => [
					'origin' => 'Lagos',
					'destination' => 'Kano',
					'price' => 3150000
				]
			],


			[
				'id' => '893IUX',
				'title' => "Iveco PowerStar 420 E5",
				"capacity" => 50000,
				"rating" => "2.2",
				"dp" => "https://cloud.haulage.com.ng/haulage-iii.jpg",
				'phone' => '09078899304',
				'whatsapp' => '+2349078899304',
				'route' => [
					'origin' => 'Lagos',
					'destination' => 'Ogun',
					'price' => 50000
				]
			],

			[
				'id' => '873YKI',
				'title' => "Embark Truck",
				"capacity" => 40000,
				"rating" => "4.5",
				"dp" => "https://cloud.haulage.com.ng/haulage-i.jpg",
				'phone' => '08056860222',
				'whatsapp' => '+2348056860272',
				'route' => [
					'origin' => 'Benin',
					'destination' => 'Abuja',
					'price' => 1250000
				]
			],


			[
				'id' => '536IK',
				'title' => "Gatik Truck",
				"capacity" => 40000,
				"rating" => "4.2",
				"dp" => "https://cloud.haulage.com.ng/haulage-ii.jpg",
				'phone' => '09078899307',
				'whatsapp' => '+2349078899307',
				'route' => [
					'origin' => 'Lagos',
					'destination' => 'Kano',
					'price' => 3150000
				]
			],


			[
				'id' => '78HYS',
				'title' => "Iveco PowerStar 420 E5",
				"capacity" => 50000,
				"rating" => "2.2",
				"dp" => "https://cloud.haulage.com.ng/haulage-iii.jpg",
				'phone' => '09078899304',
				'whatsapp' => '+2349078899304',
				'route' => [
					'origin' => 'Lagos',
					'destination' => 'Ogun',
					'price' => 50000
				]
			],

		];
		Response::data($data, null, null, 'Haulage Listing');
	}





	// • truckRoutes
	public function truckRoutes() {
		$data = [
			[
				'origin' => 'Lagos',
				'destination' => 'Ogun',
				'price' => 500000
			],
			[
				'origin' => 'Lagos',
				'destination' => 'Benin',
				'price' => 1000000
			],
			[
				'origin' => 'Benin',
				'destination' => 'Kano',
				'price' => 2500000
			],
			[
				'origin' => 'Enugu',
				'destination' => 'Sokoto',
				'price' => 3300000
			],
			[
				'origin' => 'Sokoto',
				'destination' => 'Plateau',
				'price' => 125000
			]
		];
		Response::data($data, null, null, 'Truck Routes');
	}





	// • truckInformation
	public function truckInformation() {
		$data = [
			'id' => '893IUX',
			'title' => "Iveco PowerStar 420 E5",
			"capacity" => 50000,
			"rating" => "4.2",
			"dp" => "https://cloud.haulage.com.ng/haluage-i.jpg",
			'cp' => [
				1 => 'https://cloud.haulage.com.ng/tanker-i.jpg',
				2 => 'https://cloud.haulage.com.ng/tanker-ii.jpg',
				3 => 'https://cloud.haulage.com.ng/tanker-iii.jpg',
				4 => 'https://cloud.haulage.com.ng/tanker-iv.jpg'
			],
			'phone' => '09078899304',
			'whatsapp' => '+2349078899304',
			'summary' => 'By enhancing our upstream production, expanding our gas processing and transportation services for domestic consumption, and exports. We will also revamp and expand our refining assets portfolio through greenfield projects with chemicals production integration and leverage equity partnerships.',
			'routes' => [
				[
					'origin' => 'Lagos',
					'destination' => 'Ogun',
					'price' => 500000
				],
				[
					'origin' => 'Lagos',
					'destination' => 'Benin',
					'price' => 1000000
				],
				[
					'origin' => 'Benin',
					'destination' => 'Kano',
					'price' => 2500000
				],
				[
					'origin' => 'Enugu',
					'destination' => 'Sokoto',
					'price' => 3300000
				],
				[
					'origin' => 'Sokoto',
					'destination' => 'Plateau',
					'price' => 125000
				]
			]
		];
		Response::data($data, null, null, 'Truck Information');
	}

}