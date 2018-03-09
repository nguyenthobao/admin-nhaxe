<?php
//Code by Nguyen Xuan Truong
// error_reporting(0);
class Social extends \Bncv2\Core\Controller {
	function __construct() {
		parent::__construct();
		$this->model = $this->loadModel('ModelSocial');
	}

	// public function index() {
	// 	global $_DATA;
	// 	$_S['breadcrumb_page'] = lang('breadcrumb_add_slide');
	// 	$_S['title']           = lang('title');
	// 	$_S['description']     = lang('description');
	// 	if (isset($_POST['route'])) {
	// 		$layout = $this->request->get_string('layout', 'POST');
	// 		$route  = $this->request->get_string('route', 'POST');
	// 		$title  = $this->request->get_string('title', 'POST');
	// 		$data   = array(
	// 			'idw'         => $this->idw,
	// 			'layout_name' => $layout,
	// 			'title'       => $title,
	// 			'router'      => $route,
	// 		);
	// 		if ($this->model->checkExistRoute($route) == true) {
	// 			$_SESSION['error_submit'] = 'Có lỗi trong quá trình khởi tạo';
	// 		} else {
	// 			$result = $this->model->addLayout($data);
	// 			if ($result == true) {
	// 				$_SESSION['success'] = 'Tạo layout thành công';
	// 			} else {
	// 				$_SESSION['error_submit'] = 'Có lỗi trong quá trình khởi tạo';
	// 			}
	// 		}
	// 		header('Location:/template-addLayout-index-lang-' . $this->langDefault);
	// 	}
	// 	//Load theme cho page add slide
	// 	$_DATA['content_module'] = $this->temp->load('addLayout');
	// }
	// public function chatFace() {
	// 	global $_DATA;
	// 	include_once DIR_MODULES . 'template/global/global.php'; //Load model global dùng chung
	// 	$global_block_nxt        = new global_block_nxt;
	// 	$_S['breadcrumb_page']   = lang('breadcrumb_add_slide');
	// 	$_S['title']             = lang('title');
	// 	$_S['description']       = lang('description');
	// 	//$id                      = $this->request->get_int('id', 'GET');
	// 	$_DATA['lang_tab'] = $this->langTab(true);
	// 	$_DATA['lang']     = $this->lang;
	// 	$_DATA['item']           = $this->model->getChatFace();
	// 	$_DATA['content_module'] = $this->temp->load('addChatFace');
	// }

	public function add() {
		global $_DATA;
		$_S['breadcrumb_page'] = lang('breadcrumb_add_slide');
		$_S['title']           = lang('title');
		$_S['description']     = lang('description');
		$_DATA['lang_tab'] = $this->langTab(true);
		$_DATA['lang']     = $this->lang;
		include_once DIR_MODULES . 'template/global/global.php'; //Load model global dùng chung
		$global_block_nxt = new global_block_nxt;
		$_DATA['position'] = $global_block_nxt->routerPosition();
		$_DATA['content_module'] = $this->temp->load('addSocial');
	}

	public function ajaxAdd() {
		$data = array(
			'title'        => $this->request->get_string('title', 'POST'),
			'data_custome' => $this->request->get_string('url', 'POST'), //Url pages
			'position'     => $this->request->get_int('position', 'POST'),
		);
		$id  = $this->request->get_int('id', 'POST');
		$res = $this->model->saveBlock($data, $id);
		echo json_encode($res);
	}
	// public function ajaxAddChat() {
	// 	$data = array(
	// 		'title'        => $this->request->get_string('title', 'POST'),
	// 		'data_custome' => $this->request->get_string('url', 'POST'), //Url pages
	// 	);
	// 	$id  = $this->request->get_int('id', 'POST');
	// 	$res = $this->model->saveBlockChat($data, $id);
	// 	echo json_encode($res);
	// }
	// public function ajaxDellChat(){
	// 	$id  = $this->request->get_int('id', 'POST');
	// 	$res = $this->model->dellChat($id);
	// }
	public function index() {
		global $_DATA;
		$_S['breadcrumb_page'] = lang('breadcrumb_add_slide');
		$_S['title']           = lang('title');
		$_S['description']     = lang('description');

		$_DATA['lang_tab'] = $this->langTab(true);
		$_DATA['lang']     = $this->lang;
		
		$_DATA['link_add']       = $this->home . '/' . $this->mod . '-' . $this->page . '-add-lang-' . $this->lang;
		$_DATA['content']        = $this->model->getAll();
		$_DATA['content_module'] = $this->temp->load('blocksocial');
	}

	public function edit() {
		global $_DATA;
		include_once DIR_MODULES . 'template/global/global.php'; //Load model global dùng chung
		$global_block_nxt        = new global_block_nxt;
		$_S['breadcrumb_page']   = lang('breadcrumb_add_slide');
		$_S['title']             = lang('title');
		$_S['description']       = lang('description');
		$id                      = $this->request->get_int('id', 'GET');
		$_DATA['lang_tab'] = $this->langTab(true);
		$_DATA['lang']     = $this->lang;
		$_DATA['item']           = $this->model->getById($id);
		$_DATA['position']       = $global_block_nxt->routerPosition();
		$_DATA['content_module'] = $this->temp->load('addSocial');
	}

}