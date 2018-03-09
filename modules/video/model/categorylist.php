<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/categorylist.php 
 * @Author HMH (hungdct1083@gmail.com)
 * @Createdate 08/21/2014, 14:31 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class CategoryList extends GlobalVideo{
	public $idw,$catVideoObj,$r,$lang,$cMulti = array(),$resulid= array();
	public function __construct(){
			global $_B;	 
			$this->r = $_B['r'];
			$this->idw = $_B['web']['idw'];
			$this->lang = $_B['cf']['lang'];
			$this->lang_use = $_B['cf']['lang_use'];
			$this->ids       = new ArrayObject();
	}
	public function activeStatusCategory(){
		global $_B;
			$getLangAndID = getLangAndID();
			$this->catVideoObj = new Model($getLangAndID['lang'].'_category');
			$status = $this->r->get_string('status','POST');
			$id = $this->r->get_int('key','POST');
			$update = array('status'=>$status,'update_time'=>time());
			$this->catVideoObj->where($getLangAndID['field_id'],$id);
			$this->catVideoObj->where('idw',$this->idw);
			$result = $this->catVideoObj->update($update);
	}
	public function deleteCategory(){
			//$lang = $this->getLangAndID();
			$id = $this->r->get_int('key','POST');	
			$result = $this->deleteChung($id);
			$this->deleteIncat($result);
			echo implode(",", $result);
	}
	public function deleteCategoryMulti(){
		global $_B;
		//include(DIR_HELPER_UPLOAD);
		//$upload = new BncUpload();
		$getLangAndID = getLangAndID();
		$this->catVideoObj = new Model($getLangAndID['lang'].'_category');
		$daiid= $this->r->get_array('key','POST');
		//print_r($daiid);
		if(!empty($daiid)){
			foreach($daiid as $k=>$v){
				//$cMulti[]=$v;
				$result=array();

				//$this->catVideoObj->where('idw',$this->idw);
		     	//$this->catVideoObj->where($getLangAndID['field_id'],$v);
				//$select = array('id,id_lang,title,img,bg,icon');
				//$tmp = $this->catVideoObj->getOne(null,$select);
				//$del = $upload->del(array($tmp['img'],$tmp['bg'],$tmp['icon']));	
			//	print_r($tmp);

				$this->catVideoObj->where('idw',$this->idw);
				$this->catVideoObj->where($getLangAndID['field_id'],$v);
				$this->catVideoObj->delete();
				if($getLangAndID['lang']=='vi')
				{
					$result = $this->deleteChung($v);
					if(!empty($result))
					{
						foreach ($result as $key => $value) {
							$cMulti[]=$value;
						}
					}
				}
			}
			$this->deleteIncat($cMulti);
			echo implode(",", $cMulti) ;
		}
	
	}
	public function fix_tree($data=array(), $parent=0, $line='', $trees=array()) {
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
				$trees = $this->fix_tree($data, $v['id'], $line.'--', $trees);									
			}						
		}
		return $trees;
	}
	public function deleteChung($id)
	{
			global $_B;
		//	include(DIR_HELPER_UPLOAD);
		//	$upload = new BncUpload();
			$getLangAndID = getLangAndID();
			$this->catVideoObj = new Model($getLangAndID['lang'].'_category');
			$result[]=$id;
			$select = array('id','parent_id');
			$this->catVideoObj->where('idw',$this->idw);
			$data = $this->catVideoObj->get(null,null,$select);
			$tmp2 = $this->fix_tree($data,$id);	
			if($getLangAndID['lang']!='vi')
			{
				//$this->catVideoObj->where('idw',$this->idw);
				//$this->catVideoObj->where($getLangAndID['field_id'],$id);
				//$select = array('id,id_lang,title,img,bg,icon');
				//$tmp = $this->catVideoObj->getOne(null,$select);
				//print_r($tmp);
				//$del = $upload->del(array($tmp['img'],$tmp['bg'],$tmp['icon']));

				$this->catVideoObj->where('idw',$this->idw);
				$this->catVideoObj->where($getLangAndID['field_id'],$id);
				$this->catVideoObj->delete();
				$this->deleteIncat($id);
						
				if(!empty($tmp2))
				{
					foreach ($tmp2 as $key => $value) {
						$result[]=$value['id_lang'];
					}
				}

			}else
			{		
				if(!empty($tmp2))
				{
					foreach ($tmp2 as $key => $value) {
						$result[]=$value['id'];
					}
				}
				$language = explode(',', $this->lang_use);
				if(!empty($language)){
					foreach ($language as $k => $v) {
						$videocon = new Model($v.'_category');
						$videocon->where('idw',$this->idw);
						$videocon->where($this->get_lang_id(),$result,'in');
						$videocon->delete();
					}
				}
				
				
			}

			
			return $result;
	}
	
	public function deleteCategoryLang($id='')
	{
		$language= explode(',', $this->lang_use);
		if(!empty($language)){
			foreach ($language as $key => $value) {
				$this->catVideoObj = new Model($value.'_category');	
				$this->catVideoObj->where('idw',$this->idw);
				$this->catVideoObj->where($this->get_lang_id($value),$id);
				$this->catVideoObj->delete();
			}
		}
	}
	public function deleteCategoryMulti2(){
		global $_B;
		$getLangAndID = getLangAndID();
		$this->catVideoObj = new Model($getLangAndID['lang'].'_category');
		$daiid= $this->r->get_array('key','POST');
		if(!empty($daiid)){
			if($getLangAndID['lang']!='vi'){
				foreach($daiid as $k=>$v){
					$this->catVideoObj->where($getLangAndID['field_id'],$v);
					$this->catVideoObj->where('idw',$this->idw);
					$this->catVideoObj->delete();
					$Multi[]=$this->getCategoryByParent($v);
					$Multi2[]=$v;
				}			
			}else{
				foreach($daiid as $key=>$value){
					$language = explode(',', $this->lang_use);
					if(!empty($language)){
						foreach ($language as $k => $v) {
							$this->catVideoObj = new Model($v.'_category');	
							$this->catVideoObj->where('idw',$this->idw);
							$this->catVideoObj->where($this->get_lang_id($v),$value);
							$this->catVideoObj->delete();						
							}
					}
					$Multi[]=$this->getCategoryByParent($v);
					$Multi2[]=$v;
				}
			}
			$cMulti=array_merge($Multi,$Multi2);
			echo implode(",", $cMulti) ;

		}
	
	}

	protected function getCategoryByParent($parent_id) {
		$ids = array();
		$lang = (empty($this->lang))?'vi':$this->lang;
		$this->catVideoObj = new Model($lang.'_category');
		//get ids
		$this->catVideoObj->where('parent_id',$parent_id);
		$this->catVideoObj->where('idw',$this->idw);
		$ids = $this->catVideoObj->get(null,null,'id');
		//delete
		
		foreach ($ids as $k=>$v) {
			$resulid[]=$v['id'];
			$this->catVideoObj->where('id',(int)$v['id']);
			$this->catVideoObj->where('idw',$this->idw);
			$this->catVideoObj->delete();
			//$this->catVideoObj->update(array('meta_title'=>time()));//Muốn xoá thử để không phải thêm lại dữ liệu thì dùng update
			$this->getCategoryByParent($v['id']);
		}
		return $resulid;
	}	
	public function editTitleCategory(){
			$id = 	$this->r->get_int('pk','POST');
			$title = $this->r->get_string('value','POST');
			$title =preg_replace('/\s\s+/', ' ', trim($title));
			//Cắt bỏ chuỗi -- đằng trước của danh mục.
			$rule="/([^-+\s]).+$/";
			preg_match($rule, $title, $pr_title);
			$getLangAndID = getLangAndID();
			$this->catVideoObj = new Model($getLangAndID['lang'].'_category');
			$this->catVideoObj->where($getLangAndID['field_id'],$id);
			$this->catVideoObj->where('idw',$this->idw);
			$result = $this->catVideoObj->update(array('title'=>$pr_title[0],'update_time'=>time()));
	}

	public function editSortCategory(){
		$id = 	$this->r->get_int('pk','POST');
		$sort = $this->r->get_int('value','POST');
		$getLangAndID = getLangAndID();
		$this->catVideoObj = new Model($getLangAndID['lang'].'_category');
		$this->catVideoObj->where($getLangAndID['field_id'],$id);
		$this->catVideoObj->where('idw',$this->idw);
		$result = $this->catVideoObj->update(array('sort'=>$sort,'update_time'=>time()));
	}

	public function copyCategory(){
		global $_B;
		$getLangAndID = getLangAndID();
		$this->catVideoObj = new Model($getLangAndID['lang'].'_category');
		$daiid= $this->r->get_array('key','POST');
		//print_r($daiid);
		if ($daiid) {
			$this->catVideoObj->where($getLangAndID['field_id'],$daiid,'IN');
			$this->catVideoObj->where('parent_id',$daiid,'NOT IN');
			$this->catVideoObj->where('idw',$this->idw);
			$data = $this->catVideoObj->get(null,null,'*');
			//print_r($data);
			foreach ($data as $key => $value) {
				$timeCopy = date('H:i:s d-m');
				$value['title'] .= ' - Copy - '.$timeCopy;
				$imp = array(
					'title' => $value['title'],
					'idw'				=>$this->idw,
					'status'			=>$value['status'],
					'parent_id'			=>$value['parent_id'],
					'create_uid'		=>$_B['uid'],
					'create_time'		=>time(),
					);
				$latest_id = $this->catVideoObj->insert($imp);
				//$this->copyChildCategory($latest_id);
				$select = array('id','parent_id','status');
				$this->catVideoObj->where('idw',$this->idw);
				$data2 = $this->catVideoObj->get(null,null,$select);
				$tmp2 = $this->fix_tree($data2,$value['id']);
			//	print_r($tmp2);
				$this->copyChildCategory($tmp2,$latest_id);

			}
		}
		
		
	}
	
	public function copyChildCategory($data=array(),$parent_id=0)
	{
		global $_B;
		$dai = array();
		$datacopy = array();
		$getLangAndID = getLangAndID();
		$this->catVideoObj = new Model($getLangAndID['lang'].'_category');
		foreach ($data as $key => $value) {
			$dai[]= $value['id'];
		}
		if ($dai) {
			$this->catVideoObj->where($getLangAndID['field_id'],$dai,'IN');
			$this->catVideoObj->where('idw',$this->idw);
			$datacopy = $this->catVideoObj->get();
		}
		foreach ($datacopy as $key => $value) {
				$tmp2= array();
				$timeCopy = date('H:i:s d-m');
				$value['title'] .= ' - Copy - '.$timeCopy;
				$imp = array(
					'title' => $value['title'],
					'idw'				=>$this->idw,
					'status'			=>$value['status'],
					'parent_id'			=>$parent_id,
					'create_uid'		=>$_B['uid'],
					'create_time'		=>time(),
					);
				//print_r($imp);
				$latest_id = $this->catVideoObj->insert($imp);
				//$this->copyChildCategory($latest_id);
				
				$select = array('id','parent_id');
				$this->catVideoObj->where('idw',$this->idw);
				$data2 = $this->catVideoObj->get(null,null,$select);
				$tmp2 = $this->fix_tree($data2,$value['id']);
				$this->copyChildCategory($tmp2,$latest_id);
			}
	}

	public function ajaxCopyCategory() {
        $langData  = $this->r->get_string('langData', 'POST');
        $emptyData  = $this->r->get_int('emptyData', 'POST');

        $getLangAndID = getLangAndID();
        $this->catVideoObj = new Model($getLangAndID['lang'].'_category');
        $this->catVideoObj->where('idw', $this->idw);
        $data = $this->catVideoObj->get();
        // echo $data;
        // exit();
        //Kiểm tra làm rỗng
        if ($emptyData == 1) {
            $this->emptyCategory($langData);
        } 
        //Đệ quy install
        if(!empty($data)){
        	$insl = $this->copyCategoryLang($data,$langData); 
    	}
 		echo "Sao chép thành công";
	}

	public function copyCategoryLang($data, $langData) { 
				$catVideoObj = new Model($langData.'_category');
		        foreach ($data as $k => $v) {
		            $data_insert = $v;
		            unset($data_insert['id']);
		            if ($v['id_lang'] == null) {
		                $data_insert['id_lang'] = $v['id'];
		            }
		            
		            $idcp= $catVideoObj->insert($data_insert);
		            
		        }
		  		return true;
		 }
	private function emptyCategory($langData) {

		        $this->catVideoObj = new Model($langData.'_category');
		        if($this->idw){
		        	$this->catVideoObj->where('idw', $this->idw);
		        	return $this->catVideoObj->delete();
		        }	        	
	}

}