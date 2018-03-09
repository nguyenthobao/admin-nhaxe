<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/infolist.php 
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/21/2014, 14:27 PM
 */  
if(!defined('BNC_CODE')) {
	exit('Access Denied');
}
// thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('title_manager_mod');
$_S['title'] = lang('title_manager_mod');
$_S['description'] = lang('description');

$infoList = new InfoList();

$action = $_B['r']->get_string('action','POST');
$continue = $_B['r']->get_string('continue','POST');
$get_lang = $_B['r']->get_string('lang','GET');

$addInfo = $_B['home'].'/'.$mod.'-info-lang-vi';
$deleteMultiID = $_B['home'].'/'.$mod.'-infolist-deleteMultiID-lang-vi';

$lang_use = explode(',',$_B['cf']['lang_use']);
//Get ngôn ngữ đã config trong db để set làm menu lang
foreach ($lang_use as $k => $v) {
	$url_lang[$v]['exist'] = '';
	$url_lang[$v]['url'] = '';
}
$info = array();
if ($ad->tableExits($get_lang.'_info')) {
	$info = $infoList->getInfo();
}
if (!empty($action)){
 	//xu ly rieng cho phan tim kiem;
	if($action =="searchInfo"){
		$value = json_encode($_POST);
		$value = base64_encode($value);
		header("Location:".$_B['home']."/".$mod.'-infolist-lang-'.$get_lang.'-value-'.$value);
	}else{
		$result = $infoList->$action();
		if ($result['status']) {
			$_SESSION['success'] = lang('success');
			header("Location:".$_B['home']."/".$mod.'-infolist-lang-'.$get_lang);
			exit();
		}else{
			$_SESSION['error_submit'] =  $result['notify_error'];
		}
	}  
}else{
	if (!empty($_GET['value'])) {
		$info = $infoList->searchInfo();

	}else{
		$info = $infoList->getInfo();		
	}
} 
$content_module = $_B['temp']->load('infolist');
