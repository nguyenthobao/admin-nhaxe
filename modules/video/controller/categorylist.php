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
$_S['breadcrumb_page'] = lang('breadcrumb_manager_category');

$_S['title'] = lang('title_manager_category');
$_S['description'] = lang('description');

$get_lang = $_B['r']->get_string('lang','GET');
$addCategory = $_B['home'].'/'.$mod.'-category-lang-vi';

//goi Model categorylist
$catList = new CategoryList();

$lang_use = explode(',',$_B['cf']['lang_use']);
//Get ngôn ngữ đã config trong db để set làm menu lang
foreach ($lang_use as $k => $v) {
			if ($v=='vi') {
				$url_lang[$v]['url'] = $_B['home'].'/'.$mod.'-categorylist-lang-vi';
				//su dung de check khi add noi dung voi ngon ngu khac.
			}else{
				//In url trang doi voi truong hop them noi dung.
				$url_lang[$v]['url'] = $_B['home'].'/'.$mod.'-categorylist-lang-'.$v;
				$url_lang[$v]['exist']='notExist';
			}
		}
$cat = array();
if ($ad->tableExits($get_lang.'_category')) {
	$cat = $catList->getCatParent();
}
$action = $_B['r']->get_string('action','POST');

if (!empty($action)){
	$result = $catList->$action();
	if ($result['status']) { 
		$_SESSION['success'] = lang('success');
		header("Location:".$_B['home']."/".$mod.'-categorylist-lang-'.$get_lang);
		exit();
	}
	else{
		$_SESSION['error_submit'] = lang('success') ."(".$result['error'].")";
	}
			
}
foreach ($lang_use  as $key => $value) {
	if ($value != $get_lang )
	{
		$_DATA['lang_use'][]=$value; 
	}	
}
$content_module = $_B['temp']->load('categorylist');
