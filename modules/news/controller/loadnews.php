<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/loadnews.php
 * @Author Nguyen Ba Huong (nguyenbahuong156@gmail.com)
 * @Createdate 08/15/2014, 16:57 PM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
include_once DIR_MODULES . 'news/model/autoNews/autoNews.php';
// thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('breadcrumb_loadnews');
$_S['title']           = lang('title');
$_S['description']     = lang('description');

$action   = $_B['r']->get_string('action', 'POST');
$autoNews = new autoNews();

$category = $autoNews->getCatSearch();

if (!empty($action)) {
	$result = $autoNews->$action();
	if ($result['status']) {
		$_SESSION['success'] = lang('success');
		if ($continue == 'news_lang') {
			header("Location: " . $_B['home'] . '/' . $mod . '-news-' . $result['last_id'] . '-' . $get_lang);
		} else if ($continue == 'newslist') {
			header("Location: " . $_B['home'] . '/' . $mod . '-' . $continue . '-lang-' . $get_lang);
		} else {
			header("Location: " . $_B['home'] . '/' . $mod . '-' . $continue . '-lang-vi');
		}
		exit();
	} else {
		$_SESSION['error_submit'] = $result['error'];
	}
}
//Load theme cho page add info
$content_module = $_B['temp']->load('loadnews');
