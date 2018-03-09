<?php
/**
 * author: Nguyen Xuan Truong
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

class MActivemod {
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
		$this->mAM    = new Model('web_mod', $db_web);

	}
	/**
	 * [getListMod description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-06-12
	 * @return [type]                     [description]
	 */
	public function getListMod() {
		$this->mAM->where('idw', $this->idw);
		return $this->mAM->getOne(null, 'active_mod,customs_mod');

	}
	/**
	 * [updateActiveModules description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-06-12
	 * @param  [type]                     $data [description]
	 * @return [type]                           [description]
	 */
	public function updateActiveModules($data) {

		$this->mAM->where('idw', $this->idw);
		return $this->mAM->update($data);

	}
	/**
	 * [checkExist description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-06-12
	 * @return [type]                     [description]
	 */
	public function checkExist() {
		$this->mAM->where('idw', $this->idw);
		$check = $this->mAM->num_rows();
		if ($check != 0) {
			return true;
		} else {
			return false;
		}
	}
	/**
	 * [addActiveModule description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-06-12
	 */
	public function addActiveModule() {
		$data = array(
			'idw'         => $this->idw,
			'active_mod'  => ',all,',
			'customs_mod' => ',all,',
			'create_time' => time(),
			'uid_create'  => $this->uid,
		);
		return $this->mAM->insert($data);
	}

}