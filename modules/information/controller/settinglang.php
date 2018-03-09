<?php
/**
 * Code By Nguyen Xuan Truong
 *
 */
class Settinglang {
	function __construct() {
		global $_B;
		$this->temp        = $_B['temp'];
		$this->request     = $_B['r'];
		$this->idw         = $_B['web']['idw'];
		$this->langDefault = $_B['cf']['lang'];
		$this->lang_des    = array(
			'en' => 'Tiếng Anh',
			'ru' => 'Tiếng Nga',
			'la' => 'Tiếng Lào',
			'jp' => 'Tiếng Nhật', 
			'th' => 'Tiếng Thái',
			'vi' => 'Tiếng Việt',
			'fr' => 'Tiếng Pháp',
			'pl' => 'Tiếng Ba Lan',
			'kh' => 'Tiếng khmer',
			'cz' => 'Tiếng Séc',
			'kr' => 'Tiếng Hàn'
		);
		$this->model = new MSettingLang;
	}

	public function index() {
		global $_DATA, $_B;
		$_DATA['lang_convert'] = $this->lang_des;
		$_DATA['all_lang']     = $_B['langs'];
		//
		$langReady          = $this->model->langReady();
		$flag               = array();
		$_DATA['langReady'] = explode(',', $langReady['value_string']);
		foreach ($_DATA['langReady'] as $k => $v) {
			$tmp_flag = $this->model->flag($v);
			$flag[$v] = $_B['mod_theme'].'/flags/' . $tmp_flag['image'];
		}
		$_DATA['flag'] = $flag;

		//
		$langPrimary          = $this->model->langPrimary();
		$_DATA['langPrimary'] = $langPrimary['value_string'];
		//
		$langShowHome            = $this->model->langShowHome();
		$_DATA['langShowHome']   = explode(',', $langShowHome['value_string']);
		$_DATA['content_module'] = $this->temp->load('settinglang');
	}

	public function edit() {
		global $_DATA, $_B;
		$langPrimary = $this->request->get_string('langPrimary', 'POST');
		$getSh       = $this->request->get_array('langShowHome', 'POST');
		$sort        = $this->request->get_array('sort', 'POST');
		$sort        = explode(',', $sort[0]);
		array_push($getSh, $langPrimary);
		foreach ($sort as $k => $v) {
			if (!in_array($v, $getSh)) {
				unset($sort[$k]);
			}
		}
		$langShowHome           = implode(',', $sort);
		$dataPr['value_string'] = $langPrimary;
		$dataSh['value_string'] = $langShowHome;
		$this->model->update('lang', $dataPr);
		$this->model->update('lang_use', $dataSh);
		$result = array(
			'status'  => 1,
			'message' => lang('edit_success'),
		);
		echo json_encode($result);
		$_DATA['content_module'] = '';
	}

}