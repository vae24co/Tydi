<?php
class DashboardApp extends Organizr {

	// » PROPERTY •
	protected $layout;
	protected $model;
	protected $path;





	// » INITIALIZE •
	public function initialize() {
		$this->path = App::property('directory');
		$this->layout = 'main';
		$this->content['layout'] = $this->layout;
		$this->content['data'] = 'NO_RESULT';
	}





	// » LANDING •
	public function landing() {
		App::layout($this->layout, $this->content);
	}

} // End Of Class ~ DashboardApp