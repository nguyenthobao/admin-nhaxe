<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/infolist.php 
 * @Author An Nguyen Huu(annh@webbnc.vn)
 * @Createdate 08/21/2014, 14:31 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class InfoList extends GlobalInfo{
	public $idw,$r,$lang,$result_id,$infoObj;
	public function __construct(){
		global $_B;	 
		$this->r = $_B['r'];
		$this->idw = $_B['web']['idw'];
		$this->lang = $_B['cf']['lang'];
		$this->result_id = "";
	}
	public function activeStatusInfo(){
		//global $_B;
		$getLangAndID = getLangAndID();
		$this->infoObj = new Model($getLangAndID['lang'].'_info');
		$status = $this->r->get_string('status','POST');
		$id = $this->r->get_int('key','POST');
		$update = array('status'=>$status,'update_time'=>time());
		$this->infoObj->where($getLangAndID['field_id'],$id);
		$this->infoObj->where('idw',$this->idw);		
		$result = $this->infoObj->update($update);
	}
	public function editTitleInfo(){
		$id = 	$this->r->get_int('pk','POST');
		$title = $this->r->get_string('value','POST');
		//Cắt bỏ chuỗi -- đằng trước của danh mục.
		$rule="/([^-+\s]).+$/";
		if (!empty($title))
		{
			preg_match($rule, $title, $pr_title);			
			$getLangAndID = getLangAndID();
			$this->infoObj = new Model($getLangAndID['lang'].'_info');
			$this->infoObj->where($getLangAndID['field_id'],$id);
			$this->infoObj->where('idw',$this->idw);
			$result = $this->infoObj->update(array('title'=>$pr_title[0],'update_time'=>time()));
		}
	}	
	public function editSortInfo(){
		$id = 	$this->r->get_int('pk','POST');
		$sort = $this->r->get_int('value','POST');
		$getLangAndID = getLangAndID();
		$this->infoObj = new Model($getLangAndID['lang'].'_info');
		$this->infoObj->where($getLangAndID['field_id'],$id);
		$this->infoObj->where('idw',$this->idw);
		$result = $this->infoObj->update(array('sort'=>$sort,'update_time'=>time()));
	}
	public function deleteMultiID(){
		$ids = $this->r->get_array('name_id','POST');
		foreach($ids as $k=>$v){
			$this->deleteInfo($v);
		}
		$r['status'] = true;
		return $r;
	}
	public function deleteInfo($id=null){
		$multi = false;
		if (!isset($id)) {
			$id = 	$this->r->get_int('key','POST');
			$multi = true;
		}
		$this->result_id .=$id.",";
		$getLangAndID = getLangAndID();
		$this->infoObj = new Model($getLangAndID['lang'].'_info');
		$this->infoObj->where($getLangAndID['field_id'],$id);
		$this->infoObj->where('idw',$this->idw);
		$this->infoObj->delete();		
	}	
	public function saveImgFast(){
		$id = $this->r->get_int('id_img','POST');
		$str = 'img_info_'.$id;
		if (($_FILES[$str]["type"] == "image/gif") || ($_FILES[$str]["type"] == "image/jpeg") || ($_FILES[$str]["type"] == "image/jpg") || ($_FILES[$str]["type"] == "image/png")) {
			include(DIR_HELPER_UPLOAD);
		  	$options = array('max_size' => 1600);
			$upload = new BncUpload($options);
			$up_img = $upload->upload($this->idw,'info',$str);
			if (!empty($up_img)){
				$getLangAndID = getLangAndID();
				$this->infoObj = new Model($getLangAndID['lang']."_info");
				$this->infoObj->where($getLangAndID['field_id'],$id);
				$this->infoObj->where('idw',$this->idw);
				$result = $this->infoObj->update(array('img'=>$up_img));
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
	public function refeshInfo(){
		$getLangAndID = getLangAndID();
		$this->infoObj = new Model($getLangAndID['lang']."_info");
		$id = $this->r->get_int('key','POST');
		$create_time = array('create_time'=>time());
		if($getLangAndID['lang']!='vi')
		{
			$this->infoObj->where('idw',$this->idw);
			$this->infoObj->where($getLangAndID['field_id'],$id);
			$result = $this->infoObj->update($create_time);
		}else
		{
			$this->infoObj->where('idw',$this->idw);
			$this->infoObj->where('id',$id);
			$result = $this->infoObj->update($create_time);
		}
	}
	public function editPostInfo(){
		$getLangAndID = getLangAndID();
		$this->infoObj = new Model($getLangAndID['lang'].'_info');
		$status = '1';
		$time_up=0;
		$id = $this->r->get_int('key','POST');
		$update = array('status'=>$status,'time_up'=>$time_up,'update_time'=>time());
		$this->infoObj->where('idw',$this->idw);
		$this->infoObj->where($getLangAndID['field_id'],$id);
		$result = $this->infoObj->update($update);
	}
	public function autoPostInfo(){
		$getLangAndID=getLangAndID();
		$this->infoObj=new Model($getLangAndID['lang'].'_info');
		$select = array('id','id_lang','title','time_up','status');
		$this->infoObj->where('idw',$this->idw);
		$this->infoObj->where('status','2');
		$data = $this->infoObj->get(null,null,$select);
		foreach ($data as $key => $value) {
			if($value['time_up']<= strtotime(date('Y-m-d H:i:s')) && $value['time_up'] != 0)
			{
				$value['status']="1";
				$value['time_up']=0;
				$result[]=$value['id'];
			}
		}
		return $result;
	}
}