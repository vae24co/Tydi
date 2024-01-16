<?php
class AuthApp extends Organizr {

	// » PROPERTY •
	protected $layout;





	// » INITIALIZE •
	public function initialize() {
		$this->layout = 'auth';
		if (isset($this->content['title']['page'])) {
			$this->content['title']['page'] = StringX::strip($this->content['title']['page'], ' Auth');
		}
	}





	// » LOGIN •
	public function login() {
		if (App::isPost()) {
			$method = 'POST';
			$param = ['userid', 'password'];
			$data = HTTP::data($method);
			$stack = DataQ::stack($data, $param);
			$input = DataQ::write($stack);
			if ($input['userid'] === 'admin' && $input['password'] === 'admin') {
				Redirect::instant(LinkUtil::navigator('dashboard'));
			}
		}
		App::layout($this->layout, $this->content);
	}





	// » LOCKED •
	public function locked() {
		App::layout($this->layout, $this->content);
	}





	// » FORGET PASSWORD •
	public function forgotPassword() {
		App::layout($this->layout, $this->content);
	}





	// » REGISTER •
	public function register() {
		App::layout($this->layout, $this->content);
	}

} // End Of Class ~ AuthApp