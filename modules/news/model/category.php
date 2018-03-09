<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/category.php 
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/17/2014, 10:14 AM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class Category extends GlobalNews{
	public $idw,$catNewObj,$catNewObjvi,$r,$lang;
	private $uid;
	public function __construct(){
		global $_B;	 
		$this->r = $_B['r'];
		$this->idw = $_B['web']['idw'];
		$this->lang = $_B['cf']['lang'];
	}
	
	public function addCategoryNews(){
		global $_B;
		$getLangAndID = getLangAndID();
		$this->catNewObj = new Model($getLangAndID['lang'].'_category');

		if($this->r->get_string('is_home','POST')=='on') {
			$is_home = 1;
		}else{
			$is_home = 0;
		}
		
		if ($getLangAndID['lang']!='vi'){
			$id_lang = $this->r->get_int('id');
			$parent_id = $this->getParentID();
		}else{
			$parent_id = $this->r->get_int('cat_id','POST');
		}
		$str = strip_tags($this->r->get_string('title','POST'));
		$title = trim($str);
		if ($title != '') {
			//START UPLOAD
			include(DIR_HELPER_UPLOAD);
		  	$options = array('max_size' => 1600);
			$upload = new BncUpload($options);
			$name_img = $upload->upload($this->idw,'news','img_cat');
			$name_icon = $upload->upload($this->idw,'news','icon_cat');
			$name_bg = $upload->upload($this->idw,'news','bg_cat');
			//END UPLOAD
			$data = array(
				'idw'				=>$this->idw,
				'img'				=>$name_img,
				'icon'				=>$name_icon,
				'bg'				=>$name_bg,
				'title'				=>$title,
				'alias'             =>fixTitle($this->r->get_string('alias','POST')),			
				'description'		=>$this->r->get_string('description','POST'),
				'parent_id'			=>$parent_id,
				'meta_title'		=>$this->r->get_string('meta_title','POST'),
				'meta_keyword'		=>$this->r->get_string('meta_keyword','POST'),
				'meta_description'	=>$this->r->get_string('meta_description','POST'),
				'status'			=>$this->r->get_string('status','POST'),
				'create_uid'		=>$_B['uid'],
				'sort'				=>$this->r->get_int('sort','POST'),
				'number_home'		=>$this->r->get_int('number_home','POST'),
				'create_time'		=>time(),
				'id_lang'			=>$id_lang,
				'is_home'			=>$is_home,
			);
		}else{
			return false;
		}
		if (isset($_POST['img_cat'])&&$_POST['img_cat']=="1") {
			unset($data['img']);
		}
		if (isset($_POST['icon_cat'])&&$_POST['icon_cat']=="1") {
			unset($data['icon']);
		}
		if (isset($_POST['bg_cat'])&&$_POST['bg_cat']=="1") {
			unset($data['bg']);
		}
		//Kiểm tra xem nếu tồn tại id thì update, nếu không thì insert
		$id = $this->r->get_int('id');

		if (!empty($id)) {
			if($this->r->get_string('is_save','POST')=='on') {
				$str_alias = $this->r->get_string('alias','POST');
			}else{
				$str_alias = $this->r->get_string('title_alias','POST');
			}
			$data = array(
			'idw'				=>$this->idw,
			'img'				=>$name_img,
			'icon'				=>$name_icon,
			'bg'				=>$name_bg,
			'title'				=>$title,
			'alias'             =>fixTitle($str_alias),
			'description'		=>$this->r->get_string('description','POST'),
			'parent_id'			=>$parent_id,
			'meta_title'		=>$this->r->get_string('meta_title','POST'),
			'meta_keyword'		=>$this->r->get_string('meta_keyword','POST'),
			'meta_description'	=>$this->r->get_string('meta_description','POST'),
			'status'			=>$this->r->get_string('status','POST'),
			'update_uid'		=>$_B['uid'],
			'sort'				=>$this->r->get_int('sort','POST'),
			'number_home'		=>$this->r->get_int('number_home','POST'),
			'create_time'		=>time(),
			'id_lang'			=>$id_lang,
			'is_home'			=>$is_home,
		);
		if (isset($_POST['img_cat'])&&$_POST['img_cat']=="1") {
			unset($data['img']);
		}
		if (isset($_POST['icon_cat'])&&$_POST['icon_cat']=="1") {
			unset($data['icon']);
		}
		if (isset($_POST['bg_cat'])&&$_POST['bg_cat']=="1") {
			unset($data['bg']);
		}
			$this->catNewObj->where($getLangAndID['field_id'],$id);
			$this->catNewObj->where('idw',$this->idw);
			$result = $this->catNewObj->update($data);
			if ($getLangAndID['lang']=='vi') {
				//Update lại parent_id nếu sửa bản ghi tiếng việt
				$data = array(
					'parent_id'=>$parent_id
				);
				//function fixParentCat($data,$id,$action)
				//@param1 : mảng truyền vào xử lý
				//@param2: id
				//@param3: action truyền vào để xử lý theo yêu cầu. VD: delete,update
				$this->fixParentCat($data,$id,'update');
			}else{
				//Kiểm tra xem bản ghi đã tồn tại bên ngôn ngữ này chưa. 
				//True : update
				//false: insert
				$checkExist = $this->checkExist($id,$getLangAndID['lang']);
				if ($checkExist==true) {
					$this->catNewObj->where($getLangAndID['field_id'],$id);
					$this->catNewObj->where('idw',$this->idw);
					$result = $this->catNewObj->update($data);
				}else{
					$result = $this->catNewObj->insert($data);
				}
			}
		}else{
			$result = $this->catNewObj->insert($data);
		}
		
		if ($getLangAndID['lang']!='vi'){
			$return['last_id'] = $this->r->get_int('id');
		}else{
			$return['last_id'] = $this->catNewObj->getLastId();
		}
		
		if ($result) {
			$return['status'] = true;
		}else{
			$return['status'] = false;
			$return['error'] = $this->catNewObj->getLastError();
		}
		return $return;
	}

	//get Category News
	public function getCategoryByID($id){
		global $_B;
		$getLangAndID = getLangAndID();
		$this->catNewObj = new Model($getLangAndID['lang'].'_category');
		//Xử lý nếu danh mục cha chưa có tiếng anh.
		$parent_id = $this->getParentID();
		if ($parent_id!=0 && $getLangAndID['lang']!='vi') {
			$this->catNewObj->where('id_lang',$parent_id);
			$this->catNewObj->where('idw',$this->idw);
			$checkExist = $this->catNewObj->num_rows();
			if ($checkExist==0) {
				return 'notTranslate';
			}
		}			
		$select = array('id,id_lang,title,description,parent_id,meta_title,meta_keyword,meta_description,sort,img,icon,bg,is_home,status,number_home,alias');
		$this->catNewObj->where($getLangAndID['field_id'],$id);
		$this->catNewObj->where('idw',$this->idw);
		$result = $this->catNewObj->getOne(null,$select);			
		if ($result) {
			return $result;
		}
	}
	protected function getParentID(){
		$id = $this->r->get_int('id');
		$this->catNewObjvi = new Model('vi_category');
		$select = array('parent_id');
		$this->catNewObjvi->where('id',$id);
		$this->catNewObjvi->where('idw',$this->idw);
		$result = $this->catNewObjvi->getOne(null,$select);
		if ($result) {
			return $result['parent_id'];
		}
	}
}