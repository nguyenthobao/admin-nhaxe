<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/categorylist.php 
 * @Author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 08/21/2014, 14:31 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class NewsList extends GlobalNews{
	public $idw,$catNewObj,$r,$lang,$result_id,$newsObj;
	public function __construct(){
		global $_B;	 
		$this->r = $_B['r'];
		$this->idw = $_B['web']['idw'];
		$this->lang = $_B['cf']['lang'];
		$this->result_id = "";
	}	
	public function activeStatusNews(){
		//global $_B;
		$getLangAndID = getLangAndID();
		$this->newsObj = new Model($getLangAndID['lang'].'_news');
		$status = $this->r->get_string('status','POST');
		$id = $this->r->get_int('key','POST');
		$update = array('status'=>$status,'update_time'=>time());
		$this->newsObj->where($getLangAndID['field_id'],$id);
		$this->newsObj->where('idw',$this->idw);
		
		$result = $this->newsObj->update($update);
	}
	public function editTitleNews(){
		$id = 	$this->r->get_int('pk','POST');
		$title = $this->r->get_string('value','POST');
		//Cắt bỏ chuỗi -- đằng trước của danh mục.
		$rule="/([^-+\s]).+$/";
		if (!empty($title))
		{
			preg_match($rule, $title, $pr_title);			
			$getLangAndID = getLangAndID();
			$this->newsObj = new Model($getLangAndID['lang'].'_news');
			$this->newsObj->where($getLangAndID['field_id'],$id);
			$this->newsObj->where('idw',$this->idw);
			$result = $this->newsObj->update(array('title'=>$pr_title[0],'update_time'=>time()));
		}
	}
	
	public function editSortNews(){
		$id = 	$this->r->get_int('pk','POST');
		$sort = $this->r->get_int('value','POST');
		$getLangAndID = getLangAndID();
		$this->newsObj = new Model($getLangAndID['lang'].'_news');
		$this->newsObj->where($getLangAndID['field_id'],$id);
		$this->newsObj->where('idw',$this->idw);
		$result = $this->newsObj->update(array('sort'=>$sort,'update_time'=>time()));
	}
	public function deleteMultiID(){
		$ids = $this->r->get_array('name_id','POST');
		foreach($ids as $k=>$v){
			$this->deleteNews($v);
		}
		$r['status'] = true;
		return $r;
	}
	public function deleteNews($id=null){
		//$lang = (empty($this->lang))?'vi':$this->lang;
		$multi = false;
		if (!isset($id)) {
			$id = 	$this->r->get_int('key','POST');
			$multi = true;
		}
		$this->result_id .=$id.",";
		$getLangAndID = getLangAndID();
		$this->newsObj = new Model($getLangAndID['lang'].'_news');
		$this->newsObj->where($getLangAndID['field_id'],$id);
		$this->newsObj->where('idw',$this->idw);
		$this->newsObj->delete();
		
	}
	
	public function saveImgFast(){
		//global $_B;
		$id = $this->r->get_int('id_img','POST');
		$str = 'img_news_'.$id;
		//echo $str;
		include(DIR_HELPER_UPLOAD);
	  	$options = array('max_size' => 1600);
		$upload = new BncUpload($options);		
		$up_img = $upload->upload($this->idw,'news',$str);
		if (!empty($up_img)){
			$getLangAndID = getLangAndID();
			$this->newsObj = new Model($getLangAndID['lang']."_news");
			$this->newsObj->where($getLangAndID['field_id'],$id);
			$this->newsObj->where('idw',$this->idw);
			$result = $this->newsObj->update(array('img'=>$up_img));
			if ($result) {
				$data['status'] = true;
			}else{
				$data['status'] = false;
			}
			return $data;
		}
	}
	public function refeshNews(){
		$getLangAndID = getLangAndID();
		$this->newsObj = new Model($getLangAndID['lang']."_news");
		$id = $this->r->get_int('key','POST');
		$create_time = array('create_time'=>time());
		if($getLangAndID['lang']!='vi')
		{
			$this->newsObj->where('idw',$this->idw);
			$this->newsObj->where($getLangAndID['field_id'],$id);
			$result = $this->newsObj->update($create_time);
		}else
		{
			$this->newsObj->where('idw',$this->idw);
			$this->newsObj->where('id',$id);
			$result = $this->newsObj->update($create_time);
		}
	}
	public function editPostNews(){
		$getLangAndID = getLangAndID();
		$this->newsObj = new Model($getLangAndID['lang'].'_news');
		$status = '1';
		$time_up=0;
		$id = $this->r->get_int('key','POST');
		$update = array('status'=>$status,'time_up'=>$time_up,'update_time'=>time());
		$this->newsObj->where('idw',$this->idw);
		$this->newsObj->where($getLangAndID['field_id'],$id);
		$result = $this->newsObj->update($update);
	}
	public function autoPostNews()
	{
		$getLangAndID=getLangAndID();
		$this->newsObj=new Model($getLangAndID['lang'].'_news');
		$select = array('id','id_lang','title','time_up','status');
		$this->newsObj->where('idw',$this->idw);
		$this->newsObj->where('status','2');
		$data = $this->newsObj->get(null,null,$select);
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