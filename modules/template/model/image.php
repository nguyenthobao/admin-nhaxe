<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/image.php 
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/17/2014, 10:14 AM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
class Image extends GlobalSlide{
	public $idw,$r,$lang,$slideObj;
	private $uid;
	public function __construct(){
		global $_B;	 
		$this->r = $_B['r'];
		$this->idw = $_B['web']['idw'];
		$this->lang = $_B['cf']['lang'];
	}
	/**
	 * add config of module slide
	 */
	public function addImage(){
		global $_B;
		$getLangAndID = getLangAndID();
		$this->slideObj = new Model($getLangAndID['lang'].'_slide_image');
		
		//START UPLOAD
		include(DIR_HELPER_UPLOAD);
	  	$options = array('max_size' => 1600);
		$upload = new BncUpload($options);
		$up_img = $upload->upload($this->idw,'slide','img_slide');

		//END UPLOAD
		$str = strip_tags($this->r->get_string('title','POST'));
		$title = trim($str);
		$id_lang = null;
		if ($getLangAndID['lang']!='vi'){
			$id_lang = $this->r->get_int('id');
		}
		
		$data = array(
			'idw'				=>$this->idw,
			'id_lang'			=>$id_lang,
			'src_link'			=>$up_img,
			'title'				=>$title,
			'description'		=>$this->r->get_string('description','POST'),
			'slide_id'			=>$this->r->get_string('slide_id','POST'),
			'create_uid'		=>$_B['uid'],
			'sort'				=>$this->r->get_int('sort','POST'),
			'create_time'		=>time(),
			'status'			=>$this->r->get_int('status','POST'),
			'width'				=>$this->r->get_int('width','POST'),
			'height'			=>$this->r->get_int('height','POST'),
			'link'				=>$this->r->get_string('link','POST'),
		);
		if (isset($_POST['img_slide'])&&$_POST['img_slide']=="1") {
			unset($data['src_link']);
		}
		//Kiểm tra xem nếu tồn tại id thì update, nếu không thì insert
		$id = $this->r->get_int('id','GET');

		if (!empty($id)) {
			$data = array(
				'idw'				=>$this->idw,
				'id_lang'			=>$id_lang,
				'src_link'			=>$up_img,
				'title'				=>$this->r->get_string('title','POST'),
				'description'		=>$this->r->get_string('description','POST'),
				'slide_id'			=>$this->r->get_string('slide_id','POST'),
				'update_uid'		=>$_B['uid'],
				'sort'				=>$this->r->get_int('sort','POST'),
				'create_time'		=>time(),
				'status'			=>$this->r->get_int('status','POST'),
				'width'				=>$this->r->get_int('width','POST'),
				'height'			=>$this->r->get_int('height','POST'),
				'link'				=>$this->r->get_string('link','POST'),
			);
			if (isset($_POST['img_slide'])&&$_POST['img_slide']=="1") {
				unset($data['src_link']);
			}
			$this->slideObj->where($getLangAndID['field_id'],$id);
			$this->slideObj->where('idw',$this->idw);
			$result = $this->slideObj->update($data);

			if ($getLangAndID['lang']=='vi') {
				//Update lại parent_id nếu sửa bản ghi tiếng việt
				$data = array(
					'id_lang'=>$id
				);
				//function fixParentCat($data,$id,$action)
				//@param1 : mảng truyền vào xử lý
				//@param2: id
				//@param3: action truyền vào để xử lý theo yêu cầu. VD: delete,update
				$this->fixImageID($data,$id,'update');
			}else{
				//Kiểm tra xem bản ghi đã tồn tại bên ngôn ngữ này chưa. 
				//True : update
				//false: insert
				$checkExistImage = $this->checkExistImage($id,$getLangAndID['lang']);
				if ($checkExistImage==true) {
					$this->slideObj->where($getLangAndID['field_id'],$id);
					$this->slideObj->where('idw',$this->idw);
					$result = $this->slideObj->update($data);		
				}else{
					$result = $this->slideObj->insert($data);
				}
			}				
		}else{
			$result = $this->slideObj->insert($data);
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
			$return['error'] = $this->slideObj->getLastError();
		}
		return $return;
	}
	//get SlideID
	public function getImageID(){
		$id = $this->r->get_int('id','get');
		$this->slideObj = new Model('vi_slide_image');
		//$select = array('id');
		$this->slideObj->where('id',$id);
		$this->slideObj->where('idw',$this->idw);
		$result = $this->slideObj->getOne();
		return $result;
	}	

}