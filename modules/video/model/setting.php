<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/setting.php
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/17/2014, 10:14 AM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
class Setting extends GlobalVideo {
	public $idw, $r, $settingObj;
	private $uid;
	public function __construct() {
		global $_B;
		$this->r    = $_B['r'];
		$this->idw  = $_B['web']['idw'];
		$this->lang = $_B['cf']['lang'];

		$getLangAndID     = getLangAndID();
		$this->settingObj = new Model($getLangAndID['lang'] . '_setting');
	}
	public function saveSettingVideoHome() {
		global $_B;
		include DIR_HELPER_UPLOAD;
		$options = array('max_size' => 1600);
		$upload  = new BncUpload($options);
		$img     = $upload->upload($this->idw, 'video', 'img_page_video');
		$icon    = $upload->upload($this->idw, 'video', 'icon_page_video');
		$bg      = $upload->upload($this->idw, 'video', 'bg_page_video');

		$video_setting = array(
			'idw'              => $this->idw,
			'title'            => $this->r->get_string('title', 'POST'),
			'description'      => $this->r->get_string('description', 'POST'),
			'img'              => $img,
			'bg'               => $bg,
			'icon'             => $icon,
			'meta_title'       => $this->r->get_string('meta_title', 'POST'),
			'meta_keyword'     => $this->r->get_string('meta_keyword', 'POST'),
			'meta_description' => $this->r->get_string('meta_description', 'POST'),
		);
		if (isset($_POST['img_page_video']) && $_POST['img_page_video'] == "1") {
			unset($video_setting['img']);
		}
		if (isset($_POST['icon_page_video']) && $_POST['icon_page_video'] == "1") {
			unset($video_setting['icon']);
		}
		if (isset($_POST['bg_page_video']) && $_POST['bg_page_video'] == "1") {
			unset($video_setting['bg']);
		}
		$this->settingObj->where('idw', $this->idw);
		//$this->settingObj->where('`key`','news_relateds');
		$exist = $this->settingObj->num_rows();
		if (!empty($exist)) {
			$this->settingObj->where('idw', $this->idw);
			$result = $this->settingObj->update($video_setting);
		} else {
			$result = $this->settingObj->insert($video_setting);
		}
		if ($result) {
			$return['status'] = true;
		} else {
			$return['status'] = false;
			$return['error']  = $this->settingObj->getLastError();
		}
		return $return;
	}
	public function saveSettingVideoCat() {
		global $_B;

		$related_cate = $this->r->get_array('related_cate', 'POST');
		if (!isset($related_cate['status'])) {
			$related_cate['status'] = 'off';
		}
		$related_related = $this->r->get_array('related_related', 'POST');

		if (!isset($related_related['status'])) {
			$related_related['status'] = 'off';
		}
		$nxt = array(
			'related_cate'    => $related_cate,
			'related_related' => $related_related,
		);
		$video_setting = array(
			'idw'         => $this->idw,
			'limit_video' => $this->r->get_string('limit_video', 'POST'),
			'related'     => json_encode($nxt),
		);

		$this->settingObj->where('idw', $this->idw);
		//$this->settingObj->where('`key`','news_relateds');
		$exist = $this->settingObj->num_rows();
		if (!empty($exist)) {
			$this->settingObj->where('idw', $this->idw);
			$result = $this->settingObj->update($video_setting);
		} else {
			$result = $this->settingObj->insert($video_setting);
		}
		if ($result) {
			$return['status'] = true;
		} else {
			$return['status'] = false;
			$return['error']  = $this->settingObj->getLastError();
		}
		return $return;
	}
	public function getSetting() {
		//$this->settingObj = new Model('vi_setting');
		$this->settingObj->where('idw', $this->idw);

		$results = $this->settingObj->getOne(null, '*');
		return $results;
	}
}