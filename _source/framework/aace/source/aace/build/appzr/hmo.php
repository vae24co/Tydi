<?php
class HMOApp extends Organizr {

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
		$this->model = new HMOModel;
	}





	// » CREATE •
	public function create() {
		$this->content['breadcrumb']['title'] = 'Create HMO';
		$view = null;
		if (App::isPost()) {
			$method = 'POST';
			$param = ['title', 'code', 'email', 'phone', 'website', 'address', 'contact'];
			$data = HTTP::data($method);
			$stack = DataQ::stack($data, $param);
			$input = DataQ::write($stack);
			$input['contact'] = ArrayX::toJSON($input['contact']);

			$action = $this->model->oCreate($input, 'STRING');
			if ($action === 'CREATED') {
				$view = $this->path->viewzr . 'hmo' . DS . 'success' . DS . 'created.php';
			}
		}
		App::layout($this->layout, $this->content, $view);
	}





	// » LIST •
	public function list() {
		$this->content['breadcrumb']['title'] = 'List of HMO';
		$this->content['data'] = $this->model->oFindAll();
		$view = null;
		App::layout($this->layout, $this->content, $view);
	}





	// » EDIT •
	public function edit() {
		$this->content['breadcrumb']['title'] = 'Edit HMO';
		$view = null;

		$id = DataQ::stackOne('GET', 'id');
		$hmo = $this->model->oFindByID($id);
		if (!empty($hmo)) {
			$this->content['breadcrumb']['title'] = $hmo['title'];
			$this->content['data'] = $hmo;
		}

		if (App::isPost()) {
			$method = 'POST';
			$param = ['title', 'code', 'email', 'phone', 'website', 'address', 'contact'];
			$data = HTTP::data($method);
			$stack = DataQ::stack($data, $param);
			$input = DataQ::write($stack);
			$input['contact'] = ArrayX::toJSON($input['contact']);

			$action = $this->model->oUpdateOne(['puid' => $id], $input, 'STRING');
			if ($action === 'UPDATED') {
				$view = $this->path->viewzr . 'hmo' . DS . 'success' . DS . 'updated.php';
			}
		}

		App::layout($this->layout, $this->content, $view);
	}





	// » UNLIST •
	public function unlist() {
		if (App::isGet()) {
			$id = DataQ::stackOne('GET', 'id');
			$hmo = $this->model->oFindByID($id);
			if (!empty($hmo)) {
				$this->content['breadcrumb']['title'] = $hmo['title'];
				$this->content['data'] = $hmo;
				$this->model->oUpdateOne(['puid' => $id], ['status' => 'UNLIST']);
			}
			$path = App::property('directory');
			$view = $path->viewzr . 'hmo' . DS . 'success' . DS . 'unlisted.php';
		}
		App::layout($this->layout, $this->content, $view);
	}





	// » ENLIST •
	public function enlist() {
		if (App::isGet()) {
			$id = DataQ::stackOne('GET', 'id');
			$hmo = $this->model->oFindByID($id);
			if (!empty($hmo)) {
				$this->content['breadcrumb']['title'] = $hmo['title'];
				$this->content['data'] = $hmo;
				$this->model->oUpdateOne(['puid' => $id], ['status' => 'PENDING']);
			}
			$path = App::property('directory');
			$view = $path->viewzr . 'hmo' . DS . 'success' . DS . 'enlisted.php';
		}
		App::layout($this->layout, $this->content, $view);
	}





	// » ACTIVATE •
	public function activate() {
		if (App::isGet()) {
			$id = DataQ::stackOne('GET', 'id');
			$hmo = $this->model->oFindByID($id);
			if (!empty($hmo)) {
				$this->content['breadcrumb']['title'] = $hmo['title'];
				$this->content['data'] = $hmo;
				$this->model->oUpdateOne(['puid' => $id], ['status' => 'ACTIVE']);
			}
			$path = App::property('directory');
			$view = $path->viewzr . 'hmo' . DS . 'success' . DS . 'activated.php';
		}
		App::layout($this->layout, $this->content, $view);
	}





	// » DEACTIVATE •
	public function deactivate() {
		if (App::isGet()) {
			$id = DataQ::stackOne('GET', 'id');
			$hmo = $this->model->oFindByID($id);
			if (!empty($hmo)) {
				$this->content['breadcrumb']['title'] = $hmo['title'];
				$this->content['data'] = $hmo;
				$this->model->oUpdateOne(['puid' => $id], ['status' => 'INACTIVE']);
			}
			$path = App::property('directory');
			$view = $path->viewzr . 'hmo' . DS . 'success' . DS . 'deactivated.php';
		}
		App::layout($this->layout, $this->content, $view);
	}





	// » SEARCH •
	public function search() {
		$this->content['breadcrumb']['title'] = 'Search for HMO';
		$this->content['data'] = $this->model->oFindAll();
		$view = null;
		App::layout($this->layout, $this->content, $view);
	}





	// » DELETE •
	public function delete() {
		if (App::isGet()) {
			$bind = DataQ::stackOne('GET', 'id');
			$hmo = $this->model->oFindByBIND($bind);
			if (!empty($hmo)) {
				$this->content['breadcrumb']['title'] = $hmo['title'];
				$this->content['data'] = $hmo;
				$this->model->oDeleteOne(['tuid' => $bind]);
			}
			$path = App::property('directory');
			$view = $path->viewzr . 'hmo' . DS . 'success' . DS . 'deleted.php';
		}
		App::layout($this->layout, $this->content, $view);
	}
































	// » LANDING •
	public function landing() {
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





	public function createPlan() {
		if (App::isGet()) {
			$id = DataQ::stackOne('GET', 'id');
			$hmo = $this->model->oFindByID($id);
			if (!empty($hmo)) {
				$this->content['breadcrumb']['title'] = 'Plans for ' . $hmo['title'];
			}
		}
		App::layout($this->layout, $this->content);
	}







	// » PLANS •
	public function plans() {
		$this->content['breadcrumb']['title'] = 'HMO Plans';
		if (App::isGet()) {
			$id = null;
			if (VarX::hasData($_GET['id'])) {
				$id = DataQ::stackOne('GET', 'id');
			}
			$this->content['data'] = $this->model->oFindByID($id);
			if (!empty($this->content['data'])) {
				$this->content['breadcrumb']['title'] = 'Plans for ' . $this->content['data']['title'];
			}
		}
		App::layout($this->layout, $this->content);
	}




































} // End Of Class ~ HMOApp