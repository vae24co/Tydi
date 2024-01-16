<?php
/*** Organizr ~ Organizr » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © 2023 | Apache License ***/

abstract class Organizr {

	// ◇ PROPERTY •
	public $content;
	protected $layout = 'primary';





	// ◇ ----- ABSTRACT METHOD •
	abstract public function initialize();





	// ◇ ----- CHILD • Child Method »
	public function child($method, ...$argument) {
		if (method_exists($this, $method)) {
			return $this->$method(...$argument);
		}
		return false;
	}





	// ◇ ----- CONSTRUCT •
	public function __construct() {

		$App = new App();
		$title = '';
		$breadcrumb['primary'] = $App::$codify->name;
		if ($App::$codify->method !== 'landing') {
			$title = ucwords(StringX::uppercaseToSpace($App::$codify->method));
			$breadcrumb['secondary'] = ucwords($title);
		} elseif ($App::$codify->name !== 'Index') {
			$title = ucwords($App::$codify->name);
		} else {
			$title = 'Home';
		}

		if ($breadcrumb['primary'] === 'Index') {
			$breadcrumb['primary'] = 'Home';
		}

		$this->content = [
			'layout' => $this->layout,
			'title' => ['page' => $App->title(), 'section' => $title],
			'breadcrumb' => $breadcrumb
		];

		$this->initialize();
	}






	// ◇ ----- LANDING •
	public function landing() {
	}

} // End Of Class ~ Organizr