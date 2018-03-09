<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/template.php
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 10/13/2014, 16:10 PM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
class Logo extends GlobalTemplate {
	public $idw, $r, $lang, $logoObj;
	private $uid;
	public function __construct() {
		global $_B;
		$this->r    = $_B['r'];
		$this->idw  = $_B['web']['idw'];
		$this->lang = $_B['cf']['lang'];
	}

	public function watermark() {

		$db_cf = db_connect();
		$cf    = new Model('web_cf_admin', $db_cf);
		$cf->where('idw', $this->idw);
		$cf->where('`key`', 'watermark');
		$result = $cf->getOne();
		return $result;
	}

	public function enableResponsive() {
		$value = $this->r->get_int('value', 'POST');
		$db_cf = db_connect();
		$cf    = new Model('web_cf_admin', $db_cf);
		$cf->where('idw', $this->idw);
		$cf->where('`key`', 'responsive_active');
		$cf->delete();
		$result = $cf->insert(array('idw' => $this->idw, 'key' => 'responsive_active', 'value_int' => $value));
		return $this->idw;
	}
	function getTempId(){
		global $_B;
		return $_B['web']['theme_id'];
	}
	function changeTemp(){
		global $_B;

		$tempId =  $this->r->get_int('tempid', 'POST');
		$db_cf = db_connect();
		$webM = new Model('web',$db_cf);
		if(!empty($_B['web']['idw'])){
			$webM->where('idw',$_B['web']['idw']);
			$webM->update(array(
				'theme_id' => $tempId
			));
		}
		$rt['status'] = true;
		return $rt;
	}
	public function getConfigResponsive() {
		global $_B;

		$db_cf = db_connect();
		$cf    = new Model('web_cf_admin', $db_cf);
		$cf->where('idw', $_B['web']['idw']);
		$cf->where('`key`', 'responsive_active');
		$result = $cf->getOne();

		return $result['value_int'];
	}
	public function addLogo() {
		global $_B;
		$getLangAndID  = getLangAndID();
		$this->logoObj = new Model($getLangAndID['lang'] . '_logo');
		//START UPLOAD
		$str = 'img_logo';
		if (($_FILES[$str]["type"] == "image/gif") || ($_FILES[$str]["type"] == "image/jpeg") || ($_FILES[$str]["type"] == "image/jpg") || ($_FILES[$str]["type"] == "image/png")) {
			include DIR_HELPER_UPLOAD;
			$options = array('max_size' => 1600);
			$upload  = new BncUpload($options);
			$up_img  = $upload->upload($this->idw, 'news', $str);
		} else {
			include DIR_HELPER_UPLOAD;
			$options = array(
				'max_size'  => 1600,
				'type_file' => 'flash',
			);
			$upload = new BncUpload($options);
			$up_img = $upload->upload($this->idw, null, 'img_logo');
		}
		//END UPLOAD
		$id_lang = null;
		if ($getLangAndID['lang'] != 'vi') {
			$this->logoObj = new Model('vi_logo');
			$this->logoObj->where('idw', $this->idw);
			$dataId  = $this->logoObj->getOne();
			$id_lang = $dataId['id'];
		}
		if ($this->r->get_string('display_logo', 'POST') == 'on') {
			$is_display = 1;
		} else {
			$is_display = 0;
		}
		if ($getLangAndID['lang'] != 'vi') {
			$data = array(
				'idw'     => $this->idw,
				'id_lang' => $id_lang,
				//'id_lang'			=>(!empty($id))?$id:null,
				'img'     => $up_img,
				'width'   => $this->r->get_string('width_logo', 'POST'),
				'height'  => $this->r->get_string('height_logo', 'POST'),
				'status'  => $is_display,
			);
		} else {
			$data = array(
				'idw'     => $this->idw,
				'id_lang' => null,
				'img'     => $up_img,
				'width'   => $this->r->get_string('width_logo', 'POST'),
				'height'  => $this->r->get_string('height_logo', 'POST'),
				'status'  => $is_display,
			);
		}
		if (isset($_POST['img_logo']) && $_POST['img_logo'] == "1") {
			unset($data['img']);
		}
		$id = $this->r->get_int('idlogo', 'POST');
		if (!empty($id)) {
			$this->logoObj->where($getLangAndID['field_id'], $id);
			$this->logoObj->where('idw', $this->idw);
			$result = $this->logoObj->update($data);

			if ($getLangAndID['lang'] == 'vi') {
				$data = array(
					'id_lang' => $id,
				);
				$this->fixLogoID($data, $id, 'update');
			} else {
				$checkExistLogo = $this->checkExistLogo($id, $getLangAndID['lang']);
				if ($checkExistLogo == true) {
					$this->logoObj->where($getLangAndID['field_id'], $id);
					$this->logoObj->where('idw', $this->idw);
					$result = $this->logoObj->update($data);
				} else {
					$result = $this->logoObj->insert($data);
				}
			}
		} else {
			if ($getLangAndID['lang'] == 'vi') {
				$result = $this->logoObj->insert($data);
			} else {
				$this->logoObj = new Model($getLangAndID['lang'] . '_logo');
				$result        = $this->logoObj->insert($data);
			}
		}
		if ($result) {
			$return['status'] = true;
		} else {
			$return['status'] = false;
			$return['error']  = $this->logoObj->getLastError();
		}
		return $return;
	}

	public function addBackground() {
		global $_B;
		$this->logoObj = new Model('background');
		//START UPLOAD
		include DIR_HELPER_UPLOAD;
		//$options = array('max_size' => 1600);
		$upload  = new BncUpload();
		$up_img  = $upload->upload($this->idw, 'news', 'img_bg'); 
		//END UPLOAD
		$data = array(
			'idw'    => $this->idw,
			'img'    => $up_img,
			'color'  => $this->r->get_string('color_background', 'POST'),
			'repeat' => $this->r->get_string('repeat', 'POST'),
		);
		if (isset($_POST['img_bg']) && $_POST['img_bg'] == "1") {
			unset($data['img']);
		}
		$id = $this->r->get_int('idbg', 'POST');
		if (!empty($id)) {
			$this->logoObj->where('id', $id);
			$this->logoObj->where('idw', $this->idw);
			$result = $this->logoObj->update($data);
		} else {
			$result = $this->logoObj->insert($data);
		}
		if ($result) {
			$return['status'] = true;
		} else {
			$return['status'] = false;
			$return['error']  = $this->logoObj->getLastError();
		}
		return $return;
	}
	public function addAudio() {
		global $_B;
		$this->logoObj = new Model('audio');
		//START UPLOAD
		include DIR_HELPER_UPLOAD;
		$options = array(
			'type_file' => 'audio',
		);
		$upload  = new BncUpload($options);
		$up_file = $upload->upload($this->idw, null, 'file_audio');
		//END UPLOAD
		if ($this->r->get_string('play_home', 'POST') == 'on') {
			$play_home = 1;
		} else {
			$play_home = 0;
		}
		if ($this->r->get_string('play_page', 'POST') == 'on') {
			$play_page = 1;
		} else {
			$play_page = 0;
		}
		if ($this->r->get_string('on_audio', 'POST') == 'on') {
			$on_audio = 1;
		} else {
			$on_audio = 0;
		}
		if ($this->r->get_string('play_again', 'POST') == 'on') {
			$play_again = 1;
		} else {
			$play_again = 0;
		}
		$data = array(
			'idw'        => $this->idw,
			'audio'      => $up_file,
			'is_home'    => $play_home,
			'is_page'    => $play_page,
			'status'     => $on_audio,
			'play_again' => $play_again,
		);
		
		if ($_FILES['file_audio']['error']!=0) { 
			unset($data['audio']);
		}

		$id = $this->r->get_int('idaudio', 'POST');
		if (!empty($id)) {

			$this->logoObj->where('id', $id);
			$this->logoObj->where('idw', $this->idw);
			$result = $this->logoObj->update($data);
		} else {
			$result = $this->logoObj->insert($data);
		}
		if ($result) {
			$return['status'] = true;
		} else {
			$return['status'] = false;
			$return['error']  = $this->logoObj->getLastError();
		}
		return $return;
	}
	public function deleteLogo($id = null) {
		$id            = $this->r->get_int('key', 'POST');
		$getLangAndID  = getLangAndID();
		$this->newsObj = new Model($getLangAndID['lang'] . '_logo');
		$this->newsObj->where($getLangAndID['field_id'], $id);
		$this->newsObj->where('idw', $this->idw);
		$this->newsObj->delete();
	}
	public function deleteBackground($id = null) {
		$multi = false;
		if (!isset($id)) {
			$id    = $this->r->get_int('key', 'POST');
			$multi = true;
		}
		$this->result_id .= $id . ",";
		$getLangAndID  = getLangAndID();
		$this->newsObj = new Model('background');
		$this->newsObj->where($getLangAndID['field_id'], $id);
		$this->newsObj->where('idw', $this->idw);
		$this->newsObj->delete();
	}
}