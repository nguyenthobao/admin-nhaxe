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
	public $lang_use;
	public function __construct() {
		global $_B, $_DATA;
		//$this->idw         = $_B['web']['idw'];
		$this->lang_use    = $_B['cf']['lang_use'];
	}
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
		$getLangAndID = getLangAndID();
		$this->catVideoObj = new Model($getLangAndID['lang'].'_category');
		$select = array('id','id_lang','title','parent_id','status','sort');
		$this->catVideoObj->where('idw',$this->idw);
		if($id){
			if ($getLangAndID['lang']!='vi') {
			$this->catVideoObj->where('id_lang',$id,"!=");
			}else
			{
				$this->catVideoObj->where('id',$id,"!=");
			}
		}
		
		$this->catVideoObj->orderBy('sort','ASC');
		$this->catVideoObj->orderBy($this->get_lang_id(),'DESC');
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
		$getLangAndID = getLangAndID();
		$this->catVideoObj = new Model($getLangAndID['lang'].'_category');
		$select = array('id','id_lang','title','parent_id','status','sort');
		$this->catVideoObj->where('idw',$this->idw);
		//$this->catVideoObj->orderBy('id','DESC');
		$this->catVideoObj->orderBy('sort','ASC');
		$this->catVideoObj->orderBy($this->get_lang_id(),'DESC');
		$data = $this->catVideoObj->get(null,null,$select);
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
	/*public function getCatVideo(){
		$getLangAndID = getLangAndID();
		$this->catVideoObj = new Model($getLangAndID['lang'].'_video');
		$select = array('id','id_lang','img','title','status','sort');
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
	*/

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
				$current[$k]['id']= $v['id'];
				$current[$k]['title'] = $space." ".$v['title'];
				$current[$k]['sub'] = $this->getCategory($data, $v['id'], $space.'--'); 
			}	
		}
		return $current;
	} 
	public function fix_tree_category($data=array(), $parent=0, $line='', $str_id='', $trees=array()) {
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
	protected function fixVideoID($data,$id,$action){
		global $_B;
		$lang_user = explode(',',$_B['cf']['lang_use']);
		foreach ($lang_user as $k => $v) {
			if ($v!='vi') {
				$this->catVideoObj = new Model($v.'_video');
				$this->catVideoObj->where('id_lang',$id);
				$this->catVideoObj->where('idw',$this->idw);
				if ($action=='update') {
					$result = $this->catVideoObj->update($data);	
				}else if($action=='delete'){
					$result = $this->catVideoObj->delete();	
				}				
			}
		}
		if ($result) {
			return true;
		}
	}
	protected function CategoryVideoID($data,$id,$action){
		global $_B;
		$lang_user = explode(',',$_B['cf']['lang_use']);
		foreach ($lang_user as $k => $v) {
			if ($v!='vi') {
				$this->catVideoObj = new Model($v.'_category');
				$this->catVideoObj->where('id_lang',$id);
				$this->catVideoObj->where('idw',$this->idw);
				if ($action=='update') {
					$result = $this->catVideoObj->update($data);	
				}else if($action=='delete'){
					$result = $this->catVideoObj->delete();	
				}				
			}
		}
		if ($result) {
			return true;
		}
	}
	protected function checkExist($id,$lang,$page){
		$this->catVideoObj = new Model($lang.'_'.$page);
		$this->catVideoObj->where('id_lang',$id);
		$this->catVideoObj->where('idw',$this->idw);
		$result = $this->catVideoObj->num_rows();
		if ($result) {
			return true;
		}
		return false;
	}
	public function get_lang_id($lang = null) {
		if($lang == null){
			$lang = $this->lang;
		}
		if($lang == 'vi'){
			$result = 'id';
		}else{
			$result = 'id_lang';
		}
		return $result;
	}
	public function loadMoreRelated(){
		
		global $_B;
		$getLangAndID = getLangAndID();
		$this->catVideoObj = new Model($getLangAndID['lang'].'_video');
		$start = $this->r->get_int('start', 'POST');
		$id = $this->r->get_int('id','POST');
		$this->catVideoObj->where($getLangAndID['field_id'],$id);
		$this->catVideoObj->where('idw',$this->idw);
		$videoss = $this->catVideoObj->getOne();
		$related  = $videoss['related_video'];
		$select = array('id','id_lang','title','img');
		$items = explode(",",$related);
		if ($items!=null) {
			foreach ($items as $key => $value) {
				$this->catVideoObj->where($getLangAndID['field_id'],$value,'!=');
			}			
		}
		if($id){
			$this->catVideoObj->where($getLangAndID['field_id'],$id,"!=");
		}
		$this->catVideoObj->where('idw',$this->idw);
		$this->catVideoObj->where('status',1);
		$this->catVideoObj->orderBy('id','DESC');
				
		$result['data'] = $this->catVideoObj->get(null,array($start,5),$select);
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
	protected function deleteIncat($result)
	{
		global $_B;
		include(DIR_HELPER_UPLOAD);
		$upload = new BncUpload();
		$getLangAndID = getLangAndID();
		$this->catVideoObj = new Model($getLangAndID['lang'].'_video');	
		$this->catVideoObj->where('idw',$this->idw);
		foreach ($result as $key => $value) {
			if($key == 0){
			    $this->catVideoObj->where('cat_id', '%,'.$value.',%', 'like');
			   }else{
			    $this->catVideoObj->orWhere('cat_id', '%,'.$value.',%', 'like');
			   }
		}
		$select = array('id','cat_id');
		$data = $this->catVideoObj->get(null,null,$select);
		if(!empty($data))
		{
			foreach ($data as $key => $value) {
				$tn= explode(',', $value['cat_id']);
				// bỏ 2 dấu phẩy 2 đầu
				unset($tn[count($tn)-1]);
				unset($tn[0]);
				
				/*foreach ($tn as $k => $v) {
					foreach ($result as $h => $val) {
						if($v==$val)
						{
							unset($tn[$k]);
						}
					}
				}*/

				$denta = array();
				$denta= array_diff($tn,$result);
				$denta2=count($denta);
				
				if ($denta2==0) {
					if($getLangAndID['lang']=='vi')
					{
						$this->catVideoObj->where($this->get_lang_id(),$value['id']);
					}else
					{
						$this->catVideoObj->where($this->get_lang_id(),$value['id_lang']);
					}
					$this->catVideoObj->delete();
					if(!empty($v1['img_video'])){
								$upload->del($this->upload_path.$v1['img_video']);	
							}
				}else
				{
					$tmp[]=$value['id'];
				}
				/*$flag = true;
				foreach ($tn as $k => $v) {
					if(in_array($v, $result)== false){
						$flag = false;
						break;
					}
				}
				if($flag == true){
					$this->catVideoObj->where('id',$value['id']);
					$this->catVideoObj->delete();
					if(!empty($v1['img_video'])){
						$upload->del($this->upload_path.$v1['img_video']);	
					}
				}*/
			}
			if($tmp)
			{
				$this->updatecate($tmp,$result);
			}
		}

	}
	public function updatecate($tmp,$result)
	{
		global $_B;
		$getLangAndID = getLangAndID();
		$this->catVideoObj = new Model($getLangAndID['lang'].'_video');	
		$this->catVideoObj->where('idw',$this->idw);
		$this->catVideoObj->where($this->get_lang_id(),$tmp,'IN');
		$select = array('id','id_lang','cat_id');
		$data = $this->catVideoObj->get(null,null,$select);
		foreach ($data as $key => $value) {
			$tn= explode(',', $value['cat_id']);
			foreach ($result as $k => $v) {
				$khoa= array_search ($v,$tn);
				unset($tn[$khoa]);
			}
			$tmp= implode(',',$tn);
			//print_r($tmp);
			$datatmp = array(
				'cat_id'			=>$tmp,
				);
			if($getLangAndID['lang']=='vi')
			{
				$this->catVideoObj->where($this->get_lang_id(),$value['id']);
			}else
			{
				$this->catVideoObj->where($this->get_lang_id(),$value['id_lang']);
			}
			$this->catVideoObj->where('idw',$this->idw);
			$this->catVideoObj->update($datatmp);
		}
	}
	protected function kttrung($tempa,$tempb)
	{
		foreach ($tempa as $key => $value) {
			if( in_array($value, $tempb) == false)
			{
				return 1;
			}
		}
		return 2;
	}
	protected function deleteVideoIncat($id){
			$getLangAndID = getLangAndID();
			
			if($getLangAndID['lang']!='vi')
			{
				$this->catVideoObj = new Model($getLangAndID['lang'].'_video');	
				$this->catVideoObj->where('idw',$this->idw);
				$this->catVideoObj->where($getLangAndID['field_id'],$id);
				$this->catVideoObj->delete();
				if(!empty($v1['img_video'])){
							$upload->del($this->upload_path.$v1['img_video']);	
						}
		
			}else
			{
				$language = explode(',', $this->lang_use);
				if(!empty($language)){
					foreach ($language as $k => $v) {
						$this->catVideoObj = new Model($v.'_video');	
						$this->catVideoObj->where('idw',$this->idw);
						$this->catVideoObj->where($this->get_lang_id($v),$id);
						$this->catVideoObj->delete();
						//$result[]=$v;
					}
				}

			}	
			//return $result;
	
	}
	

}