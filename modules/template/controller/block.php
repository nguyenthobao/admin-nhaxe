<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/template.php
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 10/13/2014, 16:10 PM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
// thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('breadcrumb_block');
$_S['title']           = lang('title');
$_S['description']     = lang('description');

//get
$get_lang = $_B['r']->get_string('lang', 'GET');

//echo '<pre>'; var_dump($mod_in_home); die;

$temp = new Temp();

if (!empty($action)) {
	$result = $logo_web->$action();
	if ($result['status']) {
		$_SESSION['success'] = lang('success');
	} else {
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
);
//$web['positions'] = array(1 => 'top', 2 => 'right', 3 => 'bottom', 4 => 'left');
$routerPosition = $global_block_nxt->routerPosition();
$module         = 'allmod';

$subs = array('ajax', 'index');
$sub  = $_B['r']->get_string('sub', 'GET');
$id   = $_B['r']->get_int('id', 'GET');
$id   = (empty($id)) ? 4 : $id;

if (!in_array($sub, $subs)) {
	$sub = 'index';
}
$nowPosition = $routerPosition[$id];
//Get ngôn ngữ đã config trong db để set làm menu lang
$lang_use = explode(',', $_B['cf']['lang_use']);
foreach ($lang_use as $k => $v) {
	$url_lang[$v]['url'] = $_B['home'] . '/' . $mod . '-block-' . $id . '-lang-' . $v;
}

foreach ($routerPosition as $key => $value) {
	$url_pos[$key] = $_B['home'] . '/' . $mod . '-block-' . $key . '-lang-' . $get_lang . '#lang_tab_bar';
}

if ($sub == 'ajax') {
	$return = $temp->$sub();
} else {

	$return = $temp->$sub($id);
}

$blocks    = $return['blocks'];
$count     = $return['count'];
$blockUse  = $return['blockUse'];
$activeUse = array();

foreach ($blockUse as $k => $v) {
	if (!empty($v)) {
		foreach ($v as $k2 => $v2) {
			$v2['active_mod']=str_replace(' ', '', $v2['active_mod']);
			if($v2['active_mod']==',all,'){
				$activeUse[$v2['id']]=$mod_in_home;
			}else{
				$activeUse[$v2['id']] = array_values(array_filter(explode(',', $v2['active_mod'])));	
			}
		}
	}
}
// if ($_COOKIE['sv']) {
//             var_dump($blockUse);
// }

//Load theme cho page template
$current_page   = $_SERVER['REQUEST_URI'];
$content_module = $_B['temp']->load('block');
//echo $current_page;
