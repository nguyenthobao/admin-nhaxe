<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/global.php 
 * @Author Hùng
 * @Createdate 08/17/2014, 15:46 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class GlobalVideo{
	 
	//Đêm danh mục 
	public function countCategory(){
			$lang = (empty($this->lang))?'vi':$this->lang;
			$this->catVideoObj = new Model($lang.'_category');
			$this->catVideoObj->where('idw',$this->idw);
			$this->catVideoObj->where('status',1);
			$result = $this->catVideoObj->num_rows();
			return $result;
	}
	//
	//Chuyển đổi từ mảng đa chiều thành mảng 1 chiều
	public function multipleToSimpleArray($array,$newarray = array()){
		foreach ($array as $k => $v) {
			$tmp = $v['sub'];
			unset($v['sub']);
			$newarray[] = $v;
			if(sizeof($tmp) > 0){
				$newarray = $this->multipleToSimpleArray($tmp,$newarray);
			}
		}
		return $newarray;
	}
	public function getCatParent(){
		$id = $this->r->get_int('id', 'GET');
		$getLangAndID = $this->getLangAndID();
		$this->catVideoObj = new Model($getLangAndID['lang'].'_category');
		$select = array('id','id_lang','title','parent_id','status','sort');
		$this->catVideoObj->where('idw',$this->idw);
		if($id){
			$this->catVideoObj->where('id',$id,"!=");
		}
		
		$this->catVideoObj->orderBy('sort','ASC');
		$data = $this->catVideoObj->get(null,null,$select);
		if ($getLangAndID['lang']!='vi') {
			foreach ($data as $k => $v) {
				$v['id'] = $v['id_lang'];
				$data[$k] = $v;
			}
		}

		$result = $this->getCategory($data);
		if ($result) {
			return $result;
		}
	}
	public function getCatParentVD(){
		$id = $this->r->get_int('id', 'GET');
		$getLangAndID = $this->getLangAndID();
		$this->catVideoObj = new Model($getLangAndID['lang'].'_category');
		$select = array('id','id_lang','title','parent_id','status','sort');
		$this->catVideoObj->where('idw',$this->idw);
		$this->catVideoObj->orderBy('sort','ASC');
		$data = $this->catVideoObj->get(null,null,$select);
		if ($getLangAndID['lang']!='vi') {
			foreach ($data as $k => $v) {
				$v['id'] = $v['id_lang'];
				$data[$k] = $v;
			}
		}

		$result = $this->getCategory($data);
		if ($result) {
			return $result;
		}
	}
	public function getCatVideo(){
		$getLangAndID = $this->getLangAndID();
		$this->catVideoObj = new Model($getLangAndID['lang'].'_video');
		$select = array('id','id_lang','title','status','sort');
		$this->catVideoObj->where('idw',$this->idw);
		$this->catVideoObj->orderBy('sort','ASC');
		$result = $this->catVideoObj->get(null,null,$select);
		if ($getLangAndID['lang']!='vi') {
			foreach ($result as $k => $v) {
				$v['id'] = $v['id_lang'];
				$result[$k] = $v;
			}
		}
		
		if ($result) {
			return $result;
		}
	}
	
	protected function getCategory($data = array(), $parent = 0,$space='') {			
		$current = array();
		if(is_array($data)){
			foreach ($data as $key => $val) {
				if ($val['parent_id'] == $parent) {
					$current[] = $val;
					unset($data[$key]);
				}
			}
		}
		if (sizeof($current) > 0) {			
			foreach ($current as $k => $v) {
				$current[$k]['title'] = $space." ".$v['title'];
				$current[$k]['sub'] = $this->getCategory($data, $v['id'], $space.'--'); 
			}	
		}
		return $current;
	} 
	protected function getLangAndID(){
		global $_B;
		 
		$get_lang = $this->r->get_string('lang','GET');
		if (!empty($get_lang)) {
			if (in_array($get_lang,explode(',',$_B['cf']['lang_use']))) {
				$lang = $get_lang;
				$field_id = ($get_lang=='vi')?'id':'id_lang';
			}else{
				$lang = 'vi';
				$field_id = 'id';
			}
		}else{
			$lang = $this->r->get_string('lang','POST');
			$lang = (empty($lang))?'vi':$lang;
			$field_id = 'id';
		}
		$result['lang']=$lang;
		$result['field_id']=$field_id;
		return $result;
	}	
	protected function fixParentCat($data,$parent_id,$id){
		global $_B;
		$lang_user = explode(',',$_B['cf']['lang_use']);
		foreach ($lang_user as $k => $v) {
			if ($v!='vi') {
				$this->catVideoObj = new Model($v.'_category');
				$this->catVideoObj->where('id_lang',$id);
				$this->catVideoObj->where('idw',$this->idw);
				$result = $this->catVideoObj->update($data);		
			}
		}
		if ($result) {
			return true;
		}
	}
	protected function checkExist($id,$lang){
		$this->catVideoObj = new Model($lang.'_video');
		$this->catVideoObj->where('id_lang',$id);
		$this->catVideoObj->where('idw',$this->idw);
		$result = $this->catVideoObj->num_rows();
		if ($return) {
			return true;
		}
		return false;
	}

}