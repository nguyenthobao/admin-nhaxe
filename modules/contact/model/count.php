<?php

if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class Count {
	public $idw,$r,$infolist;
	private $uid,$lang;
	public function __construct(){
			global $_B;	 
			$this->r   = $_B['r'];
			$this->idw = $_B['web']['idw'];
			$this->uid = $_B['uid'];
			$this->lang=$this->r->get_string('lang','GET');
			$this->mC=new Model($this->lang.'_contact');

	}
		
	public function totalContact(){
		$this->mC->where('idw',$this->idw);
		
		return $this->mC->num_rows();
	}
	
}
	
	
