<?php
/**
 * Code by Nguyen Xuan Truong
 */
class ModelAddLayout {
	function __construct() {
		global $_B, $web;
		$this->idw = $_B['web']['idw'];

	}

	public function get() {

		$db_cf = db_connect();
		$cf    = new Model('web_layouts', $db_cf);
		$cf->where('idw', $this->idw);
		$result = $cf->get();
		return $result;

	}

	public function checkExistRoute($route) {

		$db_cf = db_connect();
		$cf    = new Model('web_layouts', $db_cf);
		$cf->where('idw', $this->idw);
		$cf->where('router', $route);
		$result = $cf->num_rows();
		if ($result != 0) {
			return true;
		} else {
			return false;
		}
	}

	public function addLayout($data) {
		$db_cf  = db_connect();
		$cf     = new Model('web_layouts', $db_cf);
		$insert = $cf->insert($data);
		return $insert;
	}

	public function listLayout() {
		$db_cf = db_connect();
		$cf    = new Model('web_layouts', $db_cf);
		$cf->where('idw', $this->idw);
		$result = $cf->get(null, null, 'id,title,router,layout_name');
		return $result;

	}

	public function change($data, $id) {
		$db_cf = db_connect();
		$cf    = new Model('web_layouts', $db_cf);
		$cf->where('idw', $this->idw);
		$cf->where('id', $id);
		$result = $cf->update($data);
		return $result;
	}

	public function delete($id) {
		$db_cf = db_connect();
		$cf    = new Model('web_layouts', $db_cf);
		$cf->where('idw', $this->idw);
		$cf->where('id', $id);
		$result = $cf->delete();
		return $result;
	}
}