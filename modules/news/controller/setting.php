<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/setting.php
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 11/01/2014, 13:32 PM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
// thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('breadcrumb_setting');
$_S['title']           = lang('title');
$_S['description']     = lang('description');

$name     = $_B['r']->get_string('name', 'POST');
$action   = $_B['r']->get_string('action', 'POST');
$get_lang = $_B['r']->get_string('lang', 'GET');

if ($name) {
	$action = $name;
}

$id = $_B['r']->get_int('key', 'POST');

include_once DIR_MODULES . $mod . "/model/setting.php";
include_once DIR_MODULES . $mod . "/model/news.php";
$setting = new Setting();
$newss   = new News();

$settings = $setting->getSetting();

// echo json_encode($settings);
// die();
if (!empty($settings['news_vip_id'])) {
	$newsVip = $newss->getNewsIds($settings['news_vip_id'], array('key' => 'is_vip', 'value' => 1));
}
if (!empty($settings['news_hot_id'])) {
	$newsHot = $newss->getNewsIds($settings['news_hot_id'], array('key' => 'is_hot', 'value' => 1));
}

$category = $newss->getCatParent();
// $search = $setting->searchNews();

if (empty($get_lang)) {
	//$content_module = $_B['temp']->load('template');
	header("Location: " . $_B['home'] . '/' . $mod . '-setting-lang-vi');
} else {
	$id       = $_B['r']->get_int('id', 'GET');
	$lang_use = explode(',', $_B['cf']['lang_use']);
	if (!empty($id)) {
		$_S['breadcrumb_page'] = $_L['title_setting_basic'];
		if ($get_lang == 'vi') {
			$sett = $setting->getSettingID();
		}
		foreach ($lang_use as $key => $v) {
			$url_lang[$v]['url'] = $_B['home'] . '/' . $mod . '-setting-' . $id . '-' . $v;
		}
	} else {
		//Get ngôn ngữ đã config trong db để set làm menu lang
		foreach ($lang_use as $k => $v) {
			//if ($v=='vi') {
			$url_lang[$v]['url'] = $_B['home'] . '/' . $mod . '-setting-lang-' . $v;
			//su dung de check khi add noi dung voi ngon ngu khac.
			// }else{
			// 	//In url trang doi voi truong hop them noi dung.
			// 	$url_lang[$v]['url'] = 'javascrip:void(0);';
			// 	$url_lang[$v]['exist']='notExist';
			// }
		}

	}

	if (!empty($action)) {
		$result = $setting->$action();
		if ($result['status']) {
			$_SESSION['success'] = lang('success');
			if ($continue == 'addSetting') {
				header("Location: " . $_B['home'] . '/' . $mod . '-setting-lang-' . $get_lang);
			} else if ($continue == 'saveSettingNewsHome') {
				header("Location: " . $_B['home'] . '/' . $mod . '-setting-lang-' . $get_lang);
			} else if ($continue == 'saveSetting') {
				header("Location: " . $_B['home'] . '/' . $mod . '-setting-lang-' . $get_lang);
			} else {
				header("Location: " . $_B['home'] . '/' . $mod . '-setting-lang-' . $get_lang);
			}
			exit();
		} else {
			$_SESSION['error_submit'] = $result['error'];
		}
	}
	$related_news_vip = $newss->getNewsNotVip();

	$related_news_hot = $newss->getNewsNotHot();

	$content_module = $_B['temp']->load('setting');
}