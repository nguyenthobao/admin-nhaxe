<?php
/**
 * @Project BNC v2 -> Admin -> Album
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 */

/**
 * Album
 */
class Album {
	protected $B;
	public $idw;
	public $r;
	public $lang;
	protected $getLangAndID;
	public $objTable;
	private $uid;
	public $arr = array();
	public $id;
	public $cleaner;

	function __construct() {
		global $_B;
		$this->B            = $_B;
		$this->idw          = $this->B['web']['idw'];
		$this->r            = $this->B['r'];
		$this->lang         = $this->B['cf']['lang'];
		$this->getLangAndID = getLangAndID();
		$this->dbConnect    = db_connect('album');
	}

	/*
	 * kiem tra trang thai danh muc
	 */
	public function checkCateStatusHide($id) {
		$db             = db_connect('album');
		$this->objTable = new Model($this->getLangAndID['lang'] . '_album_category', $db);
		$select         = array('id');
		$this->objTable->where('idw', $this->idw);
		$this->objTable->where('status', 0);
		$this->objTable->where('id', $id, 'IN');

		$total = $this->objTable->num_rows();
		return $total;
	}

	/*
	 * an boi danh muc
	 */
	public function hideByCate($id, $act = 0) {
		$db             = db_connect('album');
		$this->objTable = new Model($this->getLangAndID['lang'] . '_album', $db);
		$i              = '1';
		if ($act) {
			$i = '0';
		}

		$data = array(
			'hide_by_cate' => $i,
		);
		$this->objTable->where('idw', $this->idw);
		$this->objTable->where('category_id', "%," . $id . ",%", 'LIKE');
		$this->objTable->update($data);
	}

	/*
	 * cap nhat id album cho anh
	 */
	public function updateAvatar($avatar_id, $id_album) {
		$db             = db_connect('album');
		$this->objTable = new Model($this->getLangAndID['lang'] . '_album_images', $db);
		$data           = array(
			'avatar' => 0,
		);
		$this->objTable->where('idw', $this->idw);
		$this->objTable->where('album_id', $id_album);
		$this->objTable->update($data);
		//
		$this->objTable = new Model($this->getLangAndID['lang'] . '_album_images', $db);
		$data           = array(
			'avatar' => 1,
		);
		$this->objTable->where('idw', $this->idw);
		$this->objTable->where('id', $avatar_id);
		$this->objTable->update($data);

	}

	/**
	 * get all subcategories
	 *
	 * @param $id|int
	 *
	 * @return null
	 *
	 */
	public function getChildCate($id) {
		$db             = db_connect('album');
		$this->objTable = new Model($this->getLangAndID['lang'] . '_album_category', $db);
		$select         = array('id');
		$this->objTable->where('idw', $this->idw);
		$this->objTable->where('parent_id', $id);
		$result = $this->objTable->get(null, null, $select);
		if (is_array($result)) {
			foreach ($result as $k => $v) {
				array_push($this->arr, $v['id']);
				$this->getChildCate($v['id']);
			}
		}
	}

/**
 * apply all lang album
 *
 * @param $data|array
 * @param $id|int
 * @param $action|string
 *
 * @return int
 *
 */
	protected function applyAllLang($data, $id, $action, $table = '_album') {
		$lang_user = explode(',', $this->B['cf']['lang_use']);
		foreach ($lang_user as $k => $v) {
			if ($v != $this->lang) {
				$this->objTable = new Model($v . $table);
				$this->objTable->where('id_lang', $id);
				$this->objTable->where('idw', $this->idw);
				if ($action == 'update') {
					$result = $this->objTable->update($data);
				} else if ($action == 'delete') {
					$result = $this->objTable->delete();
				}

			}
		}
		if ($result) {
			return true;
		}
	}

	public function f5Item($table) {
		$data = array(
			//'create_uid'           => $this->B['uid'],
			'update_uid'  => $this->B['uid'],
			'create_time' => $this->create_time,
		);
		$this->objTable = new Model($this->getLangAndID['lang'] . $table);
		$this->objTable->where($this->getLangAndID['field_id'], $this->id);
		$this->objTable->where('idw', $this->idw);
		$result = $this->objTable->update($data);
		$this->applyAllLang($data, $this->id, 'update', $table);
		return true;
	}

	/**
	 * delete all lang cate
	 *
	 * @param $data|array
	 * @param $id|int
	 * @param $action|string
	 *
	 * @return int
	 *
	 */
	protected function fixParentCat($data, $id, $action) {
		$lang_user = explode(',', $this->B['cf']['lang_use']);
		$db        = db_connect('album');
		foreach ($lang_user as $k => $v) {
			if ($v != $this->lang) {
				$this->objTable = new Model($v . '_album_category', $db);
				$this->objTable->where('id_lang', $id);
				$this->objTable->where('idw', $this->idw);
				if ($action == 'update') {
					$result = $this->objTable->update($data);
				} else if ($action == 'delete') {
					$result = $this->objTable->delete();
				}

			}
		}
		if ($result) {
			return true;
		}
	}

	/*
	 * kiem tra row
	 * @param $id|int
	 * @param $lang|int
	 * @param $table|string
	 */
	protected function checkExist($id, $lang, $table) {
		$this->objTable = new Model($lang . $table);
		$this->objTable->where('id_lang', $id);
		$this->objTable->where('idw', $this->idw);
		$result = $this->objTable->num_rows();
		if ($result) {
			return true;
		}
		return false;
	}

	/*
	 * kiem tra row
	 * @param $id|int
	 * @param $lang|int
	 * @param $table|string
	 */
	protected function ifExist($id, $lang, $table) {
		$this->objTable = new Model($lang . $table);
		$this->objTable->where($this->getLangAndID['field_id'], $id);
		$this->objTable->where('idw', $this->idw);
		$result = $this->objTable->num_rows();
		if ($result) {
			return true;
		}
		return false;
	}

	//get select menu cate
	public function getCatParent() {
		$this->objTable = new Model($this->getLangAndID['lang'] . '_album_category', $this->dbConnect);
		$select         = array('id', 'id_lang', 'title', 'parent_id', 'status', 'order_by');
		$this->objTable->where('idw', $this->idw);
		if ($this->id != '') {
			$this->objTable->where($this->getLangAndID['field_id'], $this->id, '<>');
		}

		$this->objTable->orderBy('id', 'DESC');
		$data = $this->objTable->get(null, null, $select);
		if ($this->getLangAndID['lang'] != $this->lang) {
			foreach ($data as $k => $v) {
				$v['id']  = $v['id_lang'];
				$data[$k] = $v;
			}
		}
		$result = $this->getCategory($data);
		if ($result) {
			return $result;
		}
	}
	protected function getCategory($data = array(), $parent = 0, $space = '') {
		$current = array();
		if (is_array($data)) {
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
				$current[$k]['space'] = $space . " ";
				$current[$k]['sub']   = $this->getCategory($data, $v['id'], $space . '--');
			}
		}
		return $current;
	}

	/*
	 * xoa anh cua danh muc
	 * @param $id|int
	 */
	public function deleteImagesCate($id) {
		$this->objTable = new Model($this->getLangAndID['lang'] . '_album_category', $this->dbConnect);
		$select         = array('avatar', 'icon', 'bg_image');
		$this->objTable->where('idw', $this->idw);
		$this->objTable->where('id', $id);
		$result = $this->objTable->getOne(null, $select);

		if ($result['avatar']) {
			$this->deleteUpload($result['avatar'], $this->idw);
		}

		if ($result['icon']) {
			$this->deleteUpload($result['icon'], $this->idw);
		}

		if ($result['bg_image']) {
			$this->deleteUpload($result['bg_image'], $this->idw);
		}

	}

	/*
	 * xoa anh cua album
	 * @param $id|int
	 */
	public function deleteImagesAlbum($id) {
		$db             = db_connect('album');
		$this->objTable = new Model($this->getLangAndID['lang'] . '_album_images', $db);
		$select         = array('id', 'id_lang', 'src_link', 'album_id');
		$this->objTable->where('idw', $this->idw);
		$this->objTable->where('album_id', $id);
		if ($this->cleaner) {
			$this->objTable->where('create_time', time() - 3600, '<=');
		}

		$result = $this->objTable->get(null, null, $select);

		foreach ($result as $k => $v) {
			$this->objTable = new Model($this->getLangAndID['lang'] . '_album_images', $db);
			$this->objTable->where('idw', $this->idw);
			$this->objTable->where('album_id', $v['album_id']);
			$this->objTable->where('id', $v['id']);
			$this->objTable->delete();
			array_push($this->arr, $v['src_link']);
		}
		if (!empty($this->arr)) {
			$this->deleteUpload($this->arr);
		}

	}

	//xoa upload
	public function deleteUpload($value) {
		include_once DIR_HELPER_UPLOAD;
		$upload = new BncUpload();
		@$upload->del($value);
	}

	/*
	 * kiem tra thoi gian dang
	 */
	public function checkPostTime($time) {
		$now       = strtotime(date('Y-m-d H:i'));
		$post_time = strtotime($time);
		if ($now > $post_time) {
			return true;
		} else {
			return false;
		}

	}

	public function getByCate($id) {
		$db             = db_connect('album');
		$select         = array('id');
		$this->objTable = new Model($this->getLangAndID['lang'] . '_album', $db);
		$this->objTable->where('idw', $this->idw);
		$this->objTable->where('category_id', "%," . $id . ",%", 'LIKE');
		$data = $this->objTable->get(null, null, $select);
		return $data;
	}

	/*
	 * xoa nhanh mot danh muc
	 */
	public function quickDeleteCate() {
		$return['ids']   = $return['success']   = false;
		$return['error'] = true;
		$db              = db_connect('album');
		$this->objTable  = new Model($this->getLangAndID['lang'] . '_album_category', $db);
		if (!empty($this->id) && is_numeric($this->id)) {
			$this->deleteImagesCate($this->id);
			$this->objTable->where($this->getLangAndID['field_id'], $this->id);
			$this->objTable->where('idw', $this->idw);
			$result = $this->objTable->delete();

			//xoa tat ca ngon ngu lien quan
			$this->fixParentCat(null, $this->id, 'delete');
			//xoa album
			$albums = $this->getByCate($this->id);
			if ($albums) {
				foreach ($albums as $v) {
					$this->deleteAlbum($v['id']);
				}
			}

			//xoa album het
			if ($result) {
				/*
				 * xoa tat ca danh muc con
				 */
				$this->getChildCate($this->id);
				if (!empty($this->arr)) {
					foreach ($this->arr as $v) {
						$this->deleteImagesCate($v);
						$this->objTable = new Model($this->getLangAndID['lang'] . '_album_category', $db);
						$this->objTable->where('id', $v);
						$this->objTable->where('idw', $this->idw);
						$this->objTable->delete();
					}
					$return['ids'] = implode(",", $this->arr);
				}

				$return['success'] = true;
				$return['error']   = false;
			} else {
				$return['success'] = false;
				$return['error']   = $this->objTable->getLastError();
			}
		}
		return $return;

	}

	public function getRelatedAjax($start = 0, $limit = 10) {
		$db             = db_connect('album');
		$this->objTable = new Model($this->getLangAndID['lang'] . '_album', $db);
		$select         = array('id', 'id_lang', 'title', 'status', 'avatar', 'avatar_id', 'category_id');

		$this->objTable->where('idw', $this->idw);
		if ($this->not_id) {
			$this->objTable->where('id', $this->not_id, '<>');
		}

		if ($this->not_in) {
			$this->objTable->where('id', $this->not_in, 'NOT IN');
		}

		$this->objTable->where($this->getLangAndID['field_id'], $this->id, '>');
		$this->objTable->orderBy($this->getLangAndID['field_id'], 'ASC');
		$data = $this->objTable->get(null, array($start, $limit), $select);

		if ($this->getLangAndID['lang'] != $this->lang) {
			foreach ($data as $k => $v) {
				$v['id']  = $v['id_lang'];
				$data[$k] = $v;
			}
		}

		if ($data) {
			return $data;
		}
	}
	public function getRelated($start = 0, $limit = 10) {
		$db             = db_connect('album');
		$this->objTable = new Model($this->getLangAndID['lang'] . '_album', $db);
		$select         = array('id', 'id_lang', 'title', 'status', 'avatar', 'avatar_id', 'category_id');
		$this->objTable->where('idw', $this->idw);
		if ($this->id) {
			$this->objTable->where('id', $this->id, '!=');
		}elseif ($this->not_in) {
			$this->objTable->where('id', $this->not_in, 'NOT IN');
		}
		
		$this->objTable->orderBy($this->getLangAndID['field_id'], 'ASC');
		$data = $this->objTable->get(null, array($start, $limit), $select);

		if ($this->getLangAndID['lang'] != $this->lang) {
			foreach ($data as $k => $v) {
				$v['id']  = $v['id_lang'];
				$data[$k] = $v;
			}
		}
		if ($data) {
			return $data;
		}
	}
	public function getRelatedItem($id) {
		$db             = db_connect('album');
		$this->objTable = new Model($this->getLangAndID['lang'] . '_album', $db);
		$select         = array('id', 'id_lang', 'title', 'status', 'avatar', 'avatar_id', 'category_id');

		$this->objTable->where($this->getLangAndID['field_id'], $id);
		$this->objTable->where('idw', $this->idw);
		$data = $this->objTable->getOne(null, $select);

		if ($this->getLangAndID['lang'] != $this->lang) {

			$data['id'] = $data['id_lang'];

		}

		if ($data) {
			return $data;
		}
	}

	public function getRelatedSearchItem($title) {
		$db = db_connect('album');
		if ($title != '') {
			$this->objTable = new Model($this->getLangAndID['lang'] . '_album', $db);
			$select         = array('id', 'id_lang', 'title', 'status', 'avatar', 'avatar_id', 'category_id');
			$this->objTable->where('idw', $this->idw);
			if ($this->id) {
				$this->objTable->where('id', $this->id, '<>');
			}

			if ($this->not_in) {
				$this->objTable->where('id', $this->not_in, 'NOT IN');
			}

			$this->objTable->where('title', "%" . $title . "%", 'LIKE');
			$data = $this->objTable->get(null, array(0, 10), $select);

			if ($this->getLangAndID['lang'] != $this->lang) {
				foreach ($data as $k => $v) {
					$v['id']  = $v['id_lang'];
					$data[$k] = $v;
				}
			}

			if ($data) {
				return $data;
			}
		}
	}

	public function deleteAlbum($id) {
		$db             = db_connect('album');
		$this->objTable = new Model($this->getLangAndID['lang'] . '_album', $db);
		$this->objTable->where($this->getLangAndID['field_id'], $id);
		$this->objTable->where('idw', $this->idw);
		$result = $this->objTable->delete();

		$this->deleteImagesAlbum($id);

		//ap dung cho tat ca ngon ngu
		$this->applyAllLang(null, $id, 'delete');

		if ($result) {
			$return['success'] = true;
			$return['error']   = false;
		} else {
			$return['success'] = false;
			$return['error']   = $this->objTable->getLastError();
		}

		return $return;
	}

	//string filter
	public function txt_string($value = '') {
		//$value=htmlspecialchars($value, ENT_QUOTES);
		$value = strip_tags($value);
		return $value;
	}

	// copy danh mục album
	public function ajaxCopyCategory() {
        $langData  = $this->r->get_string('langData', 'POST');
        $emptyData  = $this->r->get_int('emptyData', 'POST');
        $this->objTable = new Model($this->getLangAndID['lang'].'_album_category', $this->dbConnect);
        $this->objTable->where('idw', $this->idw);
        $data = $this->objTable->get();
        
        //Kiểm tra làm rỗng
        if ($emptyData == 1) {
            $this->emptyCategory($langData);
        } 

        //Đệ quy install
        if(!empty($data)){
        	$insl = $this->copyCategoryLang($data,$langData); 
    	}
 		echo "Sao chép thành công";
 		exit();
	}

	public function copyCategoryLang($data, $langData) { 
				$objTable = new Model($langData.'_album_category', $this->dbConnect);
		        foreach ($data as $k => $v) {
		            $data_insert = $v;
		            unset($data_insert['id']);
		            if ($v['id_lang'] == null) {
		                $data_insert['id_lang'] = $v['id'];
		            }
		            
		            $idcp= $objTable->insert($data_insert);
		            
		        }
		  		return true;
		 }
	private function emptyCategory($langData) {

		        $this->objTable = new Model($langData.'_album_category', $this->dbConnect);
		        if($this->idw){
		        	$this->objTable->where('idw', $this->idw);
		        	return $this->objTable->delete();
		        }	        	
		}

/*
protected function getLangAndID() {
$get_lang = $this->r->get_string('lang', 'GET');

if (!empty($get_lang)) {
if (in_array($get_lang, explode(',', $this->B['cf']['lang_use']))) {
$lang = $get_lang;
$field_id = ($get_lang == 'vi') ? 'id' : 'id_lang';
} else {
$lang = 'vi';
$field_id = 'id';
}
} else {
$lang = $this->r->get_string('lang', 'POST');
$lang = (empty($lang)) ? 'vi' : $lang;
$field_id = 'id';
}

$result['lang'] = $lang;
$result['field_id'] = $field_id;
return $result;
}
 * */

}
