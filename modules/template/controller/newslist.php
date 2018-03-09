<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/category_list.php 
 * @Author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
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
$addNews = $_B['home'].'/'.$mod.'-news-lang-vi';
$deleteMultiID = $_B['home'].'/'.$mod.'-newslist-deleteMultiID-lang-vi';

//goi Model categorylist
$newsList = new NewsList();

$lang_use = explode(',',$_B['cf']['lang_use']);
//Get ngôn ngữ đã config trong db để set làm menu lang
foreach ($lang_use as $k => $v) {
	$url_lang[$v]['exist'] = '';
	$url_lang[$v]['url'] = '';
}
$news = array();
if ($ad->tableExits($get_lang.'_news')) {
	$news = $newsList->getNews();
}
$category = $newsList->getCatParent();
$action = $_B['r']->get_string('action','POST');

if (!empty($action)){
 //xu ly rieng cho phan tim kiem;
 	if($action =="searchNews"){
	  	$value = json_encode($_POST);
	  	$value = base64_encode($value);
	  	header("Location:".$_B['home']."/".$mod.'-newslist-lang-'.$get_lang.'-value-'.$value);
 	}else{
  		$result = $newsList->$action();
  		if ($result['status']) {
			$_SESSION['success'] = lang('success');
			header("Location:".$_B['home']."/".$mod.'-newslist-lang-'.$get_lang);
			exit();
		}else{
			$_SESSION['error_submit'] =  $result['notify_error'];
		}
 	}  
}else{
	if (!empty($_GET['value'])) {
		$news = $newsList->searchNews();
	 
	}else{
		$news = $newsList->getNews();
	}
} 
$content_module = $_B['temp']->load('newslist');
