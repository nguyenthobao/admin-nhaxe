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

$lang_use = explode(',', $_B['cf']['lang_use']);

if (!empty($id)) {
	$content = $blockcustom->getByID($id);
	foreach ($lang_use as $key => $v) {
		$url_lang[$v]['url'] = $_B['home'] . '/' . $mod . '-blockcustomadd-' . $id . '-' . $v;
	}
} else {
	//Get ngôn ngữ đã config trong db để set làm menu lang
	foreach ($lang_use as $k => $v) {
		if ($v == 'vi') {
			$url_lang[$v]['url'] = $_B['home'] . '/' . $mod . '-blockcustomadd-lang-vi';
			//su dung de check khi add noi dung voi ngon ngu khac.
		} else {
			//In url trang doi voi truong hop them noi dung.
			$url_lang[$v]['url']   = 'javascript:void(0);';
			$url_lang[$v]['exist'] = 'notExist';
		}
	}
}

$all = $blockcustom->getAll();

foreach ($all['data'] as $k => $v) {
	$v['link_edit']      = $_B['home'] . '/' . $mod . '-blockcustomadd-' . $v['id'] . '-' . $_GET['lang'];
	$content['data'][$k] = $v;
}
$content['pagination'] = @$all['pagination'];

$positions = $global_block_nxt->routerPosition();

$content_module = $_B['temp']->load('blockcustom');