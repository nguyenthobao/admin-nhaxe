<?php
/**
 * @Project BNC v2 -> Admin -> Album
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 */

/*
 * variable system
 */
$_B['cf']['lang_use'] = 'vi';
$_B['cf']['lang'] = 'vi';

 
$idw    = $_B['web']['idw']; //id web
$dfLang =  $_B['cf']['lang']; //default lang



// lang layout
$_S['title_header']      = lang('title_header');
$_S['title_module']      = lang('title_module');
$_S['title_module_m']    = lang('title_module_m');
$_S['title_manager_mod'] = lang('title_manager_mod');
$_S['breadcrumb_mod']    = lang('breadcrumb_mod');

$pages = array('category', 'categoryNew', 'categoryUpdate', 'albumNew', 'albumUpdate', 'ajax', 'uploads', 'setting', 'test');
$page  = $_B['r']->get_string('page', 'GET');

if (!in_array($page, $pages)) {
	$page = 'home';
}

include_once DIR_MODULES . $mod . "/model/global_album.php"; //Load model dùng chung

if (file_exists(DIR_MODULES . $mod . "/model/" . $page . ".php")) {
	include_once DIR_MODULES . $mod . "/model/" . $page . ".php";
}

include_once DIR_MODULES . $mod . "/controller/" . $page . ".php";