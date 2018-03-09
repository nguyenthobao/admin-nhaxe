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
class GlobalNews{
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
	public function getNews($value=null){
		$getLangAndID = getLangAndID();
		$this->newsObj = new Model($getLangAndID['lang'].'_news');
		$this->newsObj->where('idw',$this->idw);
		$total = $this->newsObj->num_rows();
		
		$max = 10;
		$maxNum = 5;

		$url = 'news-newslist-lang-'.$getLangAndID['lang'];
		$page = pagination($max, $total, $maxNum,$url);
		
		$start = $page['start'];
		$pagination = $page['pagination'];
		$select = '`id`,`id_lang`,`title`,`img`,`status`,`sort`,`create_time`';

		$this->newsObj->where('idw',$this->idw);
		$this->newsObj->orderBy('create_time','DESC');
		$result['data'] = $this->newsObj->get(null,array($start,$max),$select);

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
	public function searchNews(){
		$value = $this->r->get_string('value','GET');
		$keySearch = base64_decode($value);
		$keySearch = json_decode($keySearch,1);
		
		$lang = $this->r->get_string('lang','GET');
		$this->newsObj = new Model($lang.'_news');
		$this->newsObj->where('idw',$this->idw);
		if (!empty($keySearch['news_title']) && $keySearch['news_title'] != "") {
			$str = $this->replate_string($keySearch['news_title']);
			$this->newsObj->where('title','%'.$str.'%','LIKE');
		}		
		if (!empty($keySearch['cat_id']) && $keySearch['cat_id']!="0") {
			$this->newsObj->where('cat_id','%,'.$keySearch['cat_id'].',%','LIKE');
		}
		if ($keySearch['status_news'] != "all") {
			if ($keySearch['status_news'] == 'show')
			{
				$status_news = 1;
			}
			elseif ($keySearch['status_news'] == 'hide') {
				$status_news = 0;
			}
			elseif ($keySearch['status_news'] == 'time') {
				$status_news = 2;
			}
			//$status_news = ($keySearch['status_news'] == 'show')?1:0;			
			$this->newsObj->where('status',$status_news);
		}
		$this->newsObj->where('idw',$this->idw);
		$total = $this->newsObj->num_rows();

		$max = 10;
		$maxNum = 5;

		$url = 'news-newslist-lang-'.$lang.'-value-'.$value;

		$page = pagination($max, $total, $maxNum,$url);
		
		$start = $page['start'];
		$pagination = $page['pagination'];
		$this->newsObj->where('idw',$this->idw);

		if (!empty($keySearch['news_title']) && $keySearch['news_title'] != "") {
			$str = $this->replate_string($keySearch['news_title']);
			$this->newsObj->where('title','%'.$str.'%','LIKE');
		}
		if (!empty($keySearch['cat_id']) && $keySearch['cat_id']!="0") {
			$this->newsObj->where('cat_id','%,'.$keySearch['cat_id'].',%','LIKE');
		}
		if ( $keySearch['status_news'] != "all") {
			//$status_news = ($keySearch['status_news'] == 'show')?1:0;
			if ($keySearch['status_news'] == 'show')
			{
				$status_news = 1;
			}
			elseif ($keySearch['status_news'] == 'hide') {
				$status_news = 0;
			}
			elseif ($keySearch['status_news'] == 'time') {
				$status_news = 2;
			}
			$this->newsObj->where('status',$status_news);
		}

		$result['data'] = $this->newsObj->get(null,array($start,$max),'*');		
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
	public function getNewsByID(){
		$getLangAndID = getLangAndID();
		$id = $this->r->get_int('id','GET');
		$this->newsObj = new Model($getLangAndID['lang'].'_news');
		$this->newsObj->where($getLangAndID['field_id'],$id);
		$this->newsObj->where('idw',$this->idw);
		$result = $this->newsObj->getOne();
		if($result['time_up'] !=0)
		{
			$result['time_up']= date("d/m/Y H:i",$result['time_up']);
		}
		$result['cat_id'] = explode(',', $result['cat_id']);
		if ($result) {
			return $result;
		}
	}
	public function loadMoreRelated(){
		global $_B;
		$getLangAndID = getLangAndID();
		$this->newsObj = new Model($getLangAndID['lang'].'_news');
		$start = $this->r->get_int('start', 'POST');
		$id = $this->r->get_int('id','POST');
		$this->newsObj->where($getLangAndID['field_id'],$id);
		$this->newsObj->where('idw',$this->idw);
		$newsss = $this->newsObj->getOne();
		$related  = $newsss['related_news'];
		$select = array('id','id_lang','title','img');
		$items = explode(",",$related);
		if ($items!=null) {
			foreach ($items as $key => $value) {
				$this->newsObj->where($getLangAndID['field_id'],$value,'!=');
			}			
		}
		if($id){
			$this->newsObj->where($getLangAndID['field_id'],$id,"!=");
		}
		$this->newsObj->where('idw',$this->idw);
		$this->newsObj->where('status',1);
		$this->newsObj->orderBy('id','DESC');
				
		$result['data'] = $this->newsObj->get(null,array($start,5),$select);
		if ($getLangAndID['lang']=='vi') {
			foreach ($result['data'] as $k => $v) {
				if($v['img'] != '')
				{
					$v['img'] = $_B['upload_path']."".$v['img'];
				}
				else
				{
					$v['img'] = $_B['home']."/themes/default/assets/no_image.gif";
				}
				$result['data'][$k] = $v;
			}
		}
		else {
			foreach ($result['data'] as $k => $v) {
				$v['id'] = $v['id_lang'];
				if($v['img'] != '')
				{
					$v['img'] = $_B['upload_path']."".$v['img'];
				}
				else
				{
					$v['img'] = $_B['home']."/themes/default/assets/no_image.gif";
				}
				$result['data'][$k] = $v;
			}			
		}
		echo json_encode($result);
	}
	public function getRelatedNews($items=null){
		$id = $this->r->get_int('id');
		$getLangAndID = getLangAndID();
		$this->newsObj = new Model($getLangAndID['lang'].'_news');
		$select = array('id','id_lang','title','img');
		$this->newsObj->where('idw',$this->idw);
		$this->newsObj->where('status',1);
		if ($items!=null) {
			foreach ($items as $key => $value) {
				$this->newsObj->where($getLangAndID['field_id'],$value,'!=');
			}			
		}
		if($id){
			$this->newsObj->where($getLangAndID['field_id'],$id,"!=");
		}
		$this->newsObj->orderBy('id','DESC');
		$result['data'] = $this->newsObj->get(null,array(0,10),$select);
		if (!empty($result['data'])) {
			if ($getLangAndID['lang']!='vi') {
				foreach ($result['data'] as $k => $v) {
					$v['id'] = $v['id_lang'];
					$result['data'][$k] = $v;
				}
			}	
		}		
		return $result;
	}
	public function getRelatedNewsByID($id){
		$getLangAndID = getLangAndID();
		$this->newsObj = new Model($getLangAndID['lang'].'_news');
		$this->newsObj->where($getLangAndID['field_id'],$id);
		$this->newsObj->where('idw',$this->idw);
		$data = $this->newsObj->getOne(null,'id,id_lang,img,title');
		if ($data) {
			if ($getLangAndID['lang']!='vi') {
				foreach ($data as $k=>$v) {
					$v['id'] = $v['id_lang'];
					$data[$k] = $v;
				}
			}
			return $data;
		}
	}
	public function getCatParent(){
		$getLangAndID = getLangAndID();
		$this->catNewObj = new Model($getLangAndID['lang'].'_category');
		$select = array('id','id_lang','title','parent_id','status','sort');
		$this->catNewObj->where('idw',$this->idw);
		$this->catNewObj->orderBy('sort','ASC');
		$data = $this->catNewObj->get(null,null,$select);
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
	protected function getCategory($data = array(), $parent = 0,$space=''){
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
				$current[$k]['title'] = $v['title'];
				$current[$k]['space'] = $space." ";
				$current[$k]['sub'] = $this->getCategory($data, $v['id'], $space.'--'); 
			}	
		}
		return $current;
	}	
	protected function fixParentCat($data,$id,$action){
		global $_B;
		$lang_user = explode(',',$_B['cf']['lang_use']);
		foreach ($lang_user as $k => $v) {
			if ($v!='vi') {
				$this->catNewObj = new Model($v.'_category');
				$this->catNewObj->where('id_lang',$id);
				$this->catNewObj->where('idw',$this->idw);
				if ($action=='update') {
					$result = $this->catNewObj->update($data);	
				}else if($action=='delete'){
					$result = $this->catNewObj->delete();	
				}
			}
		}
		if ($result) {
			return true;
		}
	}	
	protected function deleteNewsCat($data,$id,$action){
		if ($action=='delete') {
			$getLangAndID = getLangAndID();
			$this->newsObj = new Model($getLangAndID['lang'].'_news');
			$select = array('cat_id,id');
			$cat_ids = ",".$id.",";
			$this->newsObj->where('cat_id','%'.$cat_ids.'%','LIKE');
			$this->newsObj->where('idw',$this->idw);		
			$result = $this->newsObj->get(null,null,$select);
			if(isset($result)){
				foreach ($result as $val) {
					if ($val['cat_id'] == $cat_ids) {
						$this->newsObj->where('cat_id',$cat_ids);
						$result = $this->newsObj->delete();
					}else {
						$str_cat = str_replace($cat_ids, ",", $val['cat_id']);
						$this->newsObj->where($getLangAndID['field_id'],$val['id']);
						$result = $this->newsObj->update(array('cat_id'=>$str_cat));
					}
				}
			}
			if ($result) {
				return true;
			}
		}		
	}	


	// protected function deleteNewsCatParent($data,$parent_id,$action){
	// 	if ($action=='delete') {
	// 		$getLangAndID = getLangAndID();
	// 		$this->newsObj = new Model($getLangAndID['lang'].'_news');
	// 		$select = array('cat_id,id');
	// 		$cat_ids = ",".$parent_id.",";
	// 		$this->newsObj->where('cat_id','%'.$cat_ids.'%','LIKE');
	// 		$this->newsObj->where('idw',$this->idw);
	// 		$result = $this->newsObj->get(null,null,$select);
	// 		if(isset($result)){
	// 			foreach ($result as $val) {
	// 				if ($val['cat_id'] == $cat_ids) {
	// 					$this->newsObj->where('cat_id',$cat_ids);
	// 					$result = $this->newsObj->delete();
	// 				}else {
	// 					$str_cat = str_replace($cat_ids, ",", $val['cat_id']);
	// 					$this->newsObj->where($getLangAndID['field_id'],$val['id']);
	// 					$result = $this->newsObj->update(array('cat_id'=>$str_cat));
	// 				}
	// 			}
	// 		}
	// 		if ($result) {
	// 			return true;
	// 		}
	// 	}		
	// }
	protected function fixNewsID($data,$id,$action){
		global $_B;
		$lang_user = explode(',',$_B['cf']['lang_use']);
		foreach ($lang_user as $k => $v) {
			if ($v!='vi') {
				$this->newsObj = new Model($v.'_news');
				$this->newsObj->where('id_lang',$id);
				$this->newsObj->where('idw',$this->idw);
				if ($action=='update') {
					$result = $this->newsObj->update($data);	
				}else if($action=='delete'){
					$result = $this->newsObj->delete();	
				}
			}
		}
		if ($result) {
			return true;
		}
	}
	protected function checkExist($id,$lang){
		$this->catNewObj = new Model($lang.'_category');
		$this->catNewObj->where('id_lang',$id);
		$this->catNewObj->where('idw',$this->idw);
		$result = $this->catNewObj->num_rows();
		if ($result) {
			return true;
		}
		return false;
	}
	protected function checkExistNews($id,$lang){
		$this->newsObj = new Model($lang.'_news');
		$this->newsObj->where('id_lang',$id);
		$this->newsObj->where('idw',$this->idw);
		$result = $this->newsObj->num_rows();
		if ($result) {
			return true;
		}
		return false;
	}
	protected function checkExistRelated($id,$news_id){
		$this->newsObj = new Model('news_same_category');
		$this->newsObj = new Model('news_related');
		$this->newsObj->where('news_id',$id);
		$this->newsObj->where('idw',$this->idw);
		$result = $this->newsObj->num_rows();
		if ($result) {
			return true;
		}
		return false;
	}
	public function getCatSearch(){
		$id = $this->r->get_int('id', 'GET');
		$getLangAndID = getLangAndID();
		$this->catNewObj = new Model($getLangAndID['lang'].'_category');
		$select = array('id','id_lang','title','parent_id','status','sort');
		$this->catNewObj->where('idw',$this->idw);
		$this->catNewObj->orderBy('sort','ASC');
		$data = $this->catNewObj->get(null,null,$select);
		if ($getLangAndID['lang']!='vi') {
			foreach ($data as $k => $v) {
				$v['id'] = $v['id_lang'];
				$data[$k] = $v;
			}
		}
		$result = $this->fix_tree_category($data);
		if ($result) {
			return $result;
		}
	}
	public function fix_tree_category($data=array(), $parent=0, $line='', $str_id='', $trees=array()){
		$result = array();
		if(sizeof($data) > 0){
			foreach($data as $k => $v){
				if($v['parent_id'] == $parent){
					$result[] = $v;
					unset($data[$k]);
				}
			}
		}
		if(sizeof($result)>0){
			foreach($result as $k => $v){
				$trees[] = $v;
				$i = count($trees)-1;
				$trees[$i]['line'] = $line;
				$trees[$i]['str_id'] = $str_id;
				$trees = $this->fix_tree_category($data, $v['id'], $line.'--', $str_id.$v['id'].'|', $trees);									
			}						
		}
		return $trees;
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