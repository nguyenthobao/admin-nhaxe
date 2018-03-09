<?php
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
//thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('breadcrumb_information');
$_S['title']           = lang('title');
$_S['description']     = lang('description');

$action   = $_B['r']->get_string('action', 'POST');
$continue = $_B['r']->get_string('continue', 'POST');
$get_lang = $_B['r']->get_string('lang', 'GET');

if (empty($get_lang)) {
	$get_lang = 'vi';
} else {
	$id       = $_B['r']->get_int('id', 'GET');
	$lang_use = explode(',', $_B['cf']['lang_use']);
	if (!empty($id)) {
		foreach ($lang_use as $key => $v) {
			$url_lang[$v]['url'] = $_B['home'] . '/' . $mod . '-informationbasic-' . $id . '-' . $v;
		}
	} else {
		//Get ngôn ngữ đã config trong db để set làm menu lang
		foreach ($lang_use as $k => $v) {
			if ($v == 'vi') {
				$url_lang[$v]['url'] = $_B['home'] . '/' . $mod . '-informationbasic-lang-vi';
			} else {
				//In url trang doi voi truong hop them noi dung.
				$url_lang[$v]['url']   = 'javascrip:void(0);';
				$url_lang[$v]['exist'] = 'notExist';
			}
		}

	}

//goi Model informationbasic
	$informationbasic = new InformationBasic();
	$advertisers_edit = $informationbasic->getInformation();

	//Thực hiện action từ submit form. Tên action chính là tên function trong model
	if (!empty($action)) {
 

		$result = $informationbasic->$action();

		if ($result['status']==true) {
			$_SESSION['success'] = lang('success');
			header("Location:" . $_B['home'] . "/" .$mod.'-informationbasic-lang-' . $get_lang);
			exit();
		} else {
			$_SESSION['error_submit'] = $result['error'];
		}
	}
	// $url = API_URL.'getProvince';
	//$information=$informationbasic->postpage($url);
	$address     = new Address;
	$information = $address->getProvince();
	//Load theme cho page informationbasic
	$content_module = $_B['temp']->load('informationbasic');
}