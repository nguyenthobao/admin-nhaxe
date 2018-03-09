<?php

if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

class MSettingLang {
	public $idw, $r, $infolist, $web;
	private $uid;
	private $model;
	public function __construct() {
		global $_B;
		$this->r      = $_B['r'];
		$this->domain = $_B['web']['domain'];
		$this->idw    = $_B['web']['idw'];
		$this->uid    = $_B['uid'];
		$db_web       = db_connect('user');
		$this->mWCA   = new Model('web_cf_admin', $db_web);
		$this->mWCFE  = new Model('web_cf_front_end', $db_web);
		$this->mL     = new Model('language', $db_web);

	}

	public function flag($code) {
		$this->mL->where('code', $code);
		return $this->mL->getOne(null, 'image');
	}

	public function langReady() {
		$this->mWCA->where('idw', $this->idw);
		$this->mWCA->where('`key`', 'lang_use');
		$result = $this->mWCA->getOne(null, 'value_string');
		return $result;
	}

	public function langPrimary() {
		$this->mWCFE->where('idw', $this->idw);
		$this->mWCFE->where('`key`', 'lang');
		$result = $this->mWCFE->getOne(null, 'value_string');
		return $result;
	}

	public function langShowHome() {
		$this->mWCFE->where('idw', $this->idw);
		$this->mWCFE->where('`key`', 'lang_use');
		$result = $this->mWCFE->getOne(null, 'value_string');
		return $result;
	}

	public function update($key, $data) {
		$this->mWCFE->where('idw', $this->idw);
		$this->mWCFE->where('`key`', $key);
		return $this->mWCFE->update($data);
	}

}