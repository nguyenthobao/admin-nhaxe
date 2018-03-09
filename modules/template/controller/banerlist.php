<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/bannerlist.php 
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

$get_lang = $_B['r']->get_string('lang','GET');

//Add category bắt buộc phải thêm tiếng việt trước
$addBanner = $_B['home'].'/'.$mod.'-banner-lang-vi';
$deleteMultiID = $_B['home'].'/'.$mod.'-bannerlist-deleteMultiID-lang-vi';

//goi Model categorylist
$bannerList = new BannerList();

$lang_use = explode(',',$_B['cf']['lang_use']);
//Get ngôn ngữ đã config trong db để set làm menu lang
foreach ($lang_use as $k => $v) {
	$url_lang[$v]['exist'] = '';
	$url_lang[$v]['url'] = '';
}
$banner = array();
if ($ad->tableExits($get_lang.'_banner')) {
	$banner = $bannerList->getBanner();
}
$action = $_B['r']->get_string('action','POST');
if (!empty($action)){
 	//xu ly rieng cho phan tim kiem;
 	if($action =="searchBanner"){
	  	$value = json_encode($_POST);
	  	$value = base64_encode($value);
	  	header("Location:".$_B['home']."/".$mod.'-bannerlist-lang-'.$get_lang.'-value-'.$value);
 	}else{
  		$result = $bannerList->$action();
  		if ($result['status']) {
			$_SESSION['success'] = lang('success');
			header("Location:".$_B['home']."/".$mod.'-bannerlist-lang-'.$get_lang);
			exit();
		}else{
			$_SESSION['error_submit'] =  $result['notify_error'];
		}
 	}  
}else{
	if (!empty($_GET['value'])) {
		$banner = $bannerList->searchBanner();
	 
	}else{
		$banner = $bannerList->getBanner();		
	}
} 
$content_module = $_B['temp']->load('bannerlist');
