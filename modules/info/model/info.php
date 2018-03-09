<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/info.php 
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/17/2014, 10:14 AM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
class Info extends GlobalInfo{
	public $idw,$r,$lang,$infoObj;
	private $uid;
	public function __construct(){
		global $_B;	 
		$this->r = $_B['r'];
		$this->idw = $_B['web']['idw'];
		$this->lang = $_B['cf']['lang'];
	}
	/**
	 * add config of module info
	 */
	public function addInfo(){
		global $_B;
		$getLangAndID = getLangAndID();
		$this->infoObj = new Model($getLangAndID['lang'].'_info');
		
		
		//POST info hot
		if($this->r->get_string('info_hot','POST')=='on'){
			$is_hot = 1;
		}else{
			$is_hot = 0;
		}
		$id_lang = null;
		if ($getLangAndID['lang']!='vi'){
			$id_lang = $this->r->get_int('id');
		}
		$date_time_up = $this->r->get_string('time_up','POST');
		$date_time=str_replace("/", "-",$date_time_up);
		$time_up= strtotime($date_time);
		if($time_up !=0)
		{
			$status=2;
		}else{
			$status=$this->r->get_int('status','POST');
		}
		$str = strip_tags($this->r->get_string('title','POST'));
		$title = trim($str);

		if ($title != '') {
			//START UPLOAD
			include(DIR_HELPER_UPLOAD);
		  	$options = array('max_size' => 1600);
			$upload = new BncUpload($options);
			$up_img = $upload->upload($this->idw,'info','img_info');
			//END UPLOAD

			$data = array(
				'idw'				=>$this->idw,
				'id_lang'			=>$id_lang,				
				'img'				=>$up_img,
				'title'				=>$title,
				'alias'             =>fixTitle($this->r->get_string('alias','POST')),
				'short'				=>$this->r->get_string('description','POST'),
				'details'			=>$this->r->get_string('content','POST'),
				'create_uid'		=>$_B['uid'],
				'sort'				=>$this->r->get_int('sort','POST'),
				'create_time'		=>time(),
				'meta_title'		=>$this->r->get_string('meta_title','POST'),
				'tags'				=>$this->r->get_string('tags','POST'),
				'meta_keyword'		=>$this->r->get_string('meta_keyword','POST'),
				'meta_description'	=>$this->r->get_string('meta_description','POST'),
				'is_hot'			=>$is_hot,
				'status'			=>$status,
				'time_up'			=>$time_up,
			);
		}else{
			return false;
		}
		if (isset($_POST['img_info'])&&$_POST['img_info']=="1") {
			unset($data['img']);
		}		
		//Kiểm tra xem nếu tồn tại id thì update, nếu không thì insert
		$id = $this->r->get_int('id','GET');

		if (!empty($id)) {
			if($this->r->get_string('is_save','POST')=='on') {
				$str_alias = $this->r->get_string('alias','POST');
			}else{
				$str_alias = $this->r->get_string('title_alias','POST');
			}
			$data = array(
				'idw'				=>$this->idw,
				'id_lang'			=>$id_lang,				
				'img'				=>$up_img,
				'title'				=>$title,
				'alias'             =>fixTitle($str_alias),
				'short'				=>$this->r->get_string('description','POST'),
				'details'			=>$this->r->get_string('content','POST'),
				'update_uid'		=>$_B['uid'],
				'sort'				=>$this->r->get_int('sort','POST'),
				'update_time'		=>time(),
				'meta_title'		=>$this->r->get_string('meta_title','POST'),
				'tags'				=>$this->r->get_string('tags','POST'),
				'meta_keyword'		=>$this->r->get_string('meta_keyword','POST'),
				'meta_description'	=>$this->r->get_string('meta_description','POST'),
				'is_hot'			=>$is_hot,
				'status'			=>$status,
				'time_up'			=>$time_up,
			);

			if (isset($_POST['img_info'])&&$_POST['img_info']=="1") {
				unset($data['img']);
			}
			$this->infoObj->where($getLangAndID['field_id'],$id);
			$this->infoObj->where('idw',$this->idw);
			$result = $this->infoObj->update($data);

			if ($getLangAndID['lang']=='vi') {
				//Update lại parent_id nếu sửa bản ghi tiếng việt
				$data = array(
					'id_lang'=>$id
				);
				//function fixParentCat($data,$id,$action)
				//@param1 : mảng truyền vào xử lý
				//@param2: id
				//@param3: action truyền vào để xử lý theo yêu cầu. VD: delete,update
				$this->fixInfoID($data,$id,'update');
			}else{
				//Kiểm tra xem bản ghi đã tồn tại bên ngôn ngữ này chưa. 
				//True : update
				//false: insert
				$checkExistInfo = $this->checkExistInfo($id,$getLangAndID['lang']);
				if ($checkExistInfo==true) {
					$this->infoObj->where($getLangAndID['field_id'],$id);
					$this->infoObj->where('idw',$this->idw);
					$result = $this->infoObj->update($data);		
				}else{
					$result = $this->infoObj->insert($data);
				}
			}				
		}else{
			$result = $this->infoObj->insert($data);
		}		
		if (!empty($id)) {
			$return['last_id'] = $id;
		}else{
			$return['last_id'] = $result;
		}			
		if ($result) {
			$return['status'] = true;
		}else{
			$return['status'] = false;
			$return['error'] = $this->infoObj->getLastError();
		}
		return $return;
	}
	//get InfoID
	public function getInfoID(){
		$id = $this->r->get_int('id','get');
		$this->infoObj = new Model('vi_info');
		//$select = array('id');
		$this->infoObj->where('id',$id);
		$this->infoObj->where('idw',$this->idw);
		$result = $this->infoObj->getOne();	
		return $result;
	}	

}