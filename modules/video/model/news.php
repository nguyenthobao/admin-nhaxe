<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/news.php 
 * @Author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 08/15/2014, 16:38 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class news{
	private $idw,$newObj,$r,$db;
	public function __construct(){
			global $_B;	 
			$this->r = $_B['r'];
			$this->idw = $_B['web']['idw'];
	}
	public function addnew(){
		$lang = $this->r->get_string('lang','POST');
		$lang = (empty($lang))?'vi':$lang;
		$this->newObj = new Model($lang.'_news');
		/*---START UPLOAD---*/
		include(DIR_HELPER_UPLOAD);
	 	$options = array('max_size' => 1600);
		$upload = new BncUpload($options);
		$name_img = $_B['upload_path'].$upload->upload($this->idw,'news','file'); 
		/*---END UPLOAD---*/
		$data = array(
			'idw'			=>$this->idw,
			'img'			=>$name_img,
			'title'		=>$this->r->get_string('new_title','POST'),
			'short'		=>$this->r->get_string('new_des','POST'),
			'status'	=>$this->r->get_int('new_status','POST')
			);
		
		$result = $this->newObj->insert($data);
		if ($result) {
			$return['status'] = false;
		}else{
			$return['status'] = false;
			$return['error'] = $this->newObj->getLastError();
		}
		return $return;
	}
	
}