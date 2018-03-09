<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/categorylist.php 
 * @Author An Nguyen Huu(annh@webbnc.vn)
 * @Createdate 08/21/2014, 14:31 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class NewsList extends GlobalNews{
	public $idw,$catNewObj,$r,$lang,$result_id,$newsObj;
	private $uid;
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
		$update = array('status'=>$status,'update_time'=>time(),'update_uid'=>$_B['uid']);
		$this->newsObj->where($getLangAndID['field_id'],$id);
		$this->newsObj->where('idw',$this->idw);
		$result = $this->newsObj->update($update);
	}
	public function editTitleNews(){
		$id = 	$this->r->get_int('pk','POST');
		$title = strip_tags($this->r->get_string('value','POST'));
		//Cắt bỏ chuỗi -- đằng trước của danh mục.
		$rule="/([^-+\s]).+$/";
		if (!empty($title))
		{
			preg_match($rule, $title, $pr_title);			
			$getLangAndID = getLangAndID();
			$this->newsObj = new Model($getLangAndID['lang'].'_news');
			$this->newsObj->where($getLangAndID['field_id'],$id);
			$this->newsObj->where('idw',$this->idw);
			$result = $this->newsObj->update(array('title'=>$pr_title[0],'update_time'=>time(),'update_uid'=>$_B['uid']));
		}
	}	
	public function editSortNews(){
		$id = 	$this->r->get_int('pk','POST');
		$sort = $this->r->get_int('value','POST');
		$getLangAndID = getLangAndID();
		$this->newsObj = new Model($getLangAndID['lang'].'_news');
		$this->newsObj->where($getLangAndID['field_id'],$id);
		$this->newsObj->where('idw',$this->idw);
		$result = $this->newsObj->update(array('sort'=>$sort,'update_time'=>time(),'update_uid'=>$_B['uid']));
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
		$id = $this->r->get_int('id_img','POST');
		$str = 'img_news_'.$id;
		
		if (($_FILES[$str]["type"] == "image/gif") || ($_FILES[$str]["type"] == "image/jpeg") || ($_FILES[$str]["type"] == "image/jpg") || ($_FILES[$str]["type"] == "image/png")) {
			
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
		}else{
			return false;
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
	
	public function copyNews(){
		$getLangAndID = getLangAndID();
		$this->newsObj = new Model($getLangAndID['lang'].'_news');
		$ids = $this->r->get_array('name_id','POST');
		foreach ($ids as $k=>$v) {
			$this->newsObj->where('idw',$this->idw);
			$this->newsObj->where($getLangAndID['field_id'],$v);
			$data = $this->newsObj->get(null,null,'*');
			foreach ($data as $key=>$value) {
				if ($getLangAndID['lang']!='vi') {
					$this->copyNewsVi($value['id_lang']);
				}else{
					unset($value['id']);
					$timeCopy = date('H:i:s d-m');
					$value['title'] .= ' - Copy - '.$timeCopy;
					$value['status'] = 0;
					$result = $this->newsObj->insert($value);
				}
			}
		}
		if ($data) {
			$return['status'] = true;
		}else{
			$return['status'] = false;
			$return['error'] = $this->newsObj->getLastError();
		}
		return $return;
	}
	public function copyNewsVi($id_lang) {
		$getLangAndID = getLangAndID();
		$this->newsObj = new Model('vi_news');
		$this->newsObj->where('idw',$this->idw);
		$this->newsObj->where('id',$id_lang);
		$dataVi = $this->newsObj->get(null,null,'*');
		foreach ($dataVi as $k=>$v) {
			unset($v['id']);
			$timeCopy = date('H:i:s d-m');
			$v['title'] .= ' - Copy - '.$timeCopy;
			$v['status'] = 0;
			$resultVi = $this->newsObj->insert($v);

			$this->newsObj->where('idw',$this->idw);
			$this->newsObj->where('id',$resultVi);
			$dataNew = $this->newsObj->get(null,null,'*');

			foreach ($dataNew as $key=>$val) {
				$getLangAndID = getLangAndID();
				$this->newsObj = new Model($getLangAndID['lang'].'_news');
				unset($val['id']);
				$timeCopy = date('H:i:s d-m');
				$val['title'] .= ' - Copy - '.$timeCopy;
				$val['status'] = 0;
				$val['id_lang'] = $resultVi;
				$resultNew = $this->newsObj->insert($val);
			}
		}
	}

	public function ajaxCopyNews() {
        $langData  = $this->r->get_string('langData', 'POST');
        $emptyData  = $this->r->get_int('emptyData', 'POST');

        $getLangAndID = getLangAndID();
        $this->newsObj = new Model($getLangAndID['lang'].'_news');
        $this->newsObj->where('idw', $this->idw);
        $data = $this->newsObj->get();
        //Kiểm tra làm rỗng
        if ($emptyData == 1) {
            $this->emptyNews($langData);
        } 
        $this->ajaxCopyCategory($langData,$emptyData);
        //Đệ quy install
        if(!empty($data)){
        	$insl = $this->copyNewsLang($data,$langData); 
    	}
 		echo "Sao chép thành công";
	}

	public function copyNewsLang($data, $langData) { 
				$newsObj = new Model($langData.'_news');
		        foreach ($data as $k => $v) {
		            $data_insert = $v;
		            unset($data_insert['id']);
		            if ($v['id_lang'] == null) {
		                $data_insert['id_lang'] = $v['id'];
		            }            
		            $idcp= $newsObj->insert($data_insert);
		            $data_cat = explode(",", $v['cat_id'] );
		            foreach ($data_cat as $key => $value) {
		            	$data_tmp[]=$value;
		            }	            
		        }
		        $data_tmp = array_unique($data_tmp);
		        $data_tmp = array_filter($data_tmp);
		        // var_dump($data_tmp);
		        // die();
		  		return true;
	}
	private function emptyNews($langData) {

		        $this->newsObj = new Model($langData.'_news');
		        if($this->idw){
		        	$this->newsObj->where('idw', $this->idw);
		        	return $this->newsObj->delete();
		        }	        	
	}
	public function ajaxCopyCategory($langData,$emptyData) {
        
        $getLangAndID = getLangAndID();
        $this->catNewObj = new Model($getLangAndID['lang'].'_category');
        $this->catNewObj->where('idw', $this->idw);
        $data = $this->catNewObj->get();
        //Kiểm tra làm rỗng    
        $this->emptyCategory($langData); 
        //Đệ quy install
        if(!empty($data)){
        	$insl = $this->copyCategoryLang($data,$langData); 
    	}
 		//echo "Sao chép thành công";
	}

	public function copyCategoryLang($data, $langData) { 
				$catNewObj = new Model($langData.'_category');
		        foreach ($data as $k => $v) {
		            $data_insert = $v;
		            unset($data_insert['id']);
		            if ($v['id_lang'] == null) {
		                $data_insert['id_lang'] = $v['id'];
		            }
		            
		            $idcp= $catNewObj->insert($data_insert);
		            
		        }
		  		return true;
	}
	private function emptyCategory($langData) {

		        $this->catNewObj = new Model($langData.'_category');
		        if($this->idw){
		        	$this->catNewObj->where('idw', $this->idw);
		        	return $this->catNewObj->delete();
		        }	        	
		}
	
}