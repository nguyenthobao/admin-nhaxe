<?php

$_S['title_header']      = lang('title_header');
$_S['title_module']      = lang('title_module');
$_S['title_module_m']    = lang('title_module_m');
$_S['title_manager_mod'] = lang('title_manager_mod');
$_S['breadcrumb_mod']    = lang('breadcrumb_mod');
$pages                   = array('seo', 'ajax', 'tags','meta','redirecturl');
$more                    = array('tags','meta','redirecturl');
$page                    = $_B['r']->get_string('page', 'GET');
if (!in_array($page, $pages)) {
	$page = 'home';
}

    	
if (in_array($page, $more)) {

	include_once DIR_MODULES . $mod . "/model/tags.php";
	include_once DIR_MODULES . $mod . "/model/redirectUrl.php";
	include_once DIR_MODULES . $mod . "/model/meta.php";
	include_once DIR_MODULES . $mod . "/controller/" . $page . ".php";
	    	
	$sub        = (isset($_GET['sub'])) ? $_B['r']->get_string('sub', 'GET') : 'index';

	$controller = new $page;
		
	$controller->$sub();
	$content_module = $_DATA['content_module'];
} else {
	if (file_exists(DIR_MODULES . $mod . "/model/" . $page . ".php")) {
		include_once DIR_MODULES . $mod . "/model/" . $page . ".php";
	}
	include_once DIR_MODULES . $mod . "/controller/" . $page . ".php";
}

// xoa session thong bao thao tac
//unset($_SESSION['success']);
//unset($_SESSION['error_submit']);