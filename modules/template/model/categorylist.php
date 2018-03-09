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

class CategoryList extends GlobalNews{
	public $idw,$catNewObj,$r,$lang,$result_id; 
	public function __construct(){
			global $_B;	 
			$this->r = $_B['r'];
			$this->idw = $_B['web']['idw'];
			$this->lang = $_B['cf']['lang'];
			$this->result_id = "";
	}
	public function activeStatusCategory(){
		global $_B;
			$getLangAndID = getLangAndID();
			$this->catNewObj = new Model($getLangAndID['lang'].'_category');
			$status = $this->r->get_string('status','POST');
			$id = $this->r->get_int('key','POST');
			$update = array('status'=>$status,'update_time'=>time());
			$this->catNewObj->where($getLangAndID['field_id'],$id);
			$this->catNewObj->where('idw',$this->idw);
			$result = $this->catNewObj->update($update);
	}
	public function editTitleCategory(){
			$id = 	$this->r->get_int('pk','POST');
			$title = $this->r->get_string('value','POST');
			//Cắt bỏ chuỗi -- đằng trước của danh mục.
			$rule="/([^-+\s]).+$/";
			preg_match($rule, $title, $pr_title);
			$getLangAndID = getLangAndID();
			$this->catNewObj = new Model($getLangAndID['lang'].'_category');
			$this->catNewObj->where($getLangAndID['field_id'],$id);
			$this->catNewObj->where('idw',$this->idw);
			$result = $this->catNewObj->update(array('title'=>$pr_title[0],'update_time'=>time()));
	}

	public function editSortCategory(){
		$id = 	$this->r->get_int('pk','POST');
		$sort = $this->r->get_int('value','POST');
		$getLangAndID = getLangAndID();
		$this->catNewObj = new Model($getLangAndID['lang'].'_category');
		$this->catNewObj->where($getLangAndID['field_id'],$id);
		$this->catNewObj->where('idw',$this->idw);
		$result = $this->catNewObj->update(array('sort'=>$sort,'update_time'=>time()));
	}
	public function deleteMultiID(){
		$ids = $this->r->get_array('name_id','POST');
		foreach($ids as $k=>$v){
			$this->deleteCategory($v);
		}
		$r['status'] = true;
		return $r;
	}
	public function deleteCategory($id=null){
		//$lang = (empty($this->lang))?'vi':$this->lang;
		$multi = false;
		if (!isset($id)) {
			$id = 	$this->r->get_int('key','POST');
			$multi = true;
		}
		$this->result_id .=$id.",";
		$getLangAndID = getLangAndID();
		$this->catNewObj = new Model($getLangAndID['lang'].'_category');
		if ($getLangAndID['lang']=='vi') {
			$this->catNewObj->where('id',$id);
			$this->catNewObj->where('idw',$this->idw);
			$this->catNewObj->delete();
			//function fixParentCat($data,$id,$action)
			//@param1 : mảng truyền vào xử lý
			//@param2: id
			//@param3: action truyền vào để xử lý theo yêu cầu. VD: delete,update
			$this->fixParentCat(null,$id,'delete');
			//$this->catNewObj->update(array('meta_title'=>time()));//Muốn xoá thử để không phải thêm lại dữ liệu thì dùng update
			$result = $this->getCategoryByParent($id);	
		}else{
			$this->catNewObj->where($getLangAndID['field_id'],$id);
		}
		if ($multi==true) {
			//Nếu là xoá 1 bản ghi qua ajax thì mới trả về dãy mảng.
			echo $this->result_id;
		}
	}

	protected function getCategoryByParent($parent_id) {
		$ids = array();
		$lang = (empty($this->lang))?'vi':$this->lang;
		$this->catNewObj = new Model($lang.'_category');
		//get ids
		$this->catNewObj->where('parent_id',$parent_id);
		$this->catNewObj->where('idw',1);
		$ids = $this->catNewObj->get(null,null,'id');
		//delete
		foreach ($ids as $k=>$v) {
			$this->result_id .=$v['id'].",";
			$this->catNewObj->where('id',(int)$v['id']);
			$this->catNewObj->where('idw',$this->idw);
			$this->catNewObj->delete();
			//$this->catNewObj->update(array('meta_title'=>time()));//Muốn xoá thử để không phải thêm lại dữ liệu thì dùng update
			$this->getCategoryByParent($v['id']);
		}
		return $this->result_id;
	}	

}