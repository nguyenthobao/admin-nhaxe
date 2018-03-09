<?php

if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class MenuAbove {
	public $idw,$r,$menuabove;
	private $uid;
	public function __construct(){
			global $_B;	 
			$this->r   = $_B['r'];
			$this->idw = $_B['web']['idw'];
			$this->uid = $_B['uid'];
	}
		public function addMenuAbove(){
			$id       = $this->r->get_int('id','GET');
			$lang 	  = $this->r->get_string('lang','GET');
			$menuabove = new Model($lang.'_menuabove');
			//START UPLOAD
			include(DIR_HELPER_UPLOAD);
		  	$options = array('max_size' => 1600);
			$upload = new BncUpload($options);
			$up_img = $upload->upload($this->idw,'menu','img');

			if (!empty($up_img)) {
		 	$name_img = $_B['upload_path'].$up_img;
			}else{
			$name_img = null;
			}

			$up_img = $upload->upload($this->idw,'menu','icon');

			if (!empty($up_img)) {
		 	$name_icon = $_B['upload_path'].$up_img;
			}else{
			$name_icon = null;
			}

			$up_img = $upload->upload($this->idw,'menu','bg');

			if (!empty($up_img)) {
		 	$name_bg = $_B['upload_path'].$up_img;
			}else{
			$name_bg = null;
			}
			//END UPLOAD
		
			$data     = array(
				'idw'				=>$this->idw,
				'img'				=>$name_img,
				'icon'				=>$name_icon,
				'bg'				=>$name_bg,
				'namemenu'			=>$this->r->get_string('namemenu','POST'),
				'linkto'			=>$this->r->get_string('linkto','POST'),
				'linktoct'			=>$this->r->get_string('linktoct','POST'),
				'parent_id'         =>$this->r->get_int('parent_id','POST'),
				'nofollow'          =>$this->r->get_string('nofollow','POST'),
				'sort'				=>$this->r->get_int('sort','POST'),
				'status'            =>$this->r->get_string('status','POST'), 
			);
		 	$menuabove     -> where('idw',$this->idw);
		 	if($menuabove  -> num_rows() > 0 ){
		 		$menuabove ->where('id',$id);
		 		$menuabove -> where('idw',$this->idw);
				$result = $menuabove->update($data);
		 	}
		 	else{
		 		$result = $menuabove->insert($data);
		 	}
			if ($result) {
				$return['status'] = true;
			}else{
				$return['status'] = false;
			}
			return $return;
	}
	public function getMenuAbove(){
		global $_B;
		$id = $this->r->get_int('id','GET');
		$lang=$this->r->get_string('lang','GET');
		$menuabove = new Model($lang.'_menuabove');
		$menuabove->where('id',$id);
		$menuabove->where('idw',$this->idw);
		$select = '*';
		$data   = $menuabove->getOne(null,null,$select);
		return $data;
	}	
	
}
	
	
