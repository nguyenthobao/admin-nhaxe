<?php

if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
class ModelCloseweb {
	public function __construct() {
		global $_B;
		$this->r      = $_B['r'];
		$this->idw    = $_B['web']['idw'];
		$this->uid    = $_B['uid'];
		$db = db_connect('user');
		$this->mW     = new Model('web',$db);
	}
	public function saveCloseWeb($data){
		$this->mW->where('idw',$this->idw);
		$up = $this->mW->update(array('closeweb'=>json_encode($data['closeweb'])));
		if ($up) {
			return true;
		}
	}
	public function getCloseWeb($data){
		$this->mW->where('idw',$this->idw);
		$get = $this->mW->getOne(null,'closeweb');
		    	
		$get['closeweb'] = json_decode($get['closeweb'],1);
		return $get;
	}

}