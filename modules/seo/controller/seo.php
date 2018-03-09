<?php

if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
global $_DATA,$_B;
// thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('breadcrumb_template');
$_S['title']           = lang('title');
$_S['description']     = lang('description');

//goi Model Seo
$seos = new Seo();

//get request
$action        = $_B['r']->get_string('action', 'POST');
$action_delete = $_B['r']->get_string('delete', 'POST');
$continue      = $_B['r']->get_string('continue', 'POST');
$get_lang      = $_B['r']->get_string('lang', 'GET');
if (empty($get_lang)) {
	header("Location: " . $_B['home'] . '/' . $mod . '-seo-lang-vi');
} else {
	$id       = $_B['r']->get_int('id', 'GET');
	$lang_use = explode(',', $_B['cf']['lang_use']);
	if (!empty($id)) {
		$_S['breadcrumb_page'] = $_L['breadcrumb_seo'];
		foreach ($lang_use as $key => $v) {
			$url_lang[$v]['url'] = $_B['home'] . '/' . $mod . '-seo-' . $id . '-' . $v;
		}
	} else {
		//Get ngôn ngữ đã config trong db để set làm menu lang
		foreach ($lang_use as $k => $v) {

			$url_lang[$v]['url'] = $_B['home'] . '/' . $mod . '-seo-lang-' . $v;
		}

	}
	// Thực hiện action từ submit form. Tên action chính là tên function trong model
	if (!empty($action)) {
		$result = $seos->$action();
		if ($result['status']) {
			$_SESSION['success'] = lang('success');
			if ($continue == 'addgoogleid') {
				header("Location: " . $_B['home'] . '/' . $mod . '-seo-lang-' . $get_lang);
			} else if ($continue == 'addDomain') {
				header("Location: " . $_B['home'] . '/' . $mod . '-seo-lang-vi');
			} else if ($continue == 'addRobots') {
				header("Location: " . $_B['home'] . '/' . $mod . '-seo-lang-vi');
			} elseif ($continue == 'addGA') {
				header("Location: " . $_B['home'] . '/' . $mod . '-seo-lang-vi#tab_5');
			} else {
				header("Location: " . $_B['home'] . '/' . $mod . '-seo-lang-vi');
			}
			exit();
		} else {
			$_SESSION['error_submit'] = $result['error'];
		}
	}
	$getRobots      = $seos->getRobots();
	$getGA          = $seos->getGA();
	$seo 			= $seos->getConfigSeoUrl(); 
	$active_seo_url = $seo['value_int'];
	$custom_seo_url = json_decode($seo['value_string'],true);
	
	//Load theme cho page template
	$content_module = $_B['temp']->load('seo');
}
