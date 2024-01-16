<?php
//*** ExceptionX » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
class ExceptionX extends Exception {
	protected $response;

	// ◇ ==== construct →
	public function __construct($response = [], $message = '', $code = 0, Throwable $previous = null) {
		$this->response = $response;
		parent::__construct($message, $code, $previous);
	}


	// ◇ ==== getResponse →
	public function getResponse() {
		return $this->response;
	}
} //> end of ExceptionX
