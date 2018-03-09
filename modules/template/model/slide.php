<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/slide.php
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/17/2014, 10:14 AM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
class Slide extends GlobalSlide {
	public $idw, $r, $lang, $slideObj;
	private $uid;
	public function __construct() {
		global $_B;
		$this->r    = $_B['r'];
		$this->idw  = $_B['web']['idw'];
		$this->lang = $_B['cf']['lang'];
	}
	/**
	 * add config of module slide
	 */
	public function addSlide() {
		global $_B;
		$getLangAndID   = getLangAndID();
		$this->slideObj = new Model($getLangAndID['lang'] . '_slide');

		$str     = strip_tags($this->r->get_string('title', 'POST'));
		$title   = trim($str);
		$id_lang = null;
		if ($getLangAndID['lang'] != 'vi') {
			$id_lang = $this->r->get_int('id');
		}
		$active_mod = $this->r->get_array('active_mod', 'POST');
		$active_mod = ',' . implode(',', $active_mod) . ',';

		$data = array(
			'idw'              => $this->idw,
			'id_lang'          => $id_lang,
			'title'            => $title,
			'description'      => $this->r->get_string('description', 'POST'),
			'position'         => $this->r->get_string('position', 'POST'),
			'create_uid'       => $_B['uid'],
			'sort'             => $this->r->get_int('sort', 'POST'),
			'create_time'      => time(),
			'meta_title'       => $this->r->get_string('meta_title', 'POST'),
			'meta_keywords'    => $this->r->get_string('meta_keywords', 'POST'),
			'meta_description' => $this->r->get_string('meta_description', 'POST'),
			'status'           => $this->r->get_int('status', 'POST'),
			'active_mod'       => $active_mod,
		);

		//Kiểm tra xem nếu tồn tại id thì update, nếu không thì insert
		$id = $this->r->get_int('id', 'GET');

		if (!empty($id)) {
			$data = array(
				'idw'              => $this->idw,
				'id_lang'          => $id_lang,
				'title'            => $title,
				'description'      => $this->r->get_string('description', 'POST'),
				'position'         => $this->r->get_string('position', 'POST'),
				'update_uid'       => $_B['uid'],
				'sort'             => $this->r->get_int('sort', 'POST'),
				'create_time'      => time(),
				'meta_title'       => $this->r->get_string('meta_title', 'POST'),
				'meta_keywords'    => $this->r->get_string('meta_keywords', 'POST'),
				'meta_description' => $this->r->get_string('meta_description', 'POST'),
				'status'           => $this->r->get_int('status', 'POST'),
				'active_mod'       => $active_mod,
			);
			$this->slideObj->where($getLangAndID['field_id'], $id);
			$this->slideObj->where('idw', $this->idw);
			$result = $this->slideObj->update($data);

			if ($getLangAndID['lang'] == 'vi') {
				//Update lại parent_id nếu sửa bản ghi tiếng việt
				$data = array(
					'id_lang' => $id,
				);
				//function fixParentCat($data,$id,$action)
				//@param1 : mảng truyền vào xử lý
				//@param2: id
				//@param3: action truyền vào để xử lý theo yêu cầu. VD: delete,update
				$this->fixSlideID($data, $id, 'update');
			} else {
				//Kiểm tra xem bản ghi đã tồn tại bên ngôn ngữ này chưa.
				//True : update
				//false: insert
				$checkExistSlide = $this->checkExistSlide($id, $getLangAndID['lang']);
				if ($checkExistSlide == true) {
					$this->slideObj->where($getLangAndID['field_id'], $id);
					$this->slideObj->where('idw', $this->idw);
					$result = $this->slideObj->update($data);
				} else {
					$result = $this->slideObj->insert($data);
				}
			}
		} else {
			$result = $this->slideObj->insert($data);
		}
		if (!empty($id)) {
			$return['last_id'] = $id;
		} else {
			$return['last_id'] = $result;
		}
		if ($result) {
			$return['status'] = true;
		} else {
			$return['status'] = false;
			$return['error']  = $this->slideObj->getLastError();
		}
		return $return;
	}
	//get SlideID
	public function getSlideID() {
		$id             = $this->r->get_int('id', 'get');
		$lang           = $_GET['lang'];
		$this->slideObj = new Model($lang . '_slide');
		if ($lang != 'vi') {
			$this->slideObj->where('id_lang', $id);
		} else {
			$this->slideObj->where('id', $id);
		}
		$this->slideObj->where('idw', $this->idw);
		$result = $this->slideObj->getOne();
		if ($lang != 'vi') {
			$result['id'] = $result['id_lang'];
		}
		return $result;
	}

}