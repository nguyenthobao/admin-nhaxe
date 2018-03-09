<?php
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
/**
 *
 */
class Seo {

	public $seoObj, $r;
	public function __construct() {
		global $_B;
		$this->r    = $_B['r'];
		$this->idw  = $_B['web']['idw'];
		$this->uid  = $_B['uid'];
		$this->lang = $this->r->get_string('lang', 'GET');
	}
	//Truong nguyen
	public function getGA() {
		global $_B;
		$Obj = new Model($this->lang . '_seo');
		$Obj->where('idw', $this->idw);
		$data = $Obj->getOne(null, 'ga');
		return $data;
	}
	public function addGA() {
		global $_B;
		$ga = $_POST['analytics'];
		if ($this->checkGa() == false) {
			$Obj  = new Model($this->lang . '_seo');
			$data = array(
				'ga'  => $ga,
				'idw' => $this->idw,
			);
			$result = $Obj->insert($data);
		} else {
			$Obj = new Model($this->lang . '_seo');
			$Obj->where('idw', $this->idw);
			$data = array(
				'ga' => $ga,
			);
			$result = $Obj->update($data);
		}

		return $result;
	}

	public function checkGa() {
		global $_B;
		$Obj = new Model($this->lang . '_seo');
		$Obj->where('idw', $this->idw);
		$data = $Obj->num_rows();
		if ($data != 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getRobots() {
		global $_B;
		$seoObj = new Model('vi_seo');
		$seoObj->where('idw', $this->idw);
		$data = $seoObj->getOne();
		return $data;
	}

	public function addRobots() {
		$seoObj = new Model('vi_seo');
		$data   = array(
			'idw'    => $this->idw,
			'robots' => $this->r->get_string('robots', 'POST'),
		);

		$seoObj->where('idw', $this->idw);
		if ($seoObj->num_rows() > 0) {
			$seoObj->where('idw', $this->idw);
			$result = $seoObj->update($data);
		} else {
			$result = $seoObj->insert($data);
		}
		if ($result) {
			$return['status'] = true;
		} else {
			$return['status'] = false;
		}
		return $return;
	}

	public function deleteGoogle() {
		$id_google = "";
		$name      = "";
		$seoObj    = new Model('vi_seo');
		$data      = array(
			'id_google' => $id_google,
			'name'      => $name,
		);
		$seoObj->where('idw', $this->idw);
		$result = $seoObj->update($data);
		if ($result) {
			$return['status'] = true;
		} else {
			$return['status'] = false;
		}
		return $return;
	}

	public function addGoogle() {
		$seoObj = new Model('vi_seo');
		$data   = array(
			'idw'       => $this->idw,
			'id_google' => $this->r->get_string('id_google', 'POST'),
			'name'      => $this->r->get_string('name', 'POST'),
		);

		$seoObj->where('idw', $this->idw);
		if ($seoObj->num_rows() > 0) {
			$seoObj->where('idw', $this->idw);
			$result = $seoObj->update($data);
		} else {
			$result = $seoObj->insert($data);
		}
		if ($result) {
			$return['status'] = true;
		} else {
			$return['status'] = false;
		}
		return $return;
	}

	public function activeDomain($id = null) {
		$value  = $this->r->get_string('value', 'POST');
		$seoObj = new Model('vi_seo');
		$data   = array(
			'domain' => $value,
		);
		$seoObj->where('idw', $this->idw);
		$result = $seoObj->update($data);
		if ($result) {
			$return['status'] = true;
		} else {
			$return['status'] = false;
		}
		return $return;
	}
	public function enableSeoUrl() {
		$value = $this->r->get_int('value', 'POST');
		$db_cf = db_connect();
		$cf    = new Model('web_cf_admin', $db_cf);
		//Kiem tra ton tai chua
		if ($this->checkExist() == true) {
			$cf->where('idw', $this->idw);
			$cf->where('`key`', 'seo_url');
			$data   = array('value_int' => $value);
			$result = $cf->update($data);
		} else {
			$result = $cf->insert(array('idw' => $this->idw, 'key' => 'seo_url', 'value_int' => $value));
		}

		return $this->idw;
	}

	public function wwwDomain() {
		$type = $this->r->get_int('rad_choose', 'POST');
		if ($type == 1) {
			$www = 0;
		} else {
			$www = 1;
		}
		$db_cf = db_connect();
		$cf    = new Model('web_cf_admin', $db_cf);
		if ($this->checkExistwww() == true) {
			$cf->where('idw', $this->idw);
			$cf->where('`key`', 'www');
			$data = array(
				'value_int' => $www,
			);
			$result = $cf->update($data);
		} else {
			$data = array(
				'idw'       => $this->idw,
				'key'       => 'www',
				'value_int' => $www,
			);
			$result = $cf->insert($data);
		}
		$kq = array(
			'status'  => true,
			'message' => 'Cài đặt thành công',
		);
		echo json_encode($kq);
		exit();
	}

	public function CustomSeoUrl() {
		$dataDefault = $this->r->get_array('dataDefault', 'POST');
		$dataCustom  = $this->r->get_array('dataCustom', 'POST');
		$db_cf       = db_connect();
		$cf          = new Model('web_cf_admin', $db_cf);
		$data_json   = array();
		foreach ($dataDefault as $k => $v) {
			$data_json[$v] = $dataCustom[$k];
		}
		$data_json = json_encode($data_json);
		if ($this->checkExistSeoMod() == true) {
			$cf->where('idw', $this->idw);
			$cf->where('`key`', 'seo_url_mod');
			$data = array(
				'value_string' => $data_json,
			);
			$result = $cf->update($data);
		} else {
			$data = array(
				'idw'          => $this->idw,
				'key'          => 'seo_url_mod',
				'value_string' => $data_json,
			);
			$result = $cf->insert($data);
		}
		$kq = array(
			'status' => true,
		);
		echo json_encode($kq);
		exit();
	}

	public function getTypeDomain() {

		$db_cf = db_connect();
		$cf    = new Model('web_cf_admin', $db_cf);
		if ($this->checkExist() == true) {
			$cf->where('idw', $this->idw);
			$cf->where('`key`', 'www');
			$data   = $cf->getOne(null, 'value_int');
			$result = array(
				'type_value' => $data['value_int'],
			);

		} else {
			$result = array(
				'type_value' => '',
			);
		}
		echo json_encode($result);
		exit();
	}

	public function getCustom() {

		$db_cf = db_connect();
		$cf    = new Model('web_cf_admin', $db_cf);
		if ($this->checkExist() == true) {
			$cf->where('idw', $this->idw);
			$cf->where('`key`', 'seo_url_mod');
			$data = $cf->getOne(null, 'value_string');

			$result = json_encode(json_decode($data['value_string'], true));
		} else {
			$result = json_encode(array());
		}
		echo $result;
		exit();
	}

	//Check Exist
	private function checkExist() {
		$db_cf = db_connect();
		$cf    = new Model('web_cf_admin', $db_cf);
		$cf->where('idw', $this->idw);
		$cf->where('`key`', 'seo_url');

		$result = $cf->num_rows();
		if ($result != 0) {
			return true;
		} else {
			return false;
		}
	}

	//Check Exist
	private function checkExistSeoMod() {
		$db_cf = db_connect();
		$cf    = new Model('web_cf_admin', $db_cf);
		$cf->where('idw', $this->idw);
		$cf->where('`key`', 'seo_url_mod');

		$result = $cf->num_rows();
		if ($result != 0) {
			return true;
		} else {
			return false;
		}
	}

	//Check Exist
	private function checkExistwww() {
		$db_cf = db_connect();
		$cf    = new Model('web_cf_admin', $db_cf);
		$cf->where('idw', $this->idw);
		$cf->where('`key`', 'www');
		$result = $cf->num_rows();
		if ($result != 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getConfigSeoUrl() {
		global $_B;

		$db_cf = db_connect();
		$cf    = new Model('web_cf_admin', $db_cf);
		$cf->where('idw', $_B['web']['idw']);
		$cf->where('`key`', 'seo_url');
		$result = $cf->getOne();

		return $result;
	}
}
