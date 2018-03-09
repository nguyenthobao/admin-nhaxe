<?php
/**
 *
 */
class redirecturl{

	function __construct() {
		global $_B, $_DATA;
		$this->request = $_B['r'];
		$this->idw     = $_B['web']['idw'];
		$this->uid     = $_B['uid'];
		$this->lang    = $this->request->get_string('lang', 'GET');
		$this->model   = new Model_RedirectUrl;
	}

	public function index() {
		global $_B, $_DATA;
		
		$_DATA['content']= $this->model->geturl();
		$_DATA['content_module'] = $_B['temp']->load('redirect_url');
	}
	

}