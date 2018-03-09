<?php

$_S['title_header']      = lang('title_header');
$_S['title_module']      = lang('title_module');
$_S['title_module_m']    = lang('title_module_m');
$_S['title_manager_mod'] = lang('title_manager_mod');
$_S['breadcrumb_mod']    = lang('breadcrumb_mod');
$page                    = $_B['r']->get_string('page', 'GET');
$sub                     = $_B['r']->get_string('sub', 'GET');
if(empty($page)){
	$page='menu';
}
if(empty($sub)){
	$sub='menutop';
}


if ($page == 'menu') {
	require_once DIR_MODULES . $mod . '/controller/' . $page . '.php';
	
	$controller = new $page();
	if (!empty($sub)) {
		$controller->$sub();
	}
	if (!empty($_DATA['content_module'])) {
		$content_module = $_DATA['content_module'];
	}
}
