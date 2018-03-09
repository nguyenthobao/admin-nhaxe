<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/news.php 
 * @Author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 08/15/2014, 16:36 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}  
$_S['breadcrumb_page'] = $_L['breadcrumb_addnew'];
$news = new News();
$action = $_B['r']->get_string('action','POST');
$continue = $_B['r']->get_string('continue','POST');

if (!empty($action)){
		$result = $news->$action();
		if ($result['status']) { 
			$_SESSION['success'] =$_L['success_addnews'];
			header("Location: ".$_B['home'].'/'.$mod.'-'.$continue);
		}
		else{
			$_SESSION['error_submit'] ='aaa';

		} 
}
	
$id = $_B['r']->get_int('id','GET');
if (!empty($id)) {
	$data['id'] = $news->getNew($id);
	$_S['breadcrumb_page'] = $_L['breadcrumb_editnew'];
}

$content_module = $_B['temp']->load('news');

