<?php
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
// thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('breadcrumb_hair_time');
$_S['title']           = lang('title');
$_S['description']     = lang('description');

$action   = $_B['r']->get_string('action','POST');
$continue = $_B['r']->get_string('continue','POST');
$get_lang = $_B['r']->get_string('lang','GET');

if(empty($get_lang)){
	$get_lang='vi';
}else{
		$id        = $_B['r']->get_int('id','GET');
		$lang_use  = explode(',',$_B['cf']['lang_use']);
	if (!empty($id)) {
		foreach ($lang_use as $key => $v) {
			$url_lang[$v]['url'] = $_B['home'].'/'.$mod.'-contactlist-'.$id.'-'.$v;
		}
	}else{
		//Get ngôn ngữ đã config trong db để set làm menu lang
		foreach ($lang_use as $k => $v) {
			if ($v=='vi') {
				$url_lang[$v]['url'] = $_B['home'].'/'.$mod.'-contactlist-lang-vi';	
			}else{
				//In url trang doi voi truong hop them noi dung.
				$url_lang[$v]['url']    = 'javascrip:void(0);';
				$url_lang[$v]['exist']  ='notExist';
			}
		}		
	}
	$content_module = $_B['temp']->load('hair_time_add');
}