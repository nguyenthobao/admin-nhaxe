<?php

if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class MenuBelow {
	public $idw,$r,$menubelow;
	private $uid;
	public function __construct(){
			global $_B;	 
			$this->r   = $_B['r'];
			$this->idw = $_B['web']['idw'];
			$this->uid = $_B['uid'];
	}
		public function addMenuBelow(){
			$id       = $this->r->get_int('id','GET');
			$lang 	  = $this->r->get_string('lang','GET');
			$menubelow = new Model($lang.'_menubelow');
			
			$data     = array(
				'idw'				=>$this->idw,
				'namemenu'			=>$this->r->get_string('namemenu','POST'),
				'linkto'			=>$this->r->get_string('linkto','POST'),
				'linktoct'			=>$this->r->get_string('linktoct','POST'),
				'parent_id'         =>$this->r->get_int('parent_id','POST'),
				'nofollow'          =>$this->r->get_string('nofollow','POST'),
				'sort'				=>$this->r->get_int('sort','POST'),
				'status'            =>$this->r->get_string('status','POST'), 
			);
		 	$menubelow -> where('idw',$this->idw);
		 	if($menubelow  -> num_rows() > 0 ){
		 		$menubelow ->where('id',$id);
		 		$menubelow -> where('idw',$this->idw);
				$result = $menubelow->update($data);
		 	}
		 	else{
		 		$result = $menubelow->insert($data);
		 	}
			if ($result) {
				$return['status'] = true;
			}else{
				$return['status'] = false;
			}
			return $return;
	}	
	public function getMenuBelow(){
		global $_B;
		$id        =$this->r->get_int('id','GET');
		$lang      =$this->r->get_string('lang','GET');
		$menubelow = new Model($lang.'_menubelow');
		$menubelow->where('id',$id);
		$menubelow->where('idw',$this->idw);
		$select = '*';
		$data   = $menubelow->getOne(null,null,$select);
		return $data;
	}
}
	
	
