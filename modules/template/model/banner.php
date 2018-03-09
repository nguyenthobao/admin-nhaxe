<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/banner.php 
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/17/2014, 10:14 AM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
class Banner extends GlobalBanner{
	public $idw,$r,$lang,$bannerObj;
	private $uid;
	public function __construct(){
		global $_B;	 
		$this->r = $_B['r'];
		$this->idw = $_B['web']['idw'];
		$this->lang = $_B['cf']['lang'];
	}
	/**
	 * add config of module banner
	 */
	public function addBanner(){
		global $_B;
		$getLangAndID = getLangAndID();
		$this->bannerObj = new Model($getLangAndID['lang'].'_banner');
		
		
		$id_lang = null;
		if ($getLangAndID['lang']!='vi'){
			$id_lang = $this->r->get_int('id');
		}
		
		$data = array(
			'idw'				=>$this->idw,
			'id_lang'			=>$id_lang,
			'title'				=>$this->r->get_string('title','POST'),
			'description'		=>$this->r->get_string('description','POST'),
			'position'			=>$this->r->get_string('position','POST'),
			'create_uid'		=>$_B['uid'],
			'sort'				=>$this->r->get_string('sort','POST'),
			'create_time'		=>time(),
			'meta_title'		=>$this->r->get_string('meta_title','POST'),
			'meta_keywords'		=>$this->r->get_string('meta_keywords','POST'),
			'meta_description'	=>$this->r->get_string('meta_description','POST'),
			'status'			=>$this->r->get_int('status','POST'),
		);
		
		//Kiểm tra xem nếu tồn tại id thì update, nếu không thì insert
		$id = $this->r->get_int('id','GET');

		if (!empty($id)) {
			$data = array(
				'idw'				=>$this->idw,
				'id_lang'			=>$id_lang,
				'title'				=>$this->r->get_string('title','POST'),
				'description'		=>$this->r->get_string('description','POST'),
				'position'			=>$this->r->get_string('position','POST'),
				'update_uid'		=>$_B['uid'],
				'sort'				=>$this->r->get_string('sort','POST'),
				'create_time'		=>time(),
				'meta_title'		=>$this->r->get_string('meta_title','POST'),
				'meta_keywords'		=>$this->r->get_string('meta_keywords','POST'),
				'meta_description'	=>$this->r->get_string('meta_description','POST'),
				'status'			=>$this->r->get_int('status','POST'),
			);
			$this->bannerObj->where($getLangAndID['field_id'],$id);
			$this->bannerObj->where('idw',$this->idw);
			$result = $this->bannerObj->update($data);

			if ($getLangAndID['lang']=='vi') {
				//Update lại parent_id nếu sửa bản ghi tiếng việt
				$data = array(
					'id_lang'=>$id
				);
				//function fixParentCat($data,$id,$action)
				//@param1 : mảng truyền vào xử lý
				//@param2: id
				//@param3: action truyền vào để xử lý theo yêu cầu. VD: delete,update
				$this->fixBannerID($data,$id,'update');
			}else{
				//Kiểm tra xem bản ghi đã tồn tại bên ngôn ngữ này chưa. 
				//True : update
				//false: insert
				$checkExistBanner = $this->checkExistBanner($id,$getLangAndID['lang']);
				if ($checkExistBanner==true) {
					$this->bannerObj->where($getLangAndID['field_id'],$id);
					$this->bannerObj->where('idw',$this->idw);
					$result = $this->bannerObj->update($data);		
				}else{
					$result = $this->bannerObj->insert($data);
				}
			}				
		}else{
			$result = $this->bannerObj->insert($data);
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
			$return['error'] = $this->bannerObj->getLastError();
		}
		return $return;
	}
	//get BannerID
	public function getBannerID(){
		$id = $this->r->get_int('id','get');
		$this->bannerObj = new Model('vi_banner');
		//$select = array('id');
		$this->bannerObj->where('id',$id);
		$this->bannerObj->where('idw',$this->idw);
		$result = $this->bannerObj->getOne();
		return $result;
	}	

}