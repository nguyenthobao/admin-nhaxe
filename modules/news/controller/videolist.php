<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/category_list.php 
 * @Author Hồ Mạnh Hùng (hungdct1083@gmail.com)
 * @Createdate 08/21/2014, 14:27 PM
 */  
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
 
// thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('breadcrumb_manager_video');

$_S['title'] = lang('title_manager_video');
$_S['description'] = lang('description');

$get_lang = $_B['r']->get_string('lang','GET');
$addCategory = $_B['home'].'/'.$mod.'-video-lang-'.$get_lang;

//goi Model categorylist
$catList = new CategoryList();

$lang_use = explode(',',$_B['cf']['lang_use']);
//Get ngôn ngữ đã config trong db để set làm menu lang
foreach ($lang_use as $k => $v) {
	$url_lang[$v]['exist'] = '';
	$url_lang[$v]['url'] = '';
}
$cat = array();
if ($ad->tableExits($get_lang.'_video')) {
	$cat = $catList->getCatParent();
}

$content_module = $_B['temp']->load('videolist');
