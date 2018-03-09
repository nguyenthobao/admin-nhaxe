<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/categorylist.php 
 * @Author Hùng (hungdct1083@gmail.com)
 * @Createdate 08/21/2014, 14:31 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class Home extends GlobalVideo{
	public $idw,$catVideoObj,$r,$lang; 
	public function __construct(){
			global $_B;	 
			$this->r = $_B['r'];
			$this->idw = $_B['web']['idw'];
			$this->lang = $_B['cf']['lang'];
	}
	public function activeStatusVideo(){
		global $_B;
			$getLangAndID = getLangAndID();
			$this->catVideoObj = new Model($getLangAndID['lang'].'_video');
			$status = $this->r->get_string('status','POST');
			$id = $this->r->get_int('key','POST');
			$update = array('status'=>$status,'update_time'=>time());
			if($getLangAndID['lang']!='vi')
			{
				$this->catVideoObj->where('idw',$this->idw);
				$this->catVideoObj->where($getLangAndID['field_id'],$id);
				$result = $this->catVideoObj->update($update);
				//$result = $this->getCategoryByParent($id);
			}else
			{
				$this->catVideoObj->where('idw',$this->idw);
				$this->catVideoObj->where('id',$id);
				$result = $this->catVideoObj->update($update);
			}	


	}
	public function deleteVideo(){
			$id = $this->r->get_int('key','POST');
			$getLangAndID = getLangAndID();
			$this->catVideoObj = new Model($getLangAndID['lang'].'_video');
			if($getLangAndID['lang']!='vi')
			{
				$this->catVideoObj->where('idw',$this->idw);
				$this->catVideoObj->where($getLangAndID['field_id'],$id);
				$this->catVideoObj->delete();
				//$result = $this->getCategoryByParent($id);
			}else
			{
				$this->catVideoObj->where('idw',$this->idw);
				$this->catVideoObj->where('id',$id);
				$this->catVideoObj->delete();
			}	
			if ($result) {
				$rt['status'] = true;
			}else{
				$rt['status'] = false;
				$rt['error'] = $this->catVideoObj->getLastError();
			}
		return $rt;


	}
	protected function getVideoByParent($cat_id) {
		$ids = array();
		$lang = (empty($this->lang))?'vi':$this->lang;
		$this->catVideoObj = new Model($lang.'_video');
		$this->catVideoObj->where('cat_id',$cat_id);
		$this->catVideoObj->where('idw',$this->idw);
		$ids = $this->catVideoObj->get(null,null,'id');
		foreach ($ids as $k=>$v) {
			$this->catVideoObj->where('id',$v);
			$this->catVideoObj->where('idw',$this->idw);
			$this->catVideoObj->delete();
			$result = $this->getCategoryByParent($v);
		}
	}	
	public function getCatVideo(){
		
		$getLangAndID = getLangAndID();
		$this->catVideoObj = new Model($getLangAndID['lang'].'_video');
				
		$total = $this->catVideoObj->num_rows();
		
		$max = 10;
		$maxNum = 5;
		
		$url = 'video-list-lang-'.$getLangAndID['lang'];
		$page = pagination($max, $total, $maxNum,$url);
		
		$start = $page['start'];
		$pagination = $page['pagination'];
		$select = '`id`,`id_lang`,`title`,`img`,`status`,`sort`';

		$this->catVideoObj->where('idw',$this->idw);
		$this->catVideoObj->orderBy('id','DESC');
		$result['data'] = $this->catVideoObj->get(null,array($start,$max),$select);
		if ($getLangAndID['lang']!='vi') {
			foreach ($result['data'] as $k => $v) {
				$v['id'] = $v['id_lang'];
				$result['data'][$k] = $v;
			}
		}
		$result['pagination'] = $pagination;
				
		return $result;



	}
	

}