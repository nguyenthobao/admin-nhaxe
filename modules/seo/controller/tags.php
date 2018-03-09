<?php
/**
 *
 */
class Tags {

	function __construct() {
		global $_B, $_DATA;
		$this->request = $_B['r'];
		$this->idw     = $_B['web']['idw'];
		$this->uid     = $_B['uid'];
		$this->lang    = $this->request->get_string('lang', 'GET');
		$this->model   = new Model_Tags;
	}

	public function index() {
		global $_B, $_DATA;
		$page = $this->request->get_int('p', 'GET');
		$tags = $this->model->getList($page, 30);

		$_DATA['content'] = $tags['tags'];
		if (isset($tags['pagination'])) {
			$_DATA['pagination'] = $tags['pagination'];
		}
		$_DATA['content_module'] = $_B['temp']->load('tagsList');
	}

	public function ajaxChangeTitle() {
		$id    = $this->request->get_int('pk', 'POST');
		$title = $this->request->get_string('value', 'POST');
		$data  = array(
			'tag' => $title,
		);
		$this->model->updateTags($data, $id);
		$result = array(
			'status'  => true,
			'message' => lang('success'),
		);
		echo json_encode($result);
		$_DATA['content_module'] = '';
	}

	public function ajaxChangeMeta() {
		$id         = $this->request->get_int('pk', 'POST');
		$meta_title = $this->request->get_string('value', 'POST');
		$data       = array(
			'meta_title' => $meta_title,
		);
		$this->model->updateTags($data, $id);
		$result = array(
			'status'  => true,
			'message' => lang('success'),
		);
		echo json_encode($result);
		$_DATA['content_module'] = '';
	}

	public function ajaxChangeDescription() {
		$id          = $this->request->get_int('pk', 'POST');
		$description = $this->request->get_string('value', 'POST');
		$data        = array(
			'description' => $description,
		);
		$this->model->updateTags($data, $id);
		$result = array(
			'status'  => true,
			'message' => lang('success'),
		);
		echo json_encode($result);
		$_DATA['content_module'] = '';
	}

	public function ajaxDelete() {
		$id = $this->request->get_int('id', 'POST');
		$this->model->deleteTags($id);
		$result = array(
			'status'  => true,
			'message' => lang('success'),
		);
		echo json_encode($result);
		$_DATA['content_module'] = '';
	}

	public function ajaxMultiDelete() {
		$id = $this->request->get_array('id', 'POST');
		foreach ($id as $k => $v) {
			$this->model->deleteTags($v);
		}
		$result = array(
			'status'  => true,
			'message' => lang('success'),
		);
		echo json_encode($result);
		$_DATA['content_module'] = '';
	}

}