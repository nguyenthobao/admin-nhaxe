<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/global_template.php 
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 10/13/2014, 16:10 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class GlobalTemplate{	 

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

	public function getLogoID(){
		$id = $this->r->get_int('id','get');
		$this->logoObj = new Model('vi_logo');
		//$select = array('id');
		$this->logoObj->where('id',$id);
		$this->logoObj->where('idw',$this->idw);
		$result = $this->logoObj->getOne();		
		return $result;
	}
	public function getSlideID(){
		$id = $this->r->get_int('id','get');
		$this->slideObj = new Model('vi_slide');
		//$select = array('id');
		$this->slideObj->where('id',$id);
		$this->slideObj->where('idw',$this->idw);
		$result = $this->slideObj->getOne();		
		return $result;
	}
	public function getLogoByID(){
		$getLangAndID = getLangAndID();
		$this->logoObj = new Model($getLangAndID['lang'].'_logo');
		$this->logoObj->where('idw',$this->idw);
		$result = $this->logoObj->getOne();
		if ($getLangAndID['lang']!='vi') {
			$result['id'] = $result['id_lang'];
		}
		if ($result) {
			return $result;
		}
	}
	public function getBackground(){
		$this->logoObj = new Model('background');
		$this->logoObj->where('idw',$this->idw);
		$result = $this->logoObj->getOne();
		if ($result) {
			return $result;
		}
	}
	public function getAudio(){
		$this->logoObj = new Model('audio');
		$this->logoObj->where('idw',$this->idw);
		$result = $this->logoObj->getOne();
		if ($result) {
			return $result;
		}
	}
	public function checkExistLogo($id,$lang){
		$getLangAndID = getLangAndID();
		$this->logoObj = new Model($lang.'_logo');
		$this->logoObj->where($getLangAndID['field_id'],$id);
		$this->logoObj->where('idw',$this->idw);
		$result = $this->logoObj->num_rows();
		if ($result) {
			return true;
		}
		return false;
	}
	protected function fixLogoID($data,$id,$action){
		global $_B;
		$lang_user = explode(',',$_B['cf']['lang_use']);
		foreach ($lang_user as $k => $v) {
			if ($v!='vi') {
				$this->logoObj = new Model($v.'_logo');
				$this->logoObj->where('id',$id);
				$this->logoObj->where('idw',$this->idw);
				if ($action=='update') {
					$result = $this->logoObj->update($data);	
				}else if($action=='delete'){
					$result = $this->logoObj->delete();	
				}
			}
		}
		if ($result) {
			return true;
		}
	}
	public function getSlide($value=null){
		$getLangAndID = getLangAndID();
		$this->slideObj = new Model($getLangAndID['lang'].'_slide');
		$this->slideObj->where('idw',$this->idw);
		$total = $this->slideObj->num_rows();
		
		$max = 10;
		$maxNum = 5;

		$url = 'template-slidelist-lang-'.$getLangAndID['lang'];
		$page = pagination($max, $total, $maxNum,$url);
		
		$start = $page['start'];
		$pagination = $page['pagination'];
		$select = '`id`,`id_lang`,`title`,`position`,`status`,`sort`,`create_time`';

		$this->slideObj->where('idw',$this->idw);
		$this->slideObj->orderBy('create_time','DESC');
		$result['data'] = $this->slideObj->get(null,array($start,$max),$select);

		if ($getLangAndID['lang']!='vi') {
			foreach ($result['data'] as $k => $v) {
				$v['id'] = $v['id_lang'];
				$result['data'][$k] = $v;
			}
		}
		if ($total > 10) {
			$result['pagination'] = $pagination;
		}
		return $result;
	}
	public function getSlideByID(){
		$getLangAndID = getLangAndID();
		$id = $this->r->get_int('id','GET');
		$this->slideObj = new Model($getLangAndID['lang'].'_slide');
		$this->slideObj->where($getLangAndID['field_id'],$id);
		$this->slideObj->where('idw',$this->idw);
		$result = $this->slideObj->getOne();
		if ($result) {
			return $result;
		}
	}
	protected function fixSlideID($data,$id,$action){
		global $_B;
		$lang_user = explode(',',$_B['cf']['lang_use']);
		foreach ($lang_user as $k => $v) {
			if ($v!='vi') {
				$this->slideObj = new Model($v.'_slide');
				$this->slideObj->where('id_lang',$id);
				$this->slideObj->where('idw',$this->idw);
				if ($action=='update') {
					$result = $this->slideObj->update($data);	
				}else if($action=='delete'){
					$result = $this->slideObj->delete();	
				}
			}
		}
		if ($result) {
			return true;
		}
	}
	protected function checkExistSlide($id,$lang){
		$this->slideObj = new Model($lang.'_slide');
		$this->slideObj->where('id_lang',$id);
		$this->slideObj->where('idw',$this->idw);
		$result = $this->slideObj->num_rows();
		if ($result) {
			return true;
		}
		return false;
	}
}