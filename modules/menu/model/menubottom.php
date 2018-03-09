<?php

if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

class MenuBottom {
	public $idw, $r, $menubelow;
	private $uid;
	public function __construct() {
		global $_B;
		$this->r            = $_B['r'];
		$this->idw          = $_B['web']['idw'];
		$this->uid          = $_B['uid'];
		$this->lang_default = $_B['lang_default'];
		$this->lang         = $this->r->get_string('lang', 'GET');
	}

	private function news() {
		$db_news = db_connect('news');
		$mN      = new Model($this->lang . '_category', $db_news);
		$mN->where('idw', $this->idw);
		if ($this->lang != $this->lang_default) {
			$select = 'id_lang as id,parent_id,title';
		} else {
			$select = 'id,id_lang,parent_id,title';
		}
		return $mN->get(null, null, $select);
	}

	private function album() {

		$db_album_category = db_connect('album');
		$mA                = new Model($this->lang . '_album_category', $db_album_category);
		$mA->where('idw', $this->idw);
		if ($this->lang != $this->lang_default) {
			$select = 'id_lang as id,parent_id,title';
		} else {
			$select = 'id,id_lang,parent_id,title';
		}
		return $mA->get(null, null, $select);
	}

	private function qaa() {
		return false;
		$db_qaa = db_connect('qaa');
		$mQ     = new Model($this->lang . '_faq_category', $db_qaa);
		$mQ->where('idw', $this->idw);
		if ($this->lang != $this->lang_default) {
			$select = 'id_lang as id,parent_id,title';
		} else {
			$select = 'id,id_lang,parent_id,title';
		}
		return $mQ->get(null, null, $select);
	}

	private function video() {
		$db_video = db_connect('video');
		$mV       = new Model($this->lang . '_category', $db_video);
		$mV->where('idw', $this->idw);
		if ($this->lang != $this->lang_default) {
			$select = 'id_lang as id,parent_id,title';
		} else {
			$select = 'id,id_lang,parent_id,title';
		}
		return $mV->get(null, null, $select);
	}

	private function product() {
		$db_product = db_connect('product');
		$mP         = new Model($this->lang . '_category', $db_product);
		$mP->where('idw', $this->idw);
		if ($this->lang != $this->lang_default) {
			$select = 'id_lang as id,parent,name as title';
		} else {
			$select = 'id,id_lang,parent,name as title';
		}
		return $mP->get(null, null, $select);
	}

	private function category() {
		$db_category = db_connect('category');
		$mC          = new Model($this->lang . '_category', $db_category);
		$mC->where('idw', $this->idw);
		$mC->where('status', 1);
		if ($this->lang != $this->lang_default) {
			$select = 'id_lang as id,title';
		} else {
			$select = 'id,id_lang,title';
		}
		return $mC->get(null, null, $select);
	}

	public function merge_category() {
		$category = array(
			'news'     => array(
				'name'    => 'Tin tức',
				'mod'     => 'news',
				'page'    => 'category',
				'sub'     => 'cat',
				'content' => $this->fix_tree($this->news(), 'parent_id'),
			),
			'album'    => array(
				'name'    => 'Album',
				'mod'     => 'album',
				'page'    => 'category',
				'sub'     => '',
				'content' => $this->fix_tree($this->album(), 'parent_id'),
			),
			'qaa'      => array(
				'name'    => 'Hỏi đáp',
				'mod'     => 'qaa',
				'page'    => 'category',
				'sub'     => '',
				'content' => $this->fix_tree($this->qaa(), 'parent_id'),
			),
			'video'    => array(
				'name'    => 'Video',
				'mod'     => 'video',
				'page'    => 'category',
				'sub'     => 'cat',
				'content' => $this->fix_tree($this->video(), 'parent_id')),
			'product'  => array(
				'name'    => 'Sản phẩm',
				'mod'     => 'product',
				'page'    => 'product',
				'sub'     => 'category',
				'content' => $this->fix_tree($this->product(), 'parent'),
			),
			'category' => array(
				'name'    => 'Trang chuyên mục',
				'mod'     => 'category',
				'page'    => 'detail',
				'sub'     => 'view',
				'content' => $this->category(),
			),
		);
		return $category;

	}
	public function fix_tree($data = array(), $col, $parent = 0, $line = '', $str_id = '', $trees = array()) {
		$result = array();
		if (count($data) > 0) {
			foreach ($data as $k => $v) {
				if ($v[$col] == $parent) {
					$result[] = $v;
					unset($data[$k]);
				}
			}
		}
		if (count($result) > 0) {
			foreach ($result as $k => $v) {
				$trees[]             = $v;
				$i                   = count($trees) - 1;
				$trees[$i]['line']   = $line;
				$trees[$i]['str_id'] = $str_id;
				$trees               = $this->fix_tree($data, $col, $v['id'], $line . '--', $str_id . $v['id'] . '|', $trees);
			}
		}
		return $trees;
	}
	public function addMenuBottom() {
		$id        = $this->r->get_int('id', 'GET');
		$lang      = $this->r->get_string('lang', 'GET');
		$menubelow = new Model($lang . '_menu');

		if ($this->r->get_string('nofollow', 'POST') == 'on') {
			$nofollow = 1;
		} else {
			$nofollow = 0;
		}
		$linkto   = $this->r->get_string('linkto', 'POST');
		$linktoct = $this->r->get_string('linktoct', 'POST');
		if (empty($linkto)) {
			$link           = $linktoct;
			$linktoct_array = explode('|', $linktoct);
			$direct_link    = array(
				'mod'  => $linktoct_array[0],
				'page' => $linktoct_array[1],
				'sub'  => $linktoct_array[2],
				'id'   => $linktoct_array[3],
			);
			$driect_link_json = json_encode($direct_link);
		} else {
			$link             = $linkto;
			$driect_link_json = '';
		}

		$data = array(
			'idw'         => $this->idw,
			'namemenu'    => $this->r->get_string('namemenu', 'POST'),
			'link'        => $link,
			'parent_id'   => $this->r->get_int('parent_id', 'POST'),
			'nofollow'    => $nofollow,
			'sort'        => $this->r->get_int('sort', 'POST'),
			'status'      => $this->r->get_string('status', 'POST'),
			'direct_link' => $driect_link_json,
			'type'        => 2,
		);

		if (!empty($id)) {
			$menubelow->where('id', $id);
			$menubelow->where('idw', $this->idw);
			$result = $menubelow->update($data);
		} else {
			$result = $menubelow->insert($data);
		}
		if ($result) {
			$return['status'] = true;
		} else {
			$return['status'] = false;
		}
		return $return;
	}
	public function getMenuBottom() {
		global $_B;
		$id        = $this->r->get_int('id', 'GET');
		$lang      = $this->r->get_string('lang', 'GET');
		$menubelow = new Model($lang . '_menu');
		$menubelow->where('id', $id);
		$menubelow->where('idw', $this->idw);
		$menubelow->where('type', 2);
		$select = '*';
		$data   = $menubelow->getOne(null, null, $select);
		return $data;
	}
	public function getParentid() {
		$id        = $this->r->get_int('id', 'GET');
		$lang      = $this->r->get_string('lang', 'GET');
		$menubelow = new Model($lang . '_menu');
		$select    = '*';
		$menubelow->where('id', $id, "!=");
		$menubelow->where('idw', $this->idw);
		$menubelow->where('type', 2);
		$menubelow->orderBy('sort', 'ASC');
		$data   = $menubelow->get(null, null, $select);
		$result = $this->getMenuParentBottom($data);
		if ($result) {
			return $result;
		}
	}
	protected function getMenuParentBottom($data = array(), $parent = 0, $space = '') {
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
				$current[$k]['sub']      = $this->getMenuParentBottom($data, $v['id'], $space . '--');
			}
		}
		return $current;
	}
/*	public function getMenuParent(){
global $_B;
$lang = $this->r->get_string('lang','GET');
$menubelow = new Model($lang.'_menubottom');
$menubelow->where('idw',$this->idw);
$select = '*';
$data   = $menubelow->get(null,null,$select);
return $data;
}*/
}
