<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/slide.php
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/15/2014, 16:57 PM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
// thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('breadcrumb_add_slide');
$_S['title']           = lang('title');
$_S['description']     = lang('description');

$slides = new Slide();

//get request
$action   = $_B['r']->get_string('action', 'POST');
$continue = $_B['r']->get_string('continue', 'POST');
$get_lang = $_B['r']->get_string('lang', 'GET');
if (empty($get_lang)) {
	$content_module = $_B['temp']->load('home');
} else {
	$id       = $_B['r']->get_int('id', 'GET');
	$lang_use = explode(',', $_B['cf']['lang_use']);
	if (!empty($id)) {

		//if ($get_lang == 'vi') {
		$slide = $slides->getSlideID();

		$active_mod_tmp = explode(',', $slide['active_mod']);

		$active_mod = array();
		foreach ($active_mod_tmp as $k => $v) {
			if ($v != '') {
				$active_mod[] = $v;
			}

		}

		foreach ($lang_use as $key => $v) {
			$url_lang[$v]['url'] = $_B['home'] . '/' . $mod . '-slide-' . $id . '-' . $v;
		}
	} else {
		//Get ngôn ngữ đã config trong db để set làm menu lang
		foreach ($lang_use as $k => $v) {
			if ($v == 'vi') {
				$url_lang[$v]['url'] = $_B['home'] . '/' . $mod . '-slide-lang-vi';
				//su dung de check khi add noi dung voi ngon ngu khac.
			} else {
				//In url trang doi voi truong hop them noi dung.
				$url_lang[$v]['url']   = 'javascrip:void(0);';
				$url_lang[$v]['exist'] = 'notExist';
			}
		}
	}
	if (!empty($action)) {
		$result = $slides->$action();
		if ($result['status']) {
			$_SESSION['success'] = lang('success');
			if ($continue == 'slide_lang') {
				header("Location: " . $_B['home'] . '/' . $mod . '-slide-' . $result['last_id'] . '-' . $get_lang);
			} else if ($continue == 'slidelist') {
				header("Location: " . $_B['home'] . '/' . $mod . '-' . $continue . '-lang-' . $get_lang);
			} else {
				header("Location: " . $_B['home'] . '/' . $mod . '-' . $continue . '-lang-vi');
			}
			exit();
		} else {
			$_SESSION['error_submit'] = $result['error'];
		}
	}
	$slide_edit = $slides->getSlideByID();
	if (isset($slide_edit['title'])) {
		$_S['breadcrumb_page'] = $_L['breadcrumb_edit_slide'];
	}
	$positions = $global_block_nxt->routerPosition();
	//Load theme cho page add slide
	$content_module = $_B['temp']->load('slide');
}
