<?php
//Code by Nguyen Xuan Truong
// error_reporting(0);
class Support extends \Bncv2\Core\Controller {
	function __construct() {
		parent::__construct();
		$this->model = $this->loadModel('ModelSupport');
	}

	public function add() {
		global $_DATA;
		$_S['breadcrumb_page'] = lang('breadcrumb_add_slide');
		$_S['title']           = lang('title');
		$_S['description']     = lang('description');
		$_DATA['lang_tab']     = $this->langTab(true);
		$_DATA['lang']         = $this->lang;
		include_once DIR_MODULES . 'template/global/global.php'; //Load model global dùng chung
		$global_block_nxt        = new global_block_nxt;
		$_DATA['position']       = $global_block_nxt->routerPosition();
		$_DATA['content_module'] = $this->temp->load('addSupport');
	}

	public function ajaxAdd() {
		$id   = $this->request->get_int('id', 'POST');
		$data = array(
			'title'        => $this->request->get_string('title', 'POST'),
			'position'     => $this->request->get_int('position', 'POST'),
			'data_custome' => json_encode($this->request->get_array('data_custome', 'POST')),
		);
		$res = $this->model->saveBlock($data, $id);
		echo json_encode($res);
	}

	public function index() {
		global $_DATA;
		$_S['breadcrumb_page'] = lang('breadcrumb_add_slide');
		$_S['title']           = lang('title');
		$_S['description']     = lang('description');

		$_DATA['lang_tab'] = $this->langTab(true);
		$_DATA['lang']     = $this->lang;

		$_DATA['link_add']       = $this->home . '/' . $this->mod . '-' . $this->page . '-add-lang-' . $this->lang;
		$_DATA['content']        = $this->model->getAll();
		$_DATA['content_module'] = $this->temp->load('blocksupport');
	}

	public function edit() {
		global $_DATA;
		include_once DIR_MODULES . 'template/global/global.php'; //Load model global dùng chung
		$global_block_nxt              = new global_block_nxt;
		$_S['breadcrumb_page']         = lang('breadcrumb_add_slide');
		$_S['title']                   = lang('title');
		$_S['description']             = lang('description');
		$id                            = $this->request->get_int('id', 'GET');
		$_DATA['lang_tab']             = $this->langTab(true);
		$_DATA['lang']                 = $this->lang;
		$_DATA['item']                 = $this->model->getById($id);
		$_DATA['item']['data_custome'] = json_decode($_DATA['item']['data_custome'], true);
		
		$_DATA['position']             = $global_block_nxt->routerPosition();
		$_DATA['content_module']       = $this->temp->load('addSupport');
	}

}