<?php
/**
 * Code By Nguyen Xuan Truong
 *
 */
class ConvertLang {
	function __construct() {
		global $_B;
		$this->temp        = $_B['temp'];
		$this->request     = $_B['r'];
		$this->idw         = $_B['web']['idw'];
		$this->langDefault = $_B['cf']['lang'];

	}

	public function index() {
		$data = $this->getAll();
		foreach ($data as $k => $v) {
			$this->updateLang($v['id'], 'cn_caption', $v['vi_caption']);
			echo $k;
			echo '<br/>';
		}

	}

	private function updateLang($id, $col, $value) {
		$model = new Model('blocks');
		$data  = array(
			$col => $value,
		);
		$model->where('id', $id);
		$result = $model->update($data);
		return $result;

	}

	public function getAll() {

		$model  = new Model('blocks');
		$result = $model->get();
		return $result;

	}

}