<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/category.php 
 * @Author Mạnh Hùng (hungdct1083@gmail.com)
 * @Createdate 08/17/2014, 10:14 AM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class Category extends GlobalVideo{
	public $idw,$catVideoObj,$catVideoObjvi,$r,$lang;
	private $uid;
	public function __construct(){
			global $_B;	 
			$this->r = $_B['r'];
			$this->idw = $_B['web']['idw'];
			$this->lang = $_B['cf']['lang'];
	}
	
	public function addCategoryVideo(){
		global $_B;
			$getLangAndID = getLangAndID();
			$this->catVideoObj = new Model($getLangAndID['lang'].'_category');
			if ($getLangAndID['lang']!='vi'){
				$id_lang = $this->r->get_int('id');
			}
			$parent_id = $this->r->get_int('cat_id','POST');
			$title=$this->r->get_string('title','POST');
			$title =preg_replace('/\s\s+/', ' ', trim($title));
			if ($title != '') {
				//START UPLOAD
				include(DIR_HELPER_UPLOAD);
			  	$options = array('max_size' => 1600);
				$upload = new BncUpload($options);
				$name_img = $upload->upload($this->idw,'video','img_cat');
				$name_icon = $upload->upload($this->idw,'video','icon_cat');
				$name_bg = $upload->upload($this->idw,'video','bg_cat');
				//END UPLOAD
				$data = array(
					'idw'				=>$this->idw,
					'img'				=>$name_img,
					'icon'				=>$name_icon,
					'bg'				=>$name_bg,
					'title'				=>$title,
					'alias'             =>$this->r->get_string('alias','POST'),
					'description'		=>$this->r->get_string('description','POST'),
					'parent_id'			=>$parent_id,
					'meta_title'		=>$this->r->get_string('meta_title','POST'),
					'meta_keyword'		=>$this->r->get_string('meta_keyword','POST'),
					'meta_description'	=>$this->r->get_string('meta_description','POST'),
					'create_uid'		=>$_B['uid'],
					'create_time'		=>time(),
					'id_lang'			=>(int) $id_lang,
					'sort'				=>(int) $this->r->get_string('sort','POST'),
					'number_home'		=>(int) $this->r->get_string('number_home','POST'),
					'status'			=>$this->r->get_int('status','POST'),
					'status_home'		=>$this->r->get_int('status_home','POST'),
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
				'alias'             =>$str_alias,
				'alias'             =>$this->r->get_string('alias','POST'),
				'description'		=>$this->r->get_string('description','POST'),
				'parent_id'			=>$parent_id,
				'meta_title'		=>$this->r->get_string('meta_title','POST'),
				'meta_keyword'		=>$this->r->get_string('meta_keyword','POST'),
				'meta_description'	=>$this->r->get_string('meta_description','POST'),
				'update_uid'		=>$_B['uid'],
				'update_time'		=>time(),
				'id_lang'			=>(int) $id_lang,
				'sort'				=>(int) $this->r->get_string('sort','POST'),
				'number_home'		=>(int) $this->r->get_string('number_home','POST'),
				'status'			=>$this->r->get_int('status','POST'),
				'status_home'		=>$this->r->get_int('status_home','POST'),
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
				$this->catVideoObj->where($getLangAndID['field_id'],$id);
				$this->catVideoObj->where('idw',$this->idw);
				$result = $this->catVideoObj->update($data);
				if ($getLangAndID['lang']=='vi') {
					//Update lại parent_id nếu sửa bản ghi tiếng việt
					$data = array(
						'parent_id'=>$parent_id
					);
				//	$this->CategoryVideoID($data,$id,'update');

				}else{
					//Kiểm tra xem bản ghi đã tồn tại bên ngôn ngữ này chưa. 
					//True : update
					//false: insert
					$checkExist = $this->checkExist($id,$getLangAndID['lang'],'category');
					if ($checkExist==false) {
						$result = $this->catVideoObj->insert($data);
					}
				}
			}else{
				$result = $this->catVideoObj->insert($data);
			}
			
		
			if($id)
				{
					$return['last_id'] = $this->r->get_int('id');
				}else
				{
					$return['last_id'] = $result;
				}
				
			
			if ($result) {
				$return['status'] = true;
			}else{
				$return['status'] = false;
				$return['error'] = $this->catVideoObj->getLastError();
			}
			return $return;
	}



	//get Category video
	public function getCategoryByID($id){
		global $_B;
			$getLangAndID = getLangAndID();
			$this->catVideoObj = new Model($getLangAndID['lang'].'_category');
			//Xử lý nếu danh mục cha chưa có tiếng anh.
			$parent_id = $this->getParentID();
			if ($parent_id!=0 && $getLangAndID['lang']!='vi') {
				$this->catVideoObj->where('id_lang',$parent_id);
				$this->catVideoObj->where('idw',$this->idw);
				$checkExist = $this->catVideoObj->num_rows();
				if ($checkExist==0) {
					return 'notTranslate';
				}
			}
			
			$select = array('id,id_lang,title,description,parent_id,meta_title,meta_keyword,meta_description,sort,img,icon,bg,status,status_home,number_home,alias');
			$this->catVideoObj->where($getLangAndID['field_id'],$id);
			$this->catVideoObj->where('idw',$this->idw);
			$result = $this->catVideoObj->getOne(null,$select);
			
			if ($result) {
				return $result;
			}
	}
	
	protected function getParentID(){
			$id = $this->r->get_int('id');

			$this->catVideoObjvi = new Model('vi_category');
			$select = array('parent_id');
			$this->catVideoObjvi->where('id',$id);
			$this->catVideoObjvi->where('idw',$this->idw);
			$result = $this->catVideoObjvi->getOne(null,$select);
			if ($result) {
				return $result['parent_id'];
			}
	}
	
}