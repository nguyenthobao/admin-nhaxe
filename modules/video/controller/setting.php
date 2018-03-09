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

$name   = $_B['r']->get_string('name', 'POST');
$action = $_B['r']->get_string('action', 'POST');
//$get_lang = $_B['r']->get_string('lang','GET');

if ($name) {
	$action = $name;
}

$id = $_B['r']->get_int('key', 'POST');

include_once DIR_MODULES . $mod . "/model/setting.php";
include_once DIR_MODULES . $mod . "/model/video.php";
$setting             = new Setting();
$settings            = $setting->getSetting();
$settings['related'] = json_decode($settings['related'], true);

// echo json_encode($settings);
// die();

//$category = $newss->getCatParent();
// $search = $setting->searchNews();

if (empty($settings)) {
	header("Location: " . $_B['home'] . '/' . $mod . '-setting-lang-vi');
}

if (!empty($action)) {
	$result = $setting->$action();
	if ($result['status']) {
		$_SESSION['success'] = lang('success');
		if ($continue == 'saveSettingVideoCat') {
			header("Location: " . $_B['home'] . '/' . $mod . '-setting-lang-vi');
		} else if ($continue == 'saveSettingNewsHome') {
			header("Location: " . $_B['home'] . '/' . $mod . '-setting-lang-vi');
		} else {
			header("Location: " . $_B['home'] . '/' . $mod . '-setting-lang-vi');
		}

		exit();
	} else {
		$_SESSION['error_submit'] = $result['error'];
	}
}
//$related_news_vip = $newss->getNewsNotVip();

//	$related_news_hot = $newss->getNewsNotHot();

$content_module = $_B['temp']->load('setting');