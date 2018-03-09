<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/global.php 
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/17/2014, 15:46 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
class GlobalInfo{
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
	public function getInfo($value=null){
		$getLangAndID = getLangAndID();
		$this->infoObj = new Model($getLangAndID['lang'].'_info');
		$this->infoObj->where('idw',$this->idw);
		$total = $this->infoObj->num_rows();
		
		$max = 10;
		$maxNum = 5;

		$url = 'info-infolist-lang-'.$getLangAndID['lang'];
		$page = pagination($max, $total, $maxNum,$url);
		
		$start = $page['start'];
		$pagination = $page['pagination'];
		$select = '`id`,`id_lang`,`title`,`img`,`status`,`sort`,`create_time`';

		$this->infoObj->where('idw',$this->idw);
		$this->infoObj->orderBy('create_time','DESC');
		$result['data'] = $this->infoObj->get(null,array($start,$max),$select);

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
	public function searchInfo(){
		$value = $this->r->get_string('value','GET');
		$keySearch = base64_decode($value);
		$keySearch = json_decode($keySearch,1);
		
		$lang = $this->r->get_string('lang','GET');
		$this->infoObj = new Model($lang.'_info');
		$this->infoObj->where('idw',$this->idw);
		if (!empty($keySearch['info_title']) && $keySearch['info_title'] != "") {
			$str = trim($this->replate_string($keySearch['info_title']));
			$this->infoObj->where('title','%'.$str.'%','LIKE');
		}		

		if ($keySearch['status_info'] != "all") {
			if ($keySearch['status_info'] == 'show')
			{
				$status_info = 1;
			}
			elseif ($keySearch['status_info'] == 'hide') {
				$status_info = 0;
			}
			elseif ($keySearch['status_info'] == 'time') {
				$status_info = 2;
			}
			//$status_info = ($keySearch['status_info'] == 'show')?1:0;
			$this->infoObj->where('status',$status_info);
		}
		$this->infoObj->where('idw',$this->idw);
		$total = $this->infoObj->num_rows();

		$max = 10;
		$maxNum = 5;

		$url = 'info-infolist-lang-'.$lang.'-value-'.$value;

		$page = pagination($max, $total, $maxNum,$url);
		
		$start = $page['start'];
		$pagination = $page['pagination'];
		$this->infoObj->where('idw',$this->idw);

		if (!empty($keySearch['info_title']) && $keySearch['info_title'] != "") {
			$str = trim($this->replate_string($keySearch['info_title']));
			$this->infoObj->where('title','%'.$str.'%','LIKE');
		}
		if ( $keySearch['status_info'] != "all") {
			//$status_info = ($keySearch['status_info'] == 'show')?1:0;
			if ($keySearch['status_info'] == 'show')
			{
				$status_info = 1;
			}
			elseif ($keySearch['status_info'] == 'hide') {
				$status_info = 0;
			}
			elseif ($keySearch['status_info'] == 'time') {
				$status_info = 2;
			}
			$this->infoObj->where('status',$status_info);
		}

		$result['data'] = $this->infoObj->get(null,array($start,$max),'*');		
		$result['keySearch'] = $keySearch;
		
		if ($lang != 'vi') {
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
	public function getInfoByID(){
		$getLangAndID = getLangAndID();
		$id = $this->r->get_int('id','GET');
		$this->infoObj = new Model($getLangAndID['lang'].'_info');
		$this->infoObj->where($getLangAndID['field_id'],$id);
		$this->infoObj->where('idw',$this->idw);
		$result = $this->infoObj->getOne();
		if($result['time_up'] !=0)
		{
			$result['time_up']= date("d/m/Y H:i",$result['time_up']);
		}
		if ($result) {
			return $result;
		}
	}
	protected function fixInfoID($data,$id,$action){
		global $_B;
		$lang_user = explode(',',$_B['cf']['lang_use']);
		foreach ($lang_user as $k => $v) {
			if ($v!='vi') {
				$this->infoObj = new Model($v.'_info');
				$this->infoObj->where('id_lang',$id);
				$this->infoObj->where('idw',$this->idw);
				if ($action=='update') {
					$result = $this->infoObj->update($data);	
				}else if($action=='delete'){
					$result = $this->infoObj->delete();	
				}
			}
		}
		if ($result) {
			return true;
		}
	}
	protected function checkExistInfo($id,$lang){
		$this->infoObj = new Model($lang.'_info');
		$this->infoObj->where('id_lang',$id);
		$this->infoObj->where('idw',$this->idw);
		$result = $this->infoObj->num_rows();
		if ($result) {
			return true;
		}
		return false;
	}
	public function replate_string($str){
		if (strpos($str, "'") !== false){			
    		$str = str_replace("'", "&#039;", $str);
    	}
    	elseif (strpos($str, '"') !== false){
    		$str = str_replace('"', "&quot;", $str);
    	}
    	elseif (strpos($str, "<") !== false){
    		$str = str_replace("<", "&lt;", $str);
    	}
    	elseif (strpos($str, ">") !== false){
    		$str = str_replace(">", "&gt;", $str);
    	}
		return $str;
	}
}