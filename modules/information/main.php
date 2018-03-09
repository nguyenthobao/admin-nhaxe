<?php

$_S['title_header']      = lang('title_header');
$_S['title_module']      = lang('title_module');
$_S['title_module_m']    = lang('title_module_m');
$_S['title_manager_mod'] = lang('title_manager_mod');
$_S['breadcrumb_mod']    = lang('breadcrumb_mod');
include_once DIR_ADDRESS;
$pages    = array('ajaxAdsFooter', 'informationbasic', 'ajax', 'ajaxwardid', 'footer', 'settingdomain', 'dns', 'ajaxLoadDns','closeweb');
$page     = $_B['r']->get_string('page', 'GET');
$nxt_more = array('settinglang', 'activemod','closeweb');

if (!in_array($_GET['page'], $nxt_more)) {
	if (!in_array($page, $pages)) {
		$page = 'home';
	}

	if (file_exists(DIR_MODULES . $mod . "/model/" . $page . ".php")) {
		include_once DIR_MODULES . $mod . "/model/" . $page . ".php";
	}

	include_once DIR_MODULES . $mod . "/controller/" . $page . ".php";

} else {

	include_once DIR_MODULES . $mod . "/controller/" . $page . ".php";
	include_once DIR_MODULES . $mod . "/model/settinglang.php";
	include_once DIR_MODULES . $mod . "/model/modelCloseweb.php";
	include_once DIR_MODULES . $mod . "/model/activemod.php";
	$controller = new $page;

	if (isset($_GET['sub'])) {
		$sub = $_GET['sub'];

		$controller->$sub();
	} else {
		$controller->index();
	}
	$content_module = $_DATA['content_module'];
}

// xoa session thong bao thao tac
//unset($_SESSION['success']);
//unset($_SESSION['error_submit']);