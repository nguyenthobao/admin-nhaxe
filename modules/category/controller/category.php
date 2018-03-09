<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/news.php
 * @Author Mạnh Hùng (hungdct1083@gmail.com)
 * @Createdate 08/15/2014, 16:36 PM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
$_S['breadcrumb_page']     = $_L['breadcrumb_addcategory'];
$_S['breadcrumb_page_cat'] = $_L['breadcrumb_addcategory'];

$categoMD = new Category();
$action   = $_B['r']->get_string('action', 'POST');
$continue = $_B['r']->get_string('continue', 'POST');
$get_lang = $_B['r']->get_string('lang', 'GET');

if (empty($get_lang)) {
	$get_lang = 'vi';

}
$id       = $_B['r']->get_int('id', 'GET');
$lang_use = explode(',', $_B['cf']['lang_use']);
if (!empty($id)) {

	foreach ($lang_use as $key => $v) {
		$url_lang[$v]['url'] = $_B['home'] . '/' . $mod . '-category-' . $id . '-' . $v;
	}
} else {
	//Get ngôn ngữ đã config trong db để set làm menu lang
	foreach ($lang_use as $k => $v) {
		if ($v == 'vi') {
			$url_lang[$v]['url'] = $_B['home'] . '/' . $mod . '-category-lang-vi';
			//su dung de check khi add noi dung voi ngon ngu khac.
		} else {
			//In url trang doi voi truong hop them noi dung.
			$url_lang[$v]['mes']   = 'Bạn phải đăng ngôn ngữ mặc định trước';
			$url_lang[$v]['exist'] = 'notExist';
			$url_lang[$v]['url']   = $_B['home'] . '/' . $mod . '-category-lang-vi';
		}
	}
	//$category = $categoMD->getCatParentVD();
}

if (!empty($action)) {
	$result = $categoMD->$action();
	if ($result['status']) {
		$_SESSION['success'] = lang('success');
		if ($continue == 'category_lang') {
			header("Location: " . $_B['home'] . '/' . $mod . '-category-' . $result['last_id'] . '-' . $get_lang);
		} else if ($continue == 'categorylist') {
			header("Location: " . $_B['home'] . '/' . $mod . '-' . $continue . '-lang-' . $get_lang);
		} else {
			header("Location: " . $_B['home'] . '/' . $mod . '-' . $continue . '-lang-' . $get_lang);
		}
		exit();
	} else {
		$_SESSION['error_submit'] = $result['error'];
	}
}
$cat = $categoMD->getCategoryByID($id);
if ($cat == 'notTranslate') {
	$_SESSION['error_submit'] = lang('notTranslate');
	header("Location: " . $_B['home'] . '/' . $mod . '-categorylist-lang-vi');
	exit();
}

if (isset($cat['title'])) {
	$_S['breadcrumb_page']     = $_L['breadcrumb_editcategory'];
	$_S['breadcrumb_page_cat'] = $_L['breadcrumb_editcategory'];
}

$content_module = $_B['temp']->load('category');
