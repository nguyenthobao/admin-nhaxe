<?php
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
class MenuListTop {
	public $idw, $r, $lang, $result_id, $menulistabove;
	public function __construct() {
		global $_B;
		$this->r         = $_B['r'];
		$this->idw       = $_B['web']['idw'];
		$this->lang      = $_B['cf']['lang'];
		$this->result_id = "";
		$this->ids       = new ArrayObject();
	}
	public function getMenuListTop($value = null) {
		$lang          = $this->r->get_string('lang', 'GET');
		$menulistabove = new Model($lang . '_menu');
		$menulistabove->where('idw', $this->idw);
		$total      = $menulistabove->num_rows();
		$max        = 15;
		$maxNum     = 5;
		$url        = 'menu-menulisttop-lang-' . $lang;
		$page       = pagination($max, $total, $maxNum, $url);
		$start      = $page['start'];
		$pagination = $page['pagination'];
		$select     = '*';
		$menulistabove->where('idw', $this->idw);
		$menulistabove->where('type', 1);
		$menulistabove->orderBy('id', 'DESC');
		$result['data'] = $menulistabove->get(null, array($start, $max), $select);

		if ($total > 15) {
			$result['pagination'] = $pagination;
		}
		return $result;

	}
	public function copyMenu($flag = false) {

		$lang          = $this->r->get_string('lang', 'GET');
		$idCopy        = array();
		$this->_lang   = $lang;
		$this->_id     = 'id';
		$this->newsId  = new stdClass;
		$menulistabove = new Model($this->_lang . '_menu');
		$ids           = $this->r->get_array('name_id', 'POST');
		if ($ids) {
			$menulistabove->where($this->_id, $ids, 'IN');
			$menulistabove->where('parent_id', $ids, 'NOT IN');
			$menulistabove->where('idw', $this->idw);
			$menulistabove->where('type', 1);
			$data = $menulistabove->get(null, null, '*');
			$this->copyChildMenu($data);
		}
		foreach ($this->ids as $k => $v) {
			unset($v['data']['id']);
			$timeCopy = date('H:i:s d-m');
			$v['data']['namemenu'] .= ' - Copy - ' . $timeCopy;
			$v['data']['status'] = 0;
			$idCopy[$v['id']]    = $v;
		}
		usort($idCopy, function ($a, $b) {
			return $a['parent_id'] - $b['parent_id'];
		});
		foreach ($idCopy as $id => $result) {
			if ($result['parent_id'] != 0) {
				if (isset($this->newsId->{$result['parent_id']})) {
					$result['data']['parent_id'] = $this->newsId->{$result['parent_id']};
				}
			}
			if ($flag == true) {
				$result['data']['id_lang'] = $this->newsId->{$result['id']};
			}
			$latest_id = $menulistabove->insert($result['data']);
			if ($flag == true) {
				$this->newsIdLang->{$result['id']} = $latest_id;
			} else {
				$this->newsId->{$result['id']} = $latest_id;
			}
		}
		unset($idCopy);
		$r['status'] = true;
		return $r;
	}

	public function copyChildMenu($data = array(), $parent_id = 0) {
		$current = array();
		if (sizeof($data) > 0) {
			foreach ($data as $k => $v) {
				$menulistabove = new Model($this->_lang . '_menu');
				$this->ids->append(array('id' => $v[$this->_id], 'parent_id' => $parent_id, 'data' => $v));
				$menulistabove->where('parent_id', $v[$this->_id]);
				$menulistabove->where('idw', $this->idw);
				$menulistabove->where('type', 1);
				$current = $menulistabove->get(null, null, '*');
				$this->copyChildMenu($current, $v[$this->_id]);
			}
		}
	}
	public function activeStatusMenulistabove() {
		global $_B;
		$lang          = $this->r->get_string('lang', 'GET');
		$id            = $this->r->get_int('key', 'POST');
		$status        = $this->r->get_string('status', 'POST');
		$menulistabove = new Model($lang . '_menu');
		$update        = array('status' => $status);
		$menulistabove->where('id', $id);
		$menulistabove->where('idw', $this->idw);
		$menulistabove->where('type', 1);
		$result = $menulistabove->update($update);
	}
	public function activeNofollowMenulistabove() {
		global $_B;
		$lang          = $this->r->get_string('lang', 'GET');
		$id            = $this->r->get_int('key', 'POST');
		$nofollow      = $this->r->get_string('nofollow', 'POST');
		$menulistabove = new Model($lang . '_menu');
		$update        = array('nofollow' => $nofollow);
		$menulistabove->where('id', $id);
		$menulistabove->where('idw', $this->idw);
		$menulistabove->where('type', 1);
		$result = $menulistabove->update($update);
	}

	public function saveImgFast() {
		//global $_B;
		$id  = $this->r->get_int('id_img', 'POST');
		$str = 'img_news_' . $id;
		//echo $str;
		include DIR_HELPER_UPLOAD;
		$options = array('max_size' => 1600);
		$upload  = new BncUpload($options);
		if (!empty($str)) {
			$up_img        = $upload->upload($this->idw, 'menutop', $str);
			$lang          = $this->r->get_string('lang', 'GET');
			$menulistabove = new Model($lang . "_menu");
			$menulistabove->where('id', $id);
			$menulistabove->where('idw', $this->idw);
			$menulistabove->where('type', 1);
			$result = $menulistabove->update(array('img' => $up_img));
			if ($result) {
				$data['status'] = true;
			} else {
				$data['status'] = false;
			}
			return $data;
		}
	}

	public function editTitleMenu() {
		$id    = $this->r->get_int('pk', 'POST');
		$title = $this->r->get_string('value', 'POST');
		//Cắt bỏ chuỗi -- .
		$rule = "/([^-+\s]).+$/";
		if (!empty($title)) {
			preg_match($rule, $title, $pr_title);
			$lang          = $this->r->get_string('lang', 'GET');
			$menulistabove = new Model($lang . '_menu');
			$menulistabove->where('id', $id);
			$menulistabove->where('idw', $this->idw);
			$menulistabove->where('type', 1);
			$result = $menulistabove->update(array('namemenu' => $pr_title[0]));
		}
	}

	public function editlinktoctNews() {
		$id    = $this->r->get_int('pk', 'POST');
		$title = $this->r->get_string('value', 'POST');
		$rule  = "/([^-+\s]).+$/";
		if (!empty($title)) {
			preg_match($rule, $title, $pr_title);
			$lang          = $this->r->get_string('lang', 'GET');
			$menulistabove = new Model($lang . '_menu');
			$menulistabove->where('id', $id);
			$menulistabove->where('idw', $this->idw);
			$menulistabove->where('type', 1);
			$data = array(
				'link'        => $pr_title[0],
				'direct_link' => '',
			);
			$result = $menulistabove->update($data);
		}

	}

	public function editSortNews() {
		$id            = $this->r->get_int('pk', 'POST');
		$sort          = $this->r->get_int('value', 'POST');
		$lang          = $this->r->get_string('lang', 'GET');
		$menulistabove = new Model($lang . '_menu');
		$menulistabove->where('id', $id);
		$menulistabove->where('idw', $this->idw);
		$result = $menulistabove->update(array('sort' => $sort));
	}
	public function getParentid() {
		$id        = $this->r->get_int('id', 'GET');
		$lang      = $this->r->get_string('lang', 'GET');
		$menubelow = new Model($lang . '_menu');
		$select    = '*';
		$menubelow->where('idw', $this->idw);
		$menubelow->where('type', 1);
		$menubelow->orderBy('sort', 'ASC');
		$data   = $menubelow->get(null, null, $select);
		$result = $this->getMenuParentTop($data);
		if ($result) {
			return $result;
		}
	}
	protected function getMenuParentTop($data = array(), $parent = 0, $space = '') {
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
				$current[$k]['namemenu'] = $v['namemenu'];
				$current[$k]['space']    = $space . " ";
				$current[$k]['sub']      = $this->getMenuParentTop($data, $v['id'], $space . '--');
			}
		}
		return $current;
	}
	public function deleteMultiID() {
		$ids = $this->r->get_array('name_id', 'POST');
		foreach ($ids as $k => $v) {
			$this->deleteMenulistTop($v);
		}
		$r['status'] = true;
		return $r;
	}
	public function deleteMenulistTop($id = null) {
		$multi = false;
		if (!isset($id)) {
			$id    = $this->r->get_int('key', 'POST');
			$multi = true;
		}
		$lang          = $this->r->get_string('lang', 'GET');
		$menulistabove = new Model($lang . '_menu');

		$menulistabove->where('id', $id);
		$menulistabove->where('idw', $this->idw);
		$menulistabove->where('type', 1);
		$menulistabove->delete();
		$result = $this->getCategoryByParent($id);
		if ($multi == true) {
			//Nếu là xoá 1 bản ghi qua ajax thì mới trả về dãy mảng.
			echo $this->result_id;
		}
	}

	protected function getCategoryByParent($parent_id) {
		$ids           = array();
		$lang          = $this->r->get_string('lang', 'GET');
		$menulistabove = new Model($lang . '_menu');
		//get ids
		$menulistabove->where('parent_id', $parent_id);
		$menulistabove->where('idw', 1);
		$ids = $menulistabove->get(null, null, 'id');
		//delete
		foreach ($ids as $k => $v) {
			$this->result_id .= $v['id'] . ",";
			$menulistabove->where('id', (int) $v['id']);
			$menulistabove->where('idw', $this->idw);
			$menulistabove->where('type', 1);
			$menulistabove->delete();
			//$this->catNewObj->update(array('meta_title'=>time()));//Muốn xoá thử để không phải thêm lại dữ liệu thì dùng update
			$this->getCategoryByParent($v['id']);
		}
		return $this->result_id;
	}

}
