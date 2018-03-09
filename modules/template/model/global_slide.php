<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/global.php
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/17/2014, 15:46 PM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
class GlobalSlide {
	//Chuyển đổi từ mảng đa chiều thành mảng 1 chiều
	public function multipleToSimpleArray($array, $newarray = array()) {
		foreach ($array as $k => $v) {
			$tmp = $v['sub'];
			unset($v['sub']);
			$newarray[] = $v;
			if (sizeof($tmp) > 0) {
				$newarray = $this->multipleToSimpleArray($tmp, $newarray);
			}
		}
		return $newarray;
	}
	public function getSlide($value = null) {
		$getLangAndID   = getLangAndID();
		$this->slideObj = new Model($getLangAndID['lang'] . '_slide');
		$this->slideObj->where('idw', $this->idw);
		$total = $this->slideObj->num_rows();

		$max    = 10;
		$maxNum = 5;

		$url  = 'template-slidelist-lang-' . $getLangAndID['lang'];
		$page = pagination($max, $total, $maxNum, $url);

		$start      = $page['start'];
		$pagination = $page['pagination'];
		$select     = '`id`,`id_lang`,`title`,`status`,`sort`,`position`,`create_time`';

		$this->slideObj->where('idw', $this->idw);
		$this->slideObj->orderBy('create_time', 'DESC');
		$result['data'] = $this->slideObj->get(null, array($start, $max), $select);

		if ($getLangAndID['lang'] != 'vi') {
			foreach ($result['data'] as $k => $v) {
				$v['id']            = $v['id_lang'];
				$result['data'][$k] = $v;
			}
		}
		if ($total > 10) {
			$result['pagination'] = $pagination;
		}
		return $result;
	}
	public function getSlideImage() {
		$id             = $this->r->get_int('id', 'GET');
		$getLangAndID   = getLangAndID();
		$this->slideObj = new Model($getLangAndID['lang'] . '_slide');
		$select         = array('id', 'id_lang', 'title');
		$this->slideObj->where('idw', $this->idw);
		$this->slideObj->orderBy('sort', 'ASC');
		$result = $this->slideObj->get(null, null, $select);
		if ($result) {
			return $result;
		}
	}
	public function getSlideByID() {
		$getLangAndID   = getLangAndID();
		$id             = $this->r->get_int('id', 'GET');
		$this->slideObj = new Model($getLangAndID['lang'] . '_slide');
		$this->slideObj->where($getLangAndID['field_id'], $id);
		$this->slideObj->where('idw', $this->idw);
		$result = $this->slideObj->getOne();
		if ($result) {
			return $result;
		}
	}
	protected function fixSlideID($data, $id, $action) {
		global $_B;
		$lang_user = explode(',', $_B['cf']['lang_use']);
		foreach ($lang_user as $k => $v) {
			if ($v != 'vi') {
				$this->slideObj = new Model($v . '_slide');
				$this->slideObj->where('id_lang', $id);
				$this->slideObj->where('idw', $this->idw);
				if ($action == 'update') {
					$result = $this->slideObj->update($data);
				} else if ($action == 'delete') {
					$result = $this->slideObj->delete();
				}
			}
		}
		if ($result) {
			return true;
		}
	}
	protected function checkExistSlide($id, $lang) {
		$this->slideObj = new Model($lang . '_slide');
		$this->slideObj->where('id_lang', $id);
		$this->slideObj->where('idw', $this->idw);
		$result = $this->slideObj->num_rows();
		if ($result) {
			return true;
		}
		return false;
	}

	//////////////////////////////////////////////////////

	public function getImage($value = null) {
		$getLangAndID   = getLangAndID();
		$this->slideObj = new Model($getLangAndID['lang'] . '_slide_image');
		$this->slideObj->where('idw', $this->idw);
		$total = $this->slideObj->num_rows();

		$max    = 10;
		$maxNum = 5;

		$url  = 'template-imagelist-lang-' . $getLangAndID['lang'];
		$page = pagination($max, $total, $maxNum, $url);

		$start      = $page['start'];
		$pagination = $page['pagination'];
		$select     = '`id`,`id_lang`,`slide_id`,`title`,`status`,`sort`,`description`,`create_time`,`src_link`';

		$this->slideObj->where('idw', $this->idw);
		$this->slideObj->orderBy('create_time', 'DESC');
		$result['data'] = $this->slideObj->get(null, array($start, $max), $select);

		if ($getLangAndID['lang'] != 'vi') {
			foreach ($result['data'] as $k => $v) {
				$v['id']            = $v['id_lang'];
				$result['data'][$k] = $v;
			}
		}
		if ($total > 10) {
			$result['pagination'] = $pagination;
		}
		return $result;
	}
	public function searchImage() {
		$value     = $this->r->get_string('value', 'GET');
		$keySearch = base64_decode($value);
		$keySearch = json_decode($keySearch, 1);

		$lang           = $this->r->get_string('lang', 'GET');
		$this->imageObj = new Model($lang . '_slide_image');
		$this->imageObj->where('idw', $this->idw);

		if (!empty($keySearch['slide_id']) && $keySearch['slide_id'] != "0") {
			$this->imageObj->where('slide_id', $keySearch['slide_id']);
		}

		$this->imageObj->where('idw', $this->idw);
		$total = $this->imageObj->num_rows();

		$max    = 10;
		$maxNum = 5;

		$url = 'template-imagelist-lang-' . $lang . '-value-' . $value;

		$page = pagination($max, $total, $maxNum, $url);

		$start      = $page['start'];
		$pagination = $page['pagination'];
		$this->imageObj->where('idw', $this->idw);

		if (!empty($keySearch['slide_id']) && $keySearch['slide_id'] != "0") {
			$this->imageObj->where('slide_id', $keySearch['slide_id']);
		}

		$result['data']      = $this->imageObj->get(null, array($start, $max), '*');
		$result['keySearch'] = $keySearch;

		if ($lang != 'vi') {
			foreach ($result['data'] as $k => $v) {
				$v['id']            = $v['id_lang'];
				$result['data'][$k] = $v;
			}
		}
		if ($total > 10) {
			$result['pagination'] = $pagination;
		}
		return $result;
	}
	public function getImageSlideId($slide_id) {
		$getLangAndID   = getLangAndID();
		$this->imageObj = new Model($getLangAndID['lang'] . '_slide_image');
		$this->imageObj->where('idw', $this->idw);
		$this->imageObj->where('slide_id', $slide_id);
		$total = $this->imageObj->num_rows();

		$max    = 10;
		$maxNum = 5;

		$url  = 'template-imagelist-lang-' . $getLangAndID['lang'];
		$page = pagination($max, $total, $maxNum, $url);

		$start      = $page['start'];
		$pagination = $page['pagination'];
		$select     = '`id`,`id_lang`,`slide_id`,`title`,`status`,`sort`,`description`,`create_time`,`src_link`';

		$this->imageObj->where('idw', $this->idw);
		$this->imageObj->where('slide_id', $slide_id);
		$this->imageObj->orderBy('create_time', 'DESC');
		$result['data'] = $this->imageObj->get(null, array($start, $max), $select);

		if ($getLangAndID['lang'] != 'vi') {
			foreach ($result['data'] as $k => $v) {
				$v['id']            = $v['id_lang'];
				$result['data'][$k] = $v;
			}
		}
		if ($total > 10) {
			$result['pagination'] = $pagination;
		}
		return $result;
	}
	public function getImageByID() {
		$getLangAndID   = getLangAndID();
		$id             = $this->r->get_int('id', 'GET');
		$this->slideObj = new Model($getLangAndID['lang'] . '_slide_image');
		$this->slideObj->where($getLangAndID['field_id'], $id);
		$this->slideObj->where('idw', $this->idw);
		$result = $this->slideObj->getOne();
		if ($result) {
			return $result;
		}
	}
	protected function fixImageID($data, $id, $action) {
		global $_B;
		$lang_user = explode(',', $_B['cf']['lang_use']);
		foreach ($lang_user as $k => $v) {
			if ($v != 'vi') {
				$this->slideObj = new Model($v . '_slide_image');
				$this->slideObj->where('id_lang', $id);
				$this->slideObj->where('idw', $this->idw);
				if ($action == 'update') {
					$result = $this->slideObj->update($data);
				} else if ($action == 'delete') {
					$result = $this->slideObj->delete();
				}
			}
		}
		if ($result) {
			return true;
		}
	}
	protected function checkExistImage($id, $lang) {
		$this->slideObj = new Model($lang . '_slide_image');
		$this->slideObj->where('id_lang', $id);
		$this->slideObj->where('idw', $this->idw);
		$result = $this->slideObj->num_rows();
		if ($result) {
			return true;
		}
		return false;
	}
}