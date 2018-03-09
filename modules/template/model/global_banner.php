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
class GlobalBanner{
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
	public function getBanner($value=null){
		$getLangAndID = getLangAndID();
		$this->bannerObj = new Model($getLangAndID['lang'].'_banner');
		$this->bannerObj->where('idw',$this->idw);
		$total = $this->bannerObj->num_rows();
		
		$max = 10;
		$maxNum = 5;

		$url = 'template-bannerlist-lang-'.$getLangAndID['lang'];
		$page = pagination($max, $total, $maxNum,$url);
		
		$start = $page['start'];
		$pagination = $page['pagination'];
		$select = '`id`,`id_lang`,`title`,`status`,`sort`,`position`,`create_time`';

		$this->bannerObj->where('idw',$this->idw);
		$this->bannerObj->orderBy('create_time','DESC');
		$result['data'] = $this->bannerObj->get(null,array($start,$max),$select);

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
	
	public function getBannerByID(){
		$getLangAndID = getLangAndID();
		$id = $this->r->get_int('id','GET');
		$this->bannerObj = new Model($getLangAndID['lang'].'_banner');
		$this->bannerObj->where($getLangAndID['field_id'],$id);
		$this->bannerObj->where('idw',$this->idw);
		$result = $this->bannerObj->getOne();
		if($result['time_up'] !=0)
		{
			$result['time_up']= date("d/m/Y H:i",$result['time_up']);
		}
		if ($result) {
			return $result;
		}
	}
	protected function fixBannerID($data,$id,$action){
		global $_B;
		$lang_user = explode(',',$_B['cf']['lang_use']);
		foreach ($lang_user as $k => $v) {
			if ($v!='vi') {
				$this->bannerObj = new Model($v.'_banner');
				$this->bannerObj->where('id_lang',$id);
				$this->bannerObj->where('idw',$this->idw);
				if ($action=='update') {
					$result = $this->bannerObj->update($data);	
				}else if($action=='delete'){
					$result = $this->bannerObj->delete();	
				}
			}
		}
		if ($result) {
			return true;
		}
	}
	protected function checkExistBanner($id,$lang){
		$this->bannerObj = new Model($lang.'_banner');
		$this->bannerObj->where('id_lang',$id);
		$this->bannerObj->where('idw',$this->idw);
		$result = $this->bannerObj->num_rows();
		if ($result) {
			return true;
		}
		return false;
	}
	
}