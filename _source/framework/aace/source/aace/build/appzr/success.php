<?php
class SuccessApp extends Organizr {

	// » PROPERTY •
	protected $layout;





	// » INITIALIZE •
	public function initialize() {
		$this->layout = 'main';
		$this->content['layout'] = $this->layout;
	}





	// » LANDING •
	public function landing() {
		App::layout($this->layout, $this->content);
	}

} // End Of Class ~ SuccessApp