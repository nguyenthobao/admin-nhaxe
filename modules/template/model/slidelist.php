<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/slidelist.php
 * @Author An Nguyen Huu(annh@webbnc.vn)
 * @Createdate 08/21/2014, 14:31 PM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

class SlideList extends GlobalSlide {
	public $idw, $r, $lang, $result_id, $slideObj;
	public function __construct() {
		global $_B;
		$this->r         = $_B['r'];
		$this->idw       = $_B['web']['idw'];
		$this->lang      = $_B['cf']['lang'];
		$this->result_id = "";
	}
	public function activeStatusSlide() {
		//global $_B;
		$getLangAndID   = getLangAndID();
		$this->slideObj = new Model($getLangAndID['lang'] . '_slide');
		$status         = $this->r->get_string('status', 'POST');
		$id             = $this->r->get_int('key', 'POST');
		$update         = array('status' => $status, 'update_time' => time());
		$this->slideObj->where($getLangAndID['field_id'], $id);
		$this->slideObj->where('idw', $this->idw);
		$result = $this->slideObj->update($update);
	}
	public function editTitleSlide() {
		$id    = $this->r->get_int('pk', 'POST');
		$title = $this->r->get_string('value', 'POST');
		//Cắt bỏ chuỗi -- đằng trước của danh mục.
		$rule = "/([^-+\s]).+$/";
		if (!empty($title)) {
			// preg_match($rule, $title, $pr_title);
			$getLangAndID   = getLangAndID();
			$this->slideObj = new Model($getLangAndID['lang'] . '_slide');
			$this->slideObj->where($getLangAndID['field_id'], $id);
			$this->slideObj->where('idw', $this->idw);
			$result = $this->slideObj->update(array('title' => $title, 'update_time' => time()));
		}
	}
	public function editSortSlide() {
		$id             = $this->r->get_int('pk', 'POST');
		$sort           = $this->r->get_int('value', 'POST');
		$getLangAndID   = getLangAndID();
		$this->slideObj = new Model($getLangAndID['lang'] . '_slide');
		$this->slideObj->where($getLangAndID['field_id'], $id);
		$this->slideObj->where('idw', $this->idw);
		$result = $this->slideObj->update(array('sort' => $sort, 'update_time' => time()));
	}
	public function editSlidePosition() {
		$id             = $this->r->get_int('pk', 'POST');
		$position       = $this->r->get_int('value', 'POST');
		$getLangAndID   = getLangAndID();
		$this->slideObj = new Model($getLangAndID['lang'] . '_slide');
		$this->slideObj->where($getLangAndID['field_id'], $id);
		$this->slideObj->where('idw', $this->idw);
		$result = $this->slideObj->update(array('position' => $position, 'update_time' => time()));
	}
	public function deleteMultiID() {
		$ids = $this->r->get_array('name_id', 'POST');
		foreach ($ids as $k => $v) {
			$this->deleteSlide($v);
		}
		$r['status'] = true;
		return $r;
	}
	public function deleteSlide($id = null) {
		$multi = false;
		if (!isset($id)) {
			$id    = $this->r->get_int('key', 'POST');
			$multi = true;
		}
		$this->result_id .= $id . ",";
		$getLangAndID   = getLangAndID();
		$this->slideObj = new Model($getLangAndID['lang'] . '_slide');
		$this->slideObj->where($getLangAndID['field_id'], $id);
		$this->slideObj->where('idw', $this->idw);
		$this->slideObj->delete();
		$this->deleteImageSlide($id);
	}
	public function deleteImageSlide($id) {
		$getLangAndID   = getLangAndID();
		$this->slideObj = new Model($getLangAndID['lang'] . '_slide_image');
		$this->slideObj->where('slide_id', $id);
		$this->slideObj->where('idw', $this->idw);
		$this->slideObj->delete();
	}
}