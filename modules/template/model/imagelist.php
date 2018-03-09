<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/imagelist.php 
 * @Author An Nguyen Huu(annh@webbnc.vn)
 * @Createdate 08/21/2014, 14:31 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class ImageList extends GlobalSlide{
	public $idw,$r,$lang,$result_id,$imageObj;
	public function __construct(){
		global $_B;	 
		$this->r = $_B['r'];
		$this->idw = $_B['web']['idw'];
		$this->lang = $_B['cf']['lang'];
		$this->result_id = "";
	}
	public function activeStatusImage(){
		//global $_B;
		$getLangAndID = getLangAndID();
		$this->imageObj = new Model($getLangAndID['lang'].'_slide_image');
		$status = $this->r->get_string('status','POST');
		$id = $this->r->get_int('key','POST');
		$update = array('status'=>$status,'update_time'=>time());
		$this->imageObj->where($getLangAndID['field_id'],$id);
		$this->imageObj->where('idw',$this->idw);		
		$result = $this->imageObj->update($update);
	}
	public function editTitleImage(){
		$id = 	$this->r->get_int('pk','POST');
		$title = strip_tags($this->r->get_string('value','POST'));
		//Cắt bỏ chuỗi -- đằng trước của danh mục.
		$rule="/([^-+\s]).+$/";
		preg_match($rule, $title, $pr_title);			
		$getLangAndID = getLangAndID();
		$this->imageObj = new Model($getLangAndID['lang'].'_slide_image');
		$this->imageObj->where($getLangAndID['field_id'],$id);
		$this->imageObj->where('idw',$this->idw);
		$result = $this->imageObj->update(array('title'=>$pr_title[0],'update_time'=>time()));
		json_encode($result);
		exit();		
	}	
	public function editSortImage(){
		$id = 	$this->r->get_int('pk','POST');
		$sort = $this->r->get_int('value','POST');
		$getLangAndID = getLangAndID();
		$this->imageObj = new Model($getLangAndID['lang'].'_slide_image');
		$this->imageObj->where($getLangAndID['field_id'],$id);
		$this->imageObj->where('idw',$this->idw);
		$result = $this->imageObj->update(array('sort'=>$sort,'update_time'=>time()));
	}
	public function editSlidePosition(){
		$id = 	$this->r->get_int('pk','POST');
		$position = $this->r->get_int('value','POST');
		$getLangAndID = getLangAndID();
		$this->imageObj = new Model($getLangAndID['lang'].'_slide_image');
		$this->imageObj->where($getLangAndID['field_id'],$id);
		$this->imageObj->where('idw',$this->idw);
		$result = $this->imageObj->update(array('position'=>$position,'update_time'=>time()));
	}
	public function deleteMultiID(){
		$ids = $this->r->get_array('name_id','POST');
		foreach($ids as $k=>$v){
			$this->deleteImage($v);
		}
		$r['status'] = true;
		return $r;
	}
	public function deleteImage($id=null){
		$multi = false;
		if (!isset($id)) {
			$id = 	$this->r->get_int('key','POST');
			$multi = true;
		}
		$this->result_id .=$id.",";
		$getLangAndID = getLangAndID();
		$this->imageObj = new Model($getLangAndID['lang'].'_slide_image');
		$this->imageObj->where($getLangAndID['field_id'],$id);
		$this->imageObj->where('idw',$this->idw);
		$this->imageObj->delete();		
	}
	public function saveImgFast(){
		$id = $this->r->get_int('id_img','POST');
		$str = 'img_slide_'.$id;
		if (($_FILES[$str]["type"] == "image/gif") || ($_FILES[$str]["type"] == "image/jpeg") || ($_FILES[$str]["type"] == "image/jpg") || ($_FILES[$str]["type"] == "image/png")) {
			include(DIR_HELPER_UPLOAD);
		  	$options = array('max_size' => 1600);
			$upload = new BncUpload($options);
			$up_img = $upload->upload($this->idw,'slide',$str);
			if (!empty($up_img)){
				$getLangAndID = getLangAndID();
				$this->imageObj = new Model($getLangAndID['lang']."_slide_image");
				$this->imageObj->where($getLangAndID['field_id'],$id);
				$this->imageObj->where('idw',$this->idw);
				$result = $this->imageObj->update(array('src_link'=>$up_img));
				if ($result) {
					$data['status'] = true;
				}else{
					$data['status'] = false;
				}
				return $data;
			}
		}else{
			return false;
		}
	}
}