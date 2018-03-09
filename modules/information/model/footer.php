<?php

if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

class Footer {
	public $idw, $r, $infolist;
	private $uid;
	public function __construct() {
		global $_B;
		$this->r   = $_B['r'];
		$this->idw = $_B['web']['idw'];
		$this->uid = $_B['uid'];
	}

	public function configAdsFooter($status) {
		$db  = db_connect('user');
		$oBj = new Model('web_cf_front_end', $db);
		//Kiem tra xem da ton tai chua
		//$result = $oBj->get();
		if ($this->checkAdsFooter() == false) {
			//Add
			$result = $this->addAdsFooter($status);
		} else {
			$result = $this->updateAdsFooter($status);
		}
		return $result;

	}

	private function checkAdsFooter() {
		$db  = db_connect('user');
		$oBj = new Model('web_cf_front_end', $db);
		$oBj->where('idw', $this->idw);
		$oBj->where('`key`', 'ads_footer');
		$check = $oBj->num_rows();
		//Kiem tra xem da ton tai chua
		if ($check != 0) {
			return true;
		} else {
			return false;
		}
	}

	private function addAdsFooter($status) {
		$db   = db_connect('user');
		$oBj  = new Model('web_cf_front_end', $db);
		$data = array(
			'idw'       => $this->idw,
			'key'       => 'ads_footer',
			'value_int' => $status,
		);
		$add = $oBj->insert($data);
		return $add;
	}

	private function updateAdsFooter($status) {
		$db  = db_connect('user');
		$oBj = new Model('web_cf_front_end', $db);
		$oBj->where('idw', $this->idw);
		$oBj->where('`key`', 'ads_footer');
		$data = array(
			'value_int' => $status,
		);
		$add = $oBj->update($data);
		return $add;
	}

	public function AdsFooter() {
		$db  = db_connect('user');
		$oBj = new Model('web_cf_front_end', $db);
		if ($this->checkAdsFooter() == false) {
			$this->configAdsFooter(1);
			$result = 1;
		} else {
			//Get du lieu
			$oBj->where('idw', $this->idw);
			$oBj->where('`key`', 'ads_footer');
			$data   = $oBj->getOne();
			$result = $data['value_int'];
		}

		return $result;
	}

	public function addFooter() {
		$lang     = $this->r->get_string('lang', 'GET');
		$infolist = new Model($lang . '_footer');
		$footer=$this->r->get_string('footer', 'POST');
		$data = array(
			'footer'      => htmlspecialchars_decode(html_entity_decode($footer)),
			'create_time' => time(),
			'idw'         => $this->idw,
		);
		$infolist->where('idw', $this->idw);
		if ($infolist->num_rows() > 0) {
			$infolist->where('idw', $this->idw);
			$result = $infolist->update($data);
		} else {
			$result = $infolist->insert($data);
		}
		if ($result) {
			$return['status'] = true;
		} else {
			$return['status'] = false;
		}
		return $return;
	}

	public function getContactInfo() {
		global $_B;
		$lang     = $this->r->get_string('lang', 'GET');
		$infolist = new Model($lang . '_footer');
		$infolist->where('idw', $this->idw);
		$select = '*';
		$data   = $infolist->getOne(null, null, $select);
		return $data;
	}
}