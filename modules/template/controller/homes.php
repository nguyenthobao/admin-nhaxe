<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/template.php 
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 10/13/2014, 16:10 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
// thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('homes_manager');
$_S['title'] = lang('title');
$_S['description'] = lang('description');

//get 
$get_lang = $_B['r']->get_string('lang','GET');



$temp = new Temp(); 

if (!empty($action)){
	$result = $logo_web->$action();
	if ($result['status']) {
		$_SESSION['success'] = lang('success');
	}
	else
	{
		$_SESSION['error_submit'] = $result['error'];
	}
}
$web['modules'] = array(
	0 => 'allmod',
	1 => 'news',  
	3 => 'album',
	4 => 'video', 
	6 => 'info', 
	8 => 'contact',
	9 => 'category',
); 
$module = 'allmod';

  

$subs = array('ajax','index');
$sub = $_B['r']->get_string('sub','GET');
 
if (!in_array($sub, $subs)){
    $sub = 'index';
}  
 
//Get ngôn ngữ đã config trong db để set làm menu lang
$lang_use = explode(',',$_B['cf']['lang_use']);
foreach ($lang_use as $k => $v) { 
	    $url_lang[$v]['url'] = $_B['home'].'/'.$mod.'-homes-lang-'.$v; 
}

 
$return  = $temp->$sub();
 

 
$blocks = $return['homes'];
$count = $return['count'];
$blockUse = $return['homeUse']; 
 
// echo '<pre>';
// var_dump($blockUse);
// die;
//Load theme cho page template
$current_page = $_SERVER['REQUEST_URI'];
$content_module = $_B['temp']->load('homes');
//echo $current_page;
 




