<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/bannerlist.php 
 * @Author An Nguyen Huu(annh@webbnc.vn)
 * @Createdate 08/21/2014, 14:31 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class BannerList extends GlobalBanner{
	public $idw,$r,$lang,$result_id,$bannerObj;
	public function __construct(){
		global $_B;	 
		$this->r = $_B['r'];
		$this->idw = $_B['web']['idw'];
		$this->lang = $_B['cf']['lang'];
		$this->result_id = "";
	}
	public function activeStatusBanner(){
		//global $_B;
		$getLangAndID = getLangAndID();
		$this->bannerObj = new Model($getLangAndID['lang'].'_banner');
		$status = $this->r->get_string('status','POST');
		$id = $this->r->get_int('key','POST');
		$update = array('status'=>$status,'update_time'=>time());
		$this->bannerObj->where($getLangAndID['field_id'],$id);
		$this->bannerObj->where('idw',$this->idw);		
		$result = $this->bannerObj->update($update);
	}
	public function editTitleBanner(){
		$id = 	$this->r->get_int('pk','POST');
		$title = $this->r->get_string('value','POST');
		//Cắt bỏ chuỗi -- đằng trước của danh mục.
		$rule="/([^-+\s]).+$/";
		if (!empty($title))
		{
			preg_match($rule, $title, $pr_title);			
			$getLangAndID = getLangAndID();
			$this->bannerObj = new Model($getLangAndID['lang'].'_banner');
			$this->bannerObj->where($getLangAndID['field_id'],$id);
			$this->bannerObj->where('idw',$this->idw);
			$result = $this->bannerObj->update(array('title'=>$pr_title[0],'update_time'=>time()));
		}
	}	
	public function editSortBanner(){
		$id = 	$this->r->get_int('pk','POST');
		$sort = $this->r->get_int('value','POST');
		$getLangAndID = getLangAndID();
		$this->bannerObj = new Model($getLangAndID['lang'].'_banner');
		$this->bannerObj->where($getLangAndID['field_id'],$id);
		$this->bannerObj->where('idw',$this->idw);
		$result = $this->bannerObj->update(array('sort'=>$sort,'update_time'=>time()));
	}
	public function deleteMultiID(){
		$ids = $this->r->get_array('name_id','POST');
		foreach($ids as $k=>$v){
			$this->deleteBanner($v);
		}
		$r['status'] = true;
		return $r;
	}
	public function deleteBanner($id=null){
		$multi = false;
		if (!isset($id)) {
			$id = 	$this->r->get_int('key','POST');
			$multi = true;
		}
		$this->result_id .=$id.",";
		$getLangAndID = getLangAndID();
		$this->bannerObj = new Model($getLangAndID['lang'].'_banner');
		$this->bannerObj->where($getLangAndID['field_id'],$id);
		$this->bannerObj->where('idw',$this->idw);
		$this->bannerObj->delete();		
	}
	
}