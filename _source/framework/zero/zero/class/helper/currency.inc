<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* CurrencyQ ~ Currency Utility • VERSION » alpha-0.0.1 ***/

class CurrencyQ {

	#DATABASE • Currency database
	public static function database(){
		$o = array(
			'NGN' => array('SYMBOL' => '₦', 'COUNTRY' => 'Nigeria', 'CURRENCY' => 'Naira'),
			'USD' => array('SYMBOL' => '$', 'COUNTRY' => 'United States', 'CURRENCY' => 'Dollar'),
			'GBP' => array('SYMBOL' => '£', 'COUNTRY' => 'United Kingdom', 'CURRENCY' => 'Pound'),
			'EUR' => array('SYMBOL' => '€', 'COUNTRY' => 'Europe', 'CURRENCY' => 'Euro'),
			'JPY' => array('SYMBOL' => '¥', 'COUNTRY' => 'Japan', 'CURRENCY' => 'Yen'),
			'INR' => array('SYMBOL' => '₹', 'COUNTRY' => 'India', 'CURRENCY' => 'Rupee'),
		);
		return $o;
	}

} /*** End Of ~CurrencyQ ***/