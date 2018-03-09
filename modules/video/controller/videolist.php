<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/home.php
 * @Author Hồ Mạnh Hùng (hungdct1083@gmail.com)
 * @Createdate 08/21/2014, 14:27 PM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

// thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('breadcrumb_manager_video');

$_S['title']       = lang('title_manager_video');
$_S['description'] = lang('description');

$get_lang = $_B['r']->get_string('lang', 'GET');
$addVideo = $_B['home'] . '/' . $mod . '-video-lang-vi';

//goi Model Videolist
$catList = new VideoList();
//$videoMD= new Video();

$lang_use = explode(',', $_B['cf']['lang_use']);
//Get ngôn ngữ đã config trong db để set làm menu lang
foreach ($lang_use as $k => $v) {
	if ($v == 'vi') {
		$url_lang[$v]['url'] = $_B['home'] . '/' . $mod . '-videolist-lang-vi';
		//su dung de check khi add noi dung voi ngon ngu khac.
	} else {
		//In url trang doi voi truong hop them noi dung.
		$url_lang[$v]['url'] = $_B['home'] . '/' . $mod . '-videolist-' . 'lang' . '-' . $v;
		//$url_lang[$v]['exist']='notExist';
	}
}
$cat = array();

$action = $_B['r']->get_string('action', 'POST');

if (!empty($action)) {
	//xu ly rieng cho phan tim kiem;
	if ($action == "searchVideo") {
		$name         = $_B['r']->get_string('video_title', 'POST');
		$cat_id       = $_B['r']->get_int('cat_id', 'POST');
		$status_video = $_B['r']->get_string('status_video', 'POST');
		$is_vip       = $_B['r']->get_string('is_vip', 'POST');
		$is_hot       = $_B['r']->get_string('is_hot', 'POST');
		$post         = array(
			'video_title'  => $name,
			'cat_id'       => $cat_id,
			'status_video' => $status_video,
			'is_vip'       => $is_vip,
			'is_hot'       => $is_hot,
			'action'       => $action,
		);
		$value = json_encode($post);
		$value = base64_encode($value);
		header("Location:" . $_B['home'] . "/" . $mod . '-videolist-lang-' . $get_lang . '-value-' . $value);

	} else // cac action con lai
	{
		$result = $catList->$action();
		if ($result['status']) {
			$_SESSION['success'] = lang('success');
			header("Location:" . $_B['home'] . "/" . $mod . '-videolist-lang-' . $get_lang);
			exit();
		} else {
			$_SESSION['error_submit'] = $result['notify_error'];
		}
	}

} else {
	if (!empty($_GET['value'])) {
		$value = $_B['r']->get_string('value', 'GET');
		$value = base64_decode($value);
		$value = json_decode($value, 1);
	} else {
		$value = null;
	}

}

if ($ad->tableExits($get_lang . '_video')) {
	$cat = $catList->getCatVideo($value);
}
foreach ($lang_use  as $key => $value) {
	if ($value != $get_lang )
	{
		$_DATA['lang_use'][]=$value; 
	}	
}
$category = $catList->getCatParent();
global $_B;

foreach ($cat['data'] as $k => $v) {
	$cat['data'][$k]['link'] = $_B['web']['redirect'][0] . '/'.$cat['data'][$k]['alias'].'-1-9-' . $v['id'] . '.html';
	
}

$content_module = $_B['temp']->load('videolist');
