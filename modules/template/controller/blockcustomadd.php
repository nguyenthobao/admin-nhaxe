<?php
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
// thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('breadcrumb_customblock');
$_S['title']           = lang('title');
$_S['description']     = lang('description');

//get
$get_lang = $_B['r']->get_string('lang', 'GET');
$id       = $_B['r']->get_int('id', 'GET');

$lang_use = explode(',', $_B['cf']['lang_use']);

if (!empty($id)) {
	$content = $blockcustom->getByID($id);
	if ($content['active_mod'] != ',all,') {
		$active_mod_tmp = explode(',', $content['active_mod']);
		$active_mod     = array();
		foreach ($active_mod_tmp as $k => $v) {
			if ($v != '') {
				$active_mod[] = $v;
			}
		}
	} else {
		$active_mod = $mod_in_home;
	}
	$json_decode     = json_decode($content['data_custome'], true);
	$content['css']  = $json_decode['css'];
	$content['html'] = $json_decode['html'];

	foreach ($lang_use as $key => $v) {
		$url_lang[$v]['url'] = $_B['home'] . '/' . $mod . '-blockcustomadd-' . $id . '-' . $v;
	}
} else {
	//Get ngôn ngữ đã config trong db để set làm menu lang
	foreach ($lang_use as $k => $v) {
		//if ($v == 'vi') {
		$url_lang[$v]['url'] = $_B['home'] . '/' . $mod . '-blockcustomadd-lang-' . $v;
		//su dung de check khi add noi dung voi ngon ngu khac.
		// } else {
		// 	//In url trang doi voi truong hop them noi dung.
		// 	$url_lang[$v]['url']   = 'javascript:void(0);';
		// 	$url_lang[$v]['exist'] = 'notExist';
		// }
	}
}
//Save
$action   = $_B['r']->get_string('action', 'POST');
$continue = $_B['r']->get_string('continue', 'POST');
if (!empty($action)) {

	$result = $blockcustom->$action();
	if ($result['status']) {
		$_SESSION['success'] = lang('success');
		if ($continue == 'blockcustom_lang') {
			header("Location: " . $_B['home'] . '/' . $mod . '-blockcustomadd-' . $result['last_id'] . '-' . $get_lang);
		} else if ($continue == 'blockcustom') {
			header("Location: " . $_B['home'] . '/' . $mod . '-' . $continue . '-lang-' . $get_lang);
		} else {
			header("Location: " . $_B['home'] . '/' . $mod . '-' . $continue . '-lang-vi');
		}
		exit();
	} else {
		$_SESSION['error_submit'] = $result['error'];
	}
}

$position = $global_block_nxt->routerPosition();

$content_module = $_B['temp']->load('blockcustomadd');