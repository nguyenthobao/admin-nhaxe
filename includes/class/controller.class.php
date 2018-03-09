<?php
namespace Bncv2\Core;
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
Class Controller {
	public $request, $lang_default, $langs = array();
	public function __construct() {
		global $_B;
		$this->request      = $_B['r'];
		$this->lang_default = $_B['lang_default'];
		$this->langs        = explode(',', $_B['cf']['lang_use']);
		$this->idw          = $_B['web']['idw'];
		$this->mod          = $this->request->get_string('mod', 'GET');
		$this->page         = $this->request->get_string('page', 'GET');
		$this->sub          = $this->request->get_string('sub', 'GET');
		$this->id           = $this->request->get_int('id', 'GET');
		$this->lang         = $this->request->get_string('lang', 'GET');
		$this->temp         = $_B['temp'];
		$this->home         = $_B['home'];
		$this->upload_path  = $_B['upload_path'];
		$this->uid          = $_B['uid'];
	}

	/**
	 * [loadModel description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-08-03
	 * @param  [type]                     $file [description]
	 * @param  [type]                     $mod  [description]
	 * @return [type]                           [description]
	 */
	public function loadModel($file, $mod = null) {
		if ($mod === null) {
			$path = DIR_MODULES . $this->mod . '/model/' . $file . '.php';
			if (file_exists($path)) {
				include_once $path;
				$obj = new $file();
				return $obj;
			} else {
				die('Không tồn tại file này' . $path);
			}
		} else {
			$path = DIR_MODULES . $mod . '/model/' . $file . '.php';
			if (file_exists($path)) {
				include_once $path;
				$obj = new $file();
				return $obj;
			} else {
				die('Không tồn tại file này' . $path);
			}
		}
	}
	/**
	 * [langTab description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-08-03
	 * @return [type]                     [description]
	 */
	public function langTab($not_map=null) {
		$url_lang = array();
		if (!empty($this->id) && $this->id != 0) {
			foreach ($this->langs as $k => $v) {
				$url_lang[$v]['url'] = $this->home . '/' . $this->mod . '-' . $this->page . '-' . $this->sub . '-' . $this->id . '-lang-' . $v;
			}
		} elseif ($this->sub === 'add') {
			foreach ($this->langs as $k => $v) {
				$url_lang[$v]['url'] = $this->home . '/' . $this->mod . '-' . $this->page . '-' . $this->sub . '-lang-' . $v;
				if ($v == $this->lang_default || $not_map!=null) {
					
				} else {
					$url_lang[$v]['url']   = 'javascript:void(0);';
					$url_lang[$v]['exist'] = 'notExist';
				}
			}
		} else {
			foreach ($this->langs as $k => $v) {
				$url_lang[$v]['url'] = $this->home . '/' . $this->mod . '-' . $this->page . '-' . $this->sub . '-lang-' . $v;
			}
		}
		return $url_lang;
	}

	/**
	 * [parent description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-08-03
	 * @param  array                      $data   [description]
	 * @param  integer                    $parent [description]
	 * @param  string                     $space  [description]
	 * @return [type]                             [description]
	 */
	public function parent($data = array(), $parent = 0, $space = '') {
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
				$current[$k]['sub']      = $this->parent($data, $v['id'], $space . '--');
			}
		}
		return $current;
	}

	/**
	 * [setNotify description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-08-04
	 * @param  [type]                     $result [description]
	 */
	public function setNotifyController($result) {
		$message = '';
		if (isset($result['message'])) {
			$message = $result['message'];
		} else {
			if ($result['status'] === true) {
				$message = 'Thao tác thành công !';
			} else {
				$message = 'Xảy ra lỗi !';
			}
		}
		$res = array(
			'status'  => $result['status'],
			'message' => $message,
		);
		//Set Session
		$_SESSION['notify'] = $res;
		return true;
	}

	/**
	 * [getNotify description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-08-04
	 * @return [type]                     [description]
	 */
	public function getNotifyController() {
		$notify             = $_SESSION['notify'];
		$_SESSION['notify'] = false;
		return $notify;
	}
	/**
	 * [fix_tree description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-08-05
	 * @param  array                      $data   [description]
	 * @param  [type]                     $col    [description]
	 * @param  integer                    $parent [description]
	 * @param  string                     $line   [description]
	 * @param  string                     $str_id [description]
	 * @param  array                      $trees  [description]
	 * @return [type]                             [description]
	 */
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

	public function deleteFile($pathFile) {
		include_once DIR_HELPER_UPLOAD;
		$upload = new \BncUpload();
		$del    = $upload->del($pathFile);
		return $del;
	}
}
?>