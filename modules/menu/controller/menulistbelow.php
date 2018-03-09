<?php
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}


$_S['breadcrumb_page'] = lang('breadcrumb_menu_below');
$_S['title']           = lang('title');
$_S['description']     = lang('description');

$get_lang 	 = $_B['r']->get_string('lang','GET');
$id        	 = $_B['r']->get_int('id','GET');
$action      = $_B['r']->get_string('action','POST');
$addCategory = $_B['home'].'/'.$mod.'-menubelow-lang-'.$get_lang;

if(empty($get_lang)){
	$get_lang	=	'vi';
}
	$lang_use   = explode(',',$_B['cf']['lang_use']);
	if (!empty($id)) {
		foreach ($lang_use as $key => $v) {
			$url_lang[$v]['url'] = $_B['home'].'/'.$mod.'-menulistbelow-'.$id.'-'.$v;
		}
	}else{
	//Get ngôn ngữ đã config trong db để set làm menu lang
		foreach ($lang_use as $k => $v) {
			if ($v=='vi') {
			$url_lang[$v]['url']    = $_B['home'].'/'.$mod.'-menulistbelow-lang-vi';	
			}else{
			//In url trang doi voi truong hop them noi dung.
			$url_lang[$v]['url']    = 'javascrip:void(0);';
			$url_lang[$v]['exist']  ='notExist';
			}
		}
	}
//Gọi module feedback
$menulist =new MenuListBelow();
if (!empty($action)){
			$result = $menulist->$action();
			if ($result['status']) { 
				$_SESSION['success'] = lang('success');
				header("Location:".$_B['home']."/".$mod.'-menulistbelow-lang-'.$get_lang);
				exit();
			}
			else{
				$_SESSION['error_submit'] = lang('success') ."(".$result['error'].")";
			} 
			
	} 
$menu =$menulist->getMenuListBelow();
//load theme cho page feedbacklist
$content_module = $_B['temp']->load('menulistbelow');
