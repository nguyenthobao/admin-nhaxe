<?php
/**
 * @Project BNC v2 -> Admin -> Album
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

/**
 * add category controller
 */

// lang layout
$_S['breadcrumb_page'] = lang('breadcrumb_category_new');
$_S['title']           = lang('title');
$_S['description']     = lang('description');

//get request
$action   = $_B['r']->get_string('action', 'POST');
$continue = $_B['r']->get_string('continue', 'POST');
$get_lang = $_B['r']->get_string('lang', 'GET');

if ($get_lang != $dfLang) {
	header("Location: " . $_B['home'] . '/' . $mod . '-categoryNew-lang-' . $dfLang);
}
//ve ngon ngu mac dinh

//lang menu link
$lang_use = explode(',', $_B['cf']['lang_use']);

//Get ngôn ngữ đã config trong db để set làm menu lang
foreach ($lang_use as $k => $v) {
	if ($v == $dfLang) {
		$url_lang[$v]['url']   = $_B['home'] . '/' . $mod . '-categoryNew-lang-' . $dfLang;
		$url_lang[$v]['exist'] = '';
		//su dung de check khi add noi dung voi ngon ngu khac.
	} else {
		//In url trang doi voi truong hop them noi dung.
		$url_lang[$v]['url']   = 'Javascript:;';
		$url_lang[$v]['exist'] = 'notExist';
	}
}

$category     = new categoryNew();
$categoryMenu = $category->getCatParent(); // de lam select menu

if ($_POST) {
// post action

	if (!empty($action) AND $action == 'addCategory') {
/*
 * post data
 */
		$category->title                = $category->txt_string($_B['r']->get_string('title', 'POST'));
		$category->contents_description = $_B['r']->get_string('contents_description', 'POST');
		$category->status               = $_B['r']->get_int('status', 'POST');
		$category->create_time          = time();
		$category->meta_title           = $_B['r']->get_string('meta_title', 'POST');
		$category->meta_keywords        = $_B['r']->get_string('meta_keywords', 'POST');
		$category->meta_description     = $_B['r']->get_string('meta_description', 'POST');
		$category->order_by             = $_B['r']->get_int('order_by', 'POST');
		$category->parent_id            = $_B['r']->get_int('parent_id', 'POST');
		$category->alias                = fixTitle($_B['r']->get_string('alias', 'POST'));
		$category->is_home              = $_B['r']->get_int('is_home', 'POST');
		$category->limit              = $_B['r']->get_int('limit', 'POST');
/*
 * image upload
 */
		//upload
		include DIR_HELPER_UPLOAD;
		$options = array('max_size' => 1600);
		$upload  = new BncUpload($options);

		$avatarUpload = '';
		if ($_FILES['avatar']) {
			$avatarUpload = $upload->upload($idw, 'album', 'avatar');
		}
		if (!empty($avatarUpload)) {
			$avatar = $avatarUpload;
		} else {
			$avatar = null;
		}

		$iconUpload = '';
		if ($_FILES['icon']) {
			$iconUpload = $upload->upload($idw, 'album', 'icon');
		}
		if (!empty($iconUpload)) {
			$icon = $iconUpload;
		} else {
			$icon = null;
		}

		$bg_imageUpload = '';
		if ($_FILES['bg_image']) {
			$bg_imageUpload = $upload->upload($idw, 'album', 'bg_image');
		}
		if (!empty($bg_imageUpload)) {
			$bg_image = $bg_imageUpload;
		} else {
			$bg_image = null;
		}
		//upload end
		$category->avatar   = $avatar;
		$category->icon     = $icon;
		$category->bg_image = $bg_image;

		$result = $category->addCategory(); //run

		if ($result['status']) {
			$_SESSION['success'] = lang('success_category_add');
			if ($continue == 'categoryUpdate') {
//add lang next
				header("Location: " . $_B['home'] . '/' . $mod . '-categoryUpdate-' . $result['last_id'] . '-' . $get_lang);
			} else if ($continue == 'categoryNew') {
//add new next
				header("Location: " . $_B['home'] . '/' . $mod . '-' . $continue . '-lang-' . $get_lang);
			} else {
				header("Location: " . $_B['home'] . '/' . $mod . '-' . $continue . '-lang-' . $dfLang);
			}
			exit();
		} else {
			$_SESSION['error_submit'] = $result['error'];
		}

	}

} else {

//Load theme
	$content_module = $_B['temp']->load('categoryNew');

}
