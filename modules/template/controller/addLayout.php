<?php
//Code by Nguyen Xuan Truong
// error_reporting(0);
class addLayout {
	function __construct() {
		global $_B, $web;
		$this->temp        = $_B['temp'];
		$this->request     = $_B['r'];
		$this->idw         = $_B['web']['idw'];
		$this->langDefault = $_B['cf']['lang'];
		$this->model       = new ModelAddLayout;
	}

	public function index() {
		global $_DATA;

		$_S['breadcrumb_page'] = lang('breadcrumb_add_slide');
		$_S['title']           = lang('title');
		$_S['description']     = lang('description');
		if (isset($_POST['route'])) {
			$layout = $this->request->get_string('layout', 'POST');
			$route  = $this->request->get_string('route', 'POST');
			$title  = $this->request->get_string('title', 'POST');
			$data   = array(
				'idw'         => $this->idw,
				'layout_name' => $layout,
				'title'       => $title,
				'router'      => $route,
			);

			if ($this->model->checkExistRoute($route) == true) {
				$_SESSION['error_submit'] = 'Có lỗi trong quá trình khởi tạo';
			} else {
				$result = $this->model->addLayout($data);
				if ($result == true) {
					$_SESSION['success'] = 'Tạo layout thành công';
				} else {
					$_SESSION['error_submit'] = 'Có lỗi trong quá trình khởi tạo';
				}
			}
			header('Location:/template-addLayout-index-lang-' . $this->langDefault);
		}
		//Load theme cho page add slide
		$_DATA['content_module'] = $this->temp->load('addLayout');
	}

	public function ajaxCheckExistRoute() {
		$route = $this->request->get_string('route');
		//Check
		$check = $this->model->checkExistRoute($route);
		if ($check == true) {
			$result = array(
				'status'   => false,
				'messages' => 'Đường dẫn này đã tồn tại.',
			);
		} else {
			$result = array(
				'status' => true,
			);
		}
		echo json_encode($result);
	}

	public function listLayout() {
		global $_DATA;
		$_S['breadcrumb_page'] = lang('breadcrumb_add_slide');
		$_S['title']           = lang('title');
		$_S['description']     = lang('description');

		$result                  = $this->model->listLayout();
		$_DATA['content']        = $result;
		$_DATA['content_module'] = $this->temp->load('addLayoutList');
	}

	public function ajaxChangeTitle() {
		$title = $this->request->get_string('value', 'POST');
		$id    = $this->request->get_int('pk', 'POST');
		$data  = array(
			'title' => $title,
		);
		$this->model->change($data, $id);
		$result = array(
			'status' => true,
		);
		echo json_encode($result);
		exit();
	}

	public function ajaxChangeLayout() {
		$layout = $this->request->get_string('value', 'POST');
		$id     = $this->request->get_int('pk', 'POST');
		$data   = array(
			'layout_name' => $layout,
		);
		$this->model->change($data, $id);
		$result = array(
			'status' => true,
		);
		echo json_encode($result);
		exit();
	}

	public function ajaxChangeRoute() {
		$route = $this->request->get_string('value', 'POST');
		$id    = $this->request->get_int('pk', 'POST');
		$data  = array(
			'router' => $route,
		);
		$this->model->change($data, $id);
		$result = array(
			'status' => true,
		);
		echo json_encode($result);
		exit();
	}
	public function ajaxDelete() {
		$id = $this->request->get_int('id', 'POST');
		$this->delete($id);
		$result = array(
			'status' => true,
		);
		echo json_encode($result);
		exit();
	}

	public function ajaxMultiDelete() {
		$id = $this->request->get_array('id', 'POST');
		foreach ($id as $k => $v) {
			$this->delete($v);
		}

		$result = array(
			'status' => true,
		);
		echo json_encode($result);
		exit();
	}

	private function delete($id) {
		$this->model->delete($id);
		return true;
	}

}