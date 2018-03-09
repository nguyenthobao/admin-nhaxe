<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/banner.php 
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/15/2014, 16:57 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
// thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('breadcrumb_banner');
$_S['title'] = lang('title');
$_S['description'] = lang('description');

$banners = new Banner();

//get request
$action = $_B['r']->get_string('action','POST');
$continue = $_B['r']->get_string('continue','POST');
$get_lang = $_B['r']->get_string('lang','GET');
if(empty($get_lang)){
	$content_module = $_B['temp']->load('home');
}else{
	$id = $_B['r']->get_int('id','GET');
	$lang_use = explode(',',$_B['cf']['lang_use']);
	if (!empty($id)) {
		$_S['breadcrumb_page'] = $_L['breadcrumb_editbanner'];
		if ($get_lang=='vi') {
				$banner = $banners->getBannerID();
		}
		foreach ($lang_use as $key => $v) {
			$url_lang[$v]['url'] = $_B['home'].'/'.$mod.'-banner-'.$id.'-'.$v;
		}
	}else{
		//Get ngôn ngữ đã config trong db để set làm menu lang
		foreach ($lang_use as $k => $v) {
			if ($v=='vi') {
				$url_lang[$v]['url'] = $_B['home'].'/'.$mod.'-banner-lang-vi';
				//su dung de check khi add noi dung voi ngon ngu khac.
			}else{
				//In url trang doi voi truong hop them noi dung.
				$url_lang[$v]['url'] = 'javascrip:void(0);';
				$url_lang[$v]['exist']='notExist';
			}
		}		
	}
	if (!empty($action)){
		$result = $banners->$action();
		if ($result['status']) {
			$_SESSION['success'] = lang('success');
			if ($continue=='banner_lang'){
				header("Location: ".$_B['home'].'/'.$mod.'-banner-'.$result['last_id'].'-'.$get_lang);
			}else if($continue=='bannerlist'){
				header("Location: ".$_B['home'].'/'.$mod.'-'.$continue.'-lang-'.$get_lang);
			}else{
				header("Location: ".$_B['home'].'/'.$mod.'-'.$continue.'-lang-vi');
			}
			exit();
		}
		else{
			$_SESSION['error_submit'] = $result['error'];
		}
	}
	$banner_edit = $banners->getBannerByID();
	
	//Load theme cho page add banner
	$content_module = $_B['temp']->load('banner');
}

