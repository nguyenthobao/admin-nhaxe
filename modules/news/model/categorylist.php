<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/categorylist.php 
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/21/2014, 14:31 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class CategoryList extends GlobalNews{
	public $idw,$catNewObj,$r,$lang,$result_id,$_id,$_lang;
	public function __construct(){
		global $_B;	 
		$this->r         = $_B['r'];
		$this->idw       = $_B['web']['idw'];
		$this->lang      = $_B['cf']['lang'];
		$this->result_id = "";
		$getLangAndID    = getLangAndID();
		$this->_getId    = $getLangAndID['field_id'];
		$this->_getLang  = $getLangAndID['lang'];
		$this->catNewObj = new Model($getLangAndID['lang'].'_category');
		$this->ids       = new ArrayObject();
	}
	public function activeStatusCategory(){
		$getLangAndID = getLangAndID();
		$this->catNewObj = new Model($getLangAndID['lang'].'_category');
		$status = $this->r->get_string('status','POST');
		$id = $this->r->get_int('key','POST');
		$update = array('status'=>$status,'update_time'=>time());
		$this->catNewObj->where($getLangAndID['field_id'],$id);

		$this->catNewObj->where('idw',$this->idw);
		$result = $this->catNewObj->update($update);
		//$this->updateStatusNews($id, $status);
	}
	// public function updateStatusNews($id, $status){
	// 	$getLangAndID = getLangAndID();
	// 	$this->catNewObj = new Model($getLangAndID['lang'].'_news');
	// 	$this->catNewObj->where('cat_id','%,'.$id.',%','LIKE');
	// 	$this->catNewObj->where('idw',$this->idw);
	// 	$update = array('status'=>$status,'update_time'=>time());
	// 	$result = $this->catNewObj->update($update);
	// }
	public function activeHomeCategory(){
		$getLangAndID = getLangAndID();
		$this->catNewObj = new Model($getLangAndID['lang'].'_category');
		$is_home = $this->r->get_string('is_home','POST');
		$id = $this->r->get_int('key','POST');
		$update = array('is_home'=>$is_home,'update_time'=>time());
		$this->catNewObj->where($getLangAndID['field_id'],$id);
		$this->catNewObj->where('idw',$this->idw);
		$result = $this->catNewObj->update($update);
	}
	public function editTitleCategory(){
		$id = 	$this->r->get_int('pk','POST');
		$title = strip_tags($this->r->get_string('value','POST'));
		//Cắt bỏ chuỗi -- đằng trước của danh mục.
		if (!empty($title))
		{
			$rule="/([^-+\s]).+$/";
			preg_match($rule, $title, $pr_title);
			$getLangAndID = getLangAndID();
			$this->catNewObj = new Model($getLangAndID['lang'].'_category');
			$this->catNewObj->where($getLangAndID['field_id'],$id);
			$this->catNewObj->where('idw',$this->idw);
			$result = $this->catNewObj->update(array('title'=>$pr_title[0],'update_time'=>time()));
		}
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
	
	public function copyCategory($flag = false){
		//Mặc định ban đầu sẽ phải copy tiếng việt 
		$idCopy = array();
		if ($flag==false) {
			$this->_lang = 'vi';
			$this->_id   = 'id';
			$this->newsId      = new stdClass;
		}else{
			$this->_lang = $this->_getLang;
			$this->_id   = $this->_getId;
			$this->newsIdLang   = new stdClass;
		}
		$this->catNewObj = new Model($this->_lang.'_category');
		$ids = $this->r->get_array('name_id','POST');
		if ($ids) {
			$this->catNewObj->where($this->_id,$ids,'IN');
			$this->catNewObj->where('parent_id',$ids,'NOT IN');
			$this->catNewObj->where('idw',$this->idw);
			$data = $this->catNewObj->get(null,null,'*');
			$this->copyChildCategory($data);
		}
		foreach ($this->ids as $k=>$v) {
			unset($v['data']['id']);
			$timeCopy = date('H:i:s d-m');
			$v['data']['title'] .= ' - Copy - '.$timeCopy;
			$v['data']['status'] = 0;
			$idCopy[$v['id']] = $v;
		}
		usort($idCopy, function($a, $b) {
		    return $a['parent_id'] - $b['parent_id'];
		});
		
		foreach ($idCopy as $id => $result) {
			if ($result['parent_id']!= 0) {
				if(isset($this->newsId->{$result['parent_id']})){
					$result['data']['parent_id'] = $this->newsId->{$result['parent_id']};
				}
			}
			if ($flag==true) {
				$result['data']['id_lang'] = $this->newsId->{$result['id']};
			}
			$latest_id = $this->catNewObj->insert($result['data']);
			if ($flag == true) {
				$this->newsIdLang->{$result['id']} = $latest_id;
			}else{
				$this->newsId->{$result['id']} = $latest_id;
			}
		}
		unset($idCopy);
		//Kiểm tra xem ngôn ngữ muốn copy nếu không phải tiếng việt thì copy thêm
		if ($this->_getLang != 'vi' && $flag == false) {
			$this->copyCategory(true);
		}
		    		
	$r['status'] = true;
		return $r;
	}
	
	public function copyChildCategory($data=array(),$parent_id=0)
	{
		//$this->catNewObj = new Model($this->_lang.'_category');
		$current = array();
		if (sizeof($data) > 0) {
			foreach ($data as $k=>$v) {
				// echo "<pre>";
				// echo $this->_id;
				// echo $v[$this->_id];
				// echo "</pre>";
				$this->ids->append(array('id'=>$v[$this->_id],'parent_id'=>$parent_id,'data'=>$v));
				$this->catNewObj->where('parent_id',$v[$this->_id]);
				$this->catNewObj->where('idw',$this->idw);
				$current = $this->catNewObj->get(null,null,'*');
				$this->copyChildCategory($current,$v[$this->_id]);
			}
		}
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
		$multi = false;
		if (!isset($id)) {
			$id = 	$this->r->get_int('key','POST');
			$multi = true;
		}
		$this->result_id .=$id.",";
		$getLangAndID = getLangAndID();
		// var_dump($getLangAndID['lang']);
		// exit();
		$this->catNewObj = new Model($getLangAndID['lang'].'_category');
		if ($getLangAndID['lang']=='vi') {
			$this->catNewObj->where('id',$id);
			$this->catNewObj->where('idw',$this->idw);
			$this->catNewObj->delete();
			//function fixParentCat($data,$id,$action)
			//@param1 : mảng truyền vào xử lý
			//@param2: id
			//@param3: action truyền vào để xử lý theo yêu cầu. VD: delete,update
			$this->fixParentCat(null,$id,'delete'); // Hàm Check Xóa bản ghi tương ứng ở bảng khác Vi
			$this->deleteNewsCat(null,$id,'delete');
			//$this->catNewObj->update(array('meta_title'=>time()));//Muốn xoá thử để không phải thêm lại dữ liệu thì dùng update
			$result = $this->getCategoryByParent($id);
		}else{
			$this->catNewObj->where($getLangAndID['field_id'],$id);
			$this->catNewObj->where('idw',$this->idw);
			$this->catNewObj->delete();
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
		$this->catNewObj->where('idw',$this->idw);
		$ids = $this->catNewObj->get(null,null,'id');
		//delete
		foreach ($ids as $k=>$v) {
			$this->result_id .=$v['id'].",";
			$this->catNewObj->where('id',(int)$v['id']);
			$this->catNewObj->where('idw',$this->idw);
			$this->catNewObj->delete();
			$this->deleteNewsCat(null,$v['id'],'delete');
			$this->getCategoryByParent($v['id']);
		}		
		return $this->result_id;
	}	
	public function ajaxCopyCategory() {
        $langData  = $this->r->get_string('langData', 'POST');
        $emptyData  = $this->r->get_int('emptyData', 'POST');

        $getLangAndID = getLangAndID();
        $this->catNewObj = new Model($getLangAndID['lang'].'_category');
        $this->catNewObj->where('idw', $this->idw);
        $data = $this->catNewObj->get();
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