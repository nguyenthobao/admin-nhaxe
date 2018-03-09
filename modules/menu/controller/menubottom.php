<?php
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
// thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('breadcrumb_new_menu');
$_S['title']           = lang('title');
$_S['description']     = lang('description');

$action   = $_B['r']->get_string('action', 'POST');
$continue = $_B['r']->get_string('continue', 'POST');
$get_lang = $_B['r']->get_string('lang', 'GET');

if (empty($get_lang)) {
	$get_lang = 'vi';
} else {
	$id = $_B['r']->get_int('id', 'GET');
	if (!empty($id)) {
		$_S['breadcrumb_page'] = lang('breadcrumb_edit_menu');
	}
	$lang_use = explode(',', $_B['cf']['lang_use']);
	if (!empty($id)) {
		foreach ($lang_use as $key => $v) {
			$url_lang[$v]['url'] = $_B['home'] . '/' . $mod . '-menubottom-' . $id . '-' . $v;
		}
	} else {
		//Get ngôn ngữ đã config trong db để set làm menu lang
		foreach ($lang_use as $k => $v) {
			if ($v == 'vi') {
				$url_lang[$v]['url'] = $_B['home'] . '/' . $mod . '-menubottom-lang-vi';
			} else {
				//In url trang doi voi truong hop them noi dung.
				$url_lang[$v]['url']   = 'javascrip:void(0);';
				$url_lang[$v]['exist'] = 'notExist';
			}
		}

	}

//goi Model Contactlist
	$menubottom = new MenuBottom();

	// Thực hiện action từ submit form. Tên action chính là tên function trong model
	if (!empty($action)) {
		$result = $menubottom->$action();
		if ($result['status']) {
			$_SESSION['success'] = lang('success');
			if ($continue == 'menulistbottom') {
				header("Location: " . $_B['home'] . '/' . $mod . '-menulistbottom-lang-' . $get_lang);
			} else if ($continue == 'menubottom') {
				header("Location: " . $_B['home'] . '/' . $mod . '-menubottom-lang-' . $get_lang);
			} else {
				header("Location: " . $_B['home'] . '/' . $mod . '-' . 'menulistbottom' . '-lang-vi');
			}
			exit();
		} else {
			$_SESSION['error_submit'] = $result['error'];
		}
	}
	//Load page basic
	$pageBasic = new nxt_global;
	$pageBs    = $pageBasic->pageBasic();

	//Load theme cho page contactinfo
	$info_data = $menubottom->getMenuBottom($id);

	$menuparent = $menubottom->getParentid();
	$list_cat   = $menubottom->merge_category();
	$list_cat   = array_merge($pageBs, $list_cat);
	if ($info_data) {
		$direct_link = json_decode($info_data['direct_link'], true);
	}
	$content_module = $_B['temp']->load('menubottom');

}