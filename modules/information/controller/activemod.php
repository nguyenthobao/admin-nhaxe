<?php
/**
 * Code By Nguyen Xuan Truong
 *
 */
class Activemod {
	function __construct() {
		global $_B;
		$this->temp        = $_B['temp'];
		$this->request     = $_B['r'];
		$this->idw         = $_B['web']['idw'];
		$this->langDefault = $_B['cf']['lang'];
		$this->uid         = $_B['uid'];
		$this->model       = new MActivemod;
	}
	/**
	 * [index description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-06-12
	 * @return [type]                     [description]
	 */
	public function index() {
		global $_DATA, $_B;
		//List mod
		if ($this->model->checkExist() == false) {
			$this->model->addActiveModule();
			header('Location:' . $_B['url_cur']);
		}
		$listMod = $this->model->getListMod();
		//Active mod
		//Bo nhung mod chua su dung
		// unset($_B['listModule'][array_search('commentv2', $_B['listModule'])]);
		// unset($_B['listModule'][array_search('deal', $_B['listModule'])]);
		unset($_B['listModule'][array_search('lists', $_B['listModule'])]);
		unset($_B['listModule'][array_search('seo', $_B['listModule'])]);
		//unset($_B['listModule'][array_search('maps', $_B['listModule'])]);
		//unset($_B['listModule'][array_search('contact', $_B['listModule'])]);
		//unset($_B['listModule'][array_search('feedback', $_B['listModule'])]);
		$listModule = $_B['listModule'];
		$_DATA['active_mod'] = array();
		if ($listMod['active_mod'] == ',all,') {
			$_DATA['active_mod'][] = 'information';
			$_DATA['active_mod']   = array_merge($_DATA['active_mod'], $listModule);
		} else {
			$_DATA['active_mod'] = array_values(array_filter(explode(',', $listMod['active_mod'])));
		}
		//Customs mod
		$_DATA['customs_mod'] = array();
		if ($listMod['customs_mod'] == ',all,') {
			$_DATA['customs_mod'][] = 'information';
			$_DATA['customs_mod']   = array_merge($_DATA['customs_mod'], $listModule);
		} else {
			$_DATA['customs_mod'] = array_values(array_filter(explode(',', $listMod['customs_mod'])));
		}

		$_DATA['content_module'] = $this->temp->load('activemod');
	}
	/**
	 * [ajaxActiveMod description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-06-12
	 * @return [type]                     [description]
	 */
	public function ajaxActiveMod() {
		$active_mod         = $this->request->get_array('active_mod', 'POST');
		$active_mod_default = $this->request->get_array('active_mod_default', 'POST');
		$active_mod         = ',' . implode(',', $active_mod) . ',';
		$active_mod_default = ',' . implode(',', $active_mod_default) . ',';
		$data               = array(
			'active_mod'  => $active_mod_default,
			'customs_mod' => $active_mod,
			'update_time' => time(),
			'uid_update'  => $this->uid,
		);
		$this->model->updateActiveModules($data);
		$result = array(
			'status'  => true,
			'message' => 'Thao tác thành công',
		);
		echo json_encode($result);
		exit();
	}

}