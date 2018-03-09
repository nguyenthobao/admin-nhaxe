<?php
/**
 * @Project BNC v2 -> Admin -> Album
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

/**
 * update category controller
 */

// lang layout
$_S['breadcrumb_page'] = lang('breadcrumb_category_edit');
$_S['title']           = lang('title');
$_S['description']     = lang('description');

//get request
$action   = $_B['r']->get_string('action', 'POST');
$continue = $_B['r']->get_string('continue', 'POST');
$get_lang = $_B['r']->get_string('lang', 'GET');

//lang menu link
$lang_use = explode(',', $_B['cf']['lang_use']);
if (!in_array($get_lang, $lang_use)) {
	header("Location:" . $_B['home'] . "/" . $mod . '-albums-lang-' . $dfLang);
}
$id = $_B['r']->get_int('id', 'GET');
if (!empty($id)) {
	foreach ($lang_use as $key => $v) {
		$url_lang[$v]['url']   = $_B['home'] . '/' . $mod . '-categoryUpdate-' . $id . '-' . $v;
		$url_lang[$v]['exist'] = '';
	}
} else {
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
}

$category = new categoryUpdate();

if ($_POST) {
// post action

	if (!empty($action) AND $action == 'updateCategory') {
		/*
		 * post data
		 */
		$category->id = $_B['r']->get_int('id', 'GET'); //($_B['r']->get_int('id','POST') !='' ? $_B['r']->get_int('id','POST') : $_B['r']->get_int('id','GET'));

		$category->title                = $category->txt_string($_B['r']->get_string('title', 'POST'));
		$category->contents_description = $_B['r']->get_string('contents_description', 'POST');
		$category->status               = $_B['r']->get_int('status', 'POST');
		$category->update_time          = date("Y-m-d H:i");
		$category->meta_title           = $_B['r']->get_string('meta_title', 'POST');
		$category->meta_keywords        = $_B['r']->get_string('meta_keywords', 'POST');
		$category->meta_description     = $_B['r']->get_string('meta_description', 'POST');
		$category->order_by             = $_B['r']->get_int('order_by', 'POST');
		$category->parent_id            = $_B['r']->get_int('parent_id', 'POST');
		$category->id_lang              = $_B['r']->get_int('id_lang', 'POST');
		$category->get_lang             = $_B['r']->get_string('lang', 'GET');
		$category->alias                = $_B['r']->get_string('alias', 'POST');
		$category->is_save              = $_B['r']->get_string('is_save', 'POST');
		$category->is_home              = $_B['r']->get_int('is_home', 'POST');
		$category->limit              = $_B['r']->get_int('limit', 'POST');
		$category->title_alias          = fixTitle($_B['r']->get_string('title_alias', 'POST'));

/*
 * image upload
 */
		//upload
		include DIR_HELPER_UPLOAD;
		$options = array('max_size' => 1600);
		$upload  = new BncUpload($options);

		$avatarUpload = '';
		if (!empty($_FILES['avatar']['name'])) {
			$avatarUpload = $upload->upload($idw, 'album', 'avatar');
		} else {
			$category->avatar_check = 'remove';
		}
		if (!empty($avatarUpload)) {
			$avatar = $avatarUpload;
		} else {
			$avatar = null;
		}

		$iconUpload = '';
		if (!empty($_FILES['icon']['name'])) {
			$iconUpload = $upload->upload($idw, 'album', 'icon');
		} else {
			$category->icon_check = 'remove';
		}
		if (!empty($iconUpload)) {
			$icon = $iconUpload;
		} else {
			$icon = null;
		}

		$bg_imageUpload = '';
		if (!empty($_FILES['bg_image']['name'])) {
			$bg_imageUpload = $upload->upload($idw, 'album', 'bg_image');
		} else {
			$category->bg_image_check = 'remove';
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

		if ($get_lang != $dfLang) {
//cap nhat hinh cho lang
			$avatar             = $category->getAvatar();
			$category->avatar   = $avatar['avatar'];
			$category->icon     = $avatar['icon'];
			$category->bg_image = $avatar['bg_image'];
		}

		$result = $category->updateCategory(); //run

		if ($result['status']) {
			$_SESSION['success'] = lang('success');
			if ($continue == 'categoryUpdate') {
				header("Location: " . $_B['home'] . '/' . $mod . '-categoryUpdate-' . $result['last_id'] . '-' . $get_lang);
			} else if ($continue == 'category') {
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
	$category->id = $_B['r']->get_string('id', 'GET');
	$categoryMenu = '';
	if ($get_lang == $dfLang) {
		$categoryMenu = $category->getCatParent();
	}

	$category->get_lang = $_B['r']->get_string('lang', 'GET');
	$editItem           = $category->getCategoryItem();
	if (empty($editItem['id'])) {
		$_S['breadcrumb_page'] = lang('breadcrumb_category_new');
	}

	if ($editItem == 'errorUpdate') {
		$_SESSION['error_submit'] = lang('error_update');
		header("Location: " . $_B['home'] . '/' . $mod . '-category');
		exit();
	}
//chuyen huong neu danh muc cha chua co ban dich
	if ($editItem == 'notTranslate') {
		$_SESSION['error_submit'] = lang('parent_not_translate');
		header("Location: " . $_B['home'] . '/' . $mod . '-category');
		exit();
	}

//Load theme
	$content_module = $_B['temp']->load('categoryUpdate');

}
