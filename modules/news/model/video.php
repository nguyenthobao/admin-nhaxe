<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/video.php 
 * @Author Hùng 
 * @Createdate 08/15/2014, 16:38 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class Video extends GlobalVideo{
	public $idw,$videoObj,$catVideoObjvi,$r,$lang;
	private $uid;
	public function __construct(){
			global $_B;	 
			$this->r = $_B['r'];
			$this->idw = $_B['web']['idw'];
			$this->lang = $_B['cf']['lang'];
	}
	public function addvideo(){
		
		$getLangAndID = $this->getLangAndID();
		$this->videoObj = new Model($getLangAndID['lang'].'_video');
		/*---START UPLOAD---
		include(DIR_HELPER_UPLOAD);
	 	$options = array('max_size' => 1600);
		$upload = new BncUpload($options);
		$name_img = $_B['upload_path'].$upload->upload($this->idw,'video','file'); 
		---END UPLOAD---*/

		$name_img = null; 
		if ($getLangAndID['lang']!='vi'){
				$id_lang = $this->r->get_int('id');
				$parent_id = $this->getParentIDVD();
			}else{
				$parent_id = $this->r->get_int('cat_id','POST');
			}

		$data = array(
			'idw'			=>$this->idw,
			'img'			=>$name_img,
			'title'		=>$this->r->get_string('title','POST'),
			'short'		=>$this->r->get_string('short','POST'),
			'link_video'		=>$this->r->get_string('link_video','POST'),
			'status'	=>$this->r->get_int('status','POST'),
			'meta_title'		=>$this->r->get_string('meta_title','POST'),
			'meta_keyword'	=>$this->r->get_string('meta_keyword','POST'),
			'meta_description'	=>$this->r->get_string('meta_description','POST'),
			'create_uid'		=>$_B['uid'],
			'create_time'		=>time(),
			'id_lang'				=>$id_lang,
			'sort'				=>$this->r->get_string('sort','POST'),
			'parent_id'			=>$parent_id,
			);
		

			$id = $this->r->get_int('id');
			if (!empty($id)) {
				$this->videoObj->where($getLangAndID['field_id'],$id);
				$this->videoObj->where('idw',$this->idw);
				$result = $this->videoObj->update($data);
				if ($getLangAndID['lang']=='vi') {
					//Update lại parent_id nếu sửa bản ghi tiếng việt
					$data = array(
						'parent_id'=>$parent_id
					);
					$this->fixParentCat($data,$parent_id,$id);
				}else{
					//Kiểm tra xem bản ghi đã tồn tại bên ngôn ngữ này chưa. 
					//True : update
					//false: insert
					$checkExist = $this->checkExist($id,$getLangAndID['lang']);
					if ($checkExist==true) {
						$result = $this->videoObj->update($data);		
					}else{
						$result = $this->videoObj->insert($data);
					}
				}
			}else{
				echo "11111";
				$result = $this->videoObj->insert($data);
			}
			
			if ($getLangAndID['lang']!='vi'){
				$return['last_id'] = $this->r->get_int('id');
			}else{
				$return['last_id'] = $this->videoObj->getLastId();
			}

			if ($result) {
				$return['status'] = true;
			}else{
				$return['status'] = false;
				$return['error'] = $this->videoObj->getLastError();
			}
			return $return;
	}
	//get video
	public function getVideoByID($id){
			global $_B;
			$getLangAndID = $this->getLangAndID();
			$this->videoObj = new Model($getLangAndID['lang'].'_video');
			$select = array('id,id_lang,title,img,link_video,short,status,parent_id,meta_title,meta_keyword,meta_description,sort');
			$this->videoObj->where($getLangAndID['field_id'],$id);
			$this->videoObj->where('idw',$this->idw);
			$result = $this->videoObj->getOne(null,$select);
			
			if ($result) {
				return $result;
			}
			

	}
	protected function getParentIDVD(){
			$id = $this->r->get_int('id');

			$this->catVideoObjvi = new Model('vi_category');
			$select = array('parent_id');
			
			$this->catVideoObjvi->where('idw',$this->idw);
			$result = $this->catVideoObjvi->getOne(null,$select);
			if ($result) {
				return $result['parent_id'];
			}
	}
}