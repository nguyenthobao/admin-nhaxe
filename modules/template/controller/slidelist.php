<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/slidelist.php
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/21/2014, 14:27 PM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
// thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('title_manager_slide');

$_S['title']       = lang('title_manager_slide');
$_S['description'] = lang('description');

$get_lang = $_B['r']->get_string('lang', 'GET');

//Add category bắt buộc phải thêm tiếng việt trước
$addSlide      = $_B['home'] . '/' . $mod . '-slide-lang-vi';
$deleteMultiID = $_B['home'] . '/' . $mod . '-slidelist-deleteMultiID-lang-vi';

//goi Model categorylist
$slideList = new SlideList();

$lang_use = explode(',', $_B['cf']['lang_use']);
//Get ngôn ngữ đã config trong db để set làm menu lang
foreach ($lang_use as $k => $v) {
	$url_lang[$v]['exist'] = '';
	$url_lang[$v]['url']   = '';
}
$slide = array();
if ($ad->tableExits($get_lang . '_slide')) {
	$slide = $slideList->getSlide();
}
$action = $_B['r']->get_string('action', 'POST');
if (!empty($action)) {
	//xu ly rieng cho phan tim kiem;
	if ($action == "searchSlide") {
		$value = json_encode($_POST);
		$value = base64_encode($value);
		header("Location:" . $_B['home'] . "/" . $mod . '-slidelist-lang-' . $get_lang . '-value-' . $value);
	} else {
		$result = $slideList->$action();
		if ($result['status']) {
			$_SESSION['success'] = lang('success');
			header("Location:" . $_B['home'] . "/" . $mod . '-slidelist-lang-' . $get_lang);
			exit();
		} else {
			$_SESSION['error_submit'] = $result['notify_error'];
		}
	}
} else {
	if (!empty($_GET['value'])) {
		$slide = $slideList->searchSlide();

	} else {
		$slide = $slideList->getSlide();
	}
}
$positions      = $global_block_nxt->routerPosition();
$content_module = $_B['temp']->load('slidelist');
