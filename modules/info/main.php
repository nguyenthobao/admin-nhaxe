<?php

$_S['title_header'] = lang('title_header');
$_S['title_module'] = lang('title_module');
$_S['title_module_m'] = lang('title_module_m');
$_S['title_manager_mod'] = lang('title_manager_mod');
$_S['breadcrumb_mod'] = lang('breadcrumb_mod');
$pages = array('info','infolist','ajaxinfo');
$page = $_B['r']->get_string('page','GET');
if (!in_array($page, $pages)) {
	$page = 'home';	
}
include_once(DIR_MODULES.$mod."/model/global_info.php");
if (file_exists(DIR_MODULES.$mod."/model/".$page.".php")) {
	include_once(DIR_MODULES.$mod."/model/".$page.".php");
}
include_once(DIR_MODULES.$mod."/controller/".$page.".php");
