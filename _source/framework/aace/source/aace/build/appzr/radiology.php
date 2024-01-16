<?php
class RadiologyApp extends Organizr {

	// » PROPERTY •
	protected $layout;
	protected $model;





	// » INITIALIZE •
	public function initialize() {
		$this->layout = 'main';
		$this->content['layout'] = $this->layout;
		$this->model = new RadiologyModel;
	}





	// » LANDING •
	public function landing() {
		App::layout($this->layout, $this->content);
	}





	// » CREATE •
	public function create() {
		$this->content['breadcrumb']['title'] = 'Create Radiology';
		if (App::isPost()) {
			$method = 'POST';
			$param = ['generic', 'title', 'description', 'price', 'effect'];
			$data = HTTP::data($method);
			$stack = DataQ::stack($data, $param);
			$input = DataQ::write($stack);
			$action = $this->model->oCreate($input, 'STRING');
			if ($action === 'CREATED') {
				Redirect::instant(LinkUtil::navigator('success'));
			}
		}
		App::layout($this->layout, $this->content);
	}





	// » LIST •
	public function list() {
		$this->content['breadcrumb']['title'] = 'List of Radiology';
		$this->content['data'] = $this->model->oFindAll();
		App::layout($this->layout, $this->content);
	}





	// » LIST UNLIST •
	public function listUnlist() {
		App::layout($this->layout, $this->content);
	}




	// » LIST DELETE •
	public function listDelete() {
		App::layout($this->layout, $this->content);
	}

} // End Of Class ~ RadiologyApp