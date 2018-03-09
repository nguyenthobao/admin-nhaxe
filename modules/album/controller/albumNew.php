<?php
/**
 * @Project BNC v2 -> Admin -> Album
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
/**
 * add album controller
 */

// lang layout
$_S['breadcrumb_page'] = lang('breadcrumb_album_new');
$_S['title']           = lang('title');
$_S['description']     = lang('description');

//tmp album id
$tmpIdAlbum = strtotime(date("Y-m-d H:i:s")) . rand(1, 9);

$album          = new albumNew();
$album->cleaner = 1;
$album->deleteImagesAlbum(0); //xoa anh rac cach 1 ngay truoc
$categoryMenu = $album->getCatParent(); // de lam select menu
$related      = $album->getRelated(); // de lam lien quan
$configNXT    = $album->getConfig();
$configNXT    = json_decode($configNXT['value_string'], true);

//get request
$action   = $_B['r']->get_string('action', 'POST');
$continue = $_B['r']->get_string('continue', 'POST');
$get_lang = $_B['r']->get_string('lang', 'GET');



 

if ($get_lang != $dfLang) {
	header("Location: " . $_B['home'] . '/' . $mod . '-albumNew-lang-' . $dfLang);
}
//ve ngon ngu mac dinh

//lang menu link
$lang_use = explode(',', $_B['cf']['lang_use']);

//Get ngôn ngữ đã config trong db để set làm menu lang
foreach ($lang_use as $k => $v) {
	if ($v == $dfLang) {
		$url_lang[$v]['url']   = $_B['home'] . '/' . $mod . '-albumNew-lang-' . $dfLang;
		$url_lang[$v]['exist'] = '';
		//su dung de check khi add noi dung voi ngon ngu khac.
	} else {
		//In url trang doi voi truong hop them noi dung.
		$url_lang[$v]['url']   = 'Javascript:;';
		$url_lang[$v]['exist'] = 'notExist';
	}
}

if ($_POST) {
// post action

	if (!empty($action) AND $action == 'addAlbum') {
/*
 * post data
 */
		$data = array(
			'title'       => $_B['r']->get_string('title', 'POST'),
			'album_vip'   => $_B['r']->get_int('album_vip', 'POST'),
			'album_hot'   => $_B['r']->get_int('album_hot', 'POST'),
			'category_id' => ',' . implode(",", $_B['r']->get_array('category_id', 'POST')) . ',',
		);

		$tags = explode(',', $_B['r']->get_string('tags', 'POST'));
		if (is_array($tags) == true) {
			$tag_id = ',';
			foreach ($tags as $k => $v) {
				$tag_id .= $album->addTags($v) . ',';
			}
		} else {
			$tag_id = '';
		}

		$album->title                = $album->txt_string($_B['r']->get_string('title', 'POST'));
		$album->contents_description = $_B['r']->get_string('contents_description', 'POST');
		$album->category_id          = ',' . implode(",", $_B['r']->get_array('category_id', 'POST')) . ',';
		$album->arr                  = $_B['r']->get_array('category_id', 'POST');
		$album->status               = $_B['r']->get_int('status', 'POST');
		$album->avatar               = $_B['r']->get_string('avatar', 'POST');
		$album->avatar_id            = $_B['r']->get_string('avatar_id', 'POST');
		$album->create_time          = time();
		$album->meta_title           = $_B['r']->get_string('meta_title', 'POST');
		$album->meta_keywords        = $_B['r']->get_string('meta_keywords', 'POST');
		$album->meta_description     = $_B['r']->get_string('meta_description', 'POST');
		$album->tags                 = $tag_id;
		$album->order_by             = $_B['r']->get_int('order_by', 'POST');
		$album->post_time            = $_B['r']->get_string('post_time', 'POST');
		$album->tmp_id               = $_B['r']->get_string('tmp_id', 'POST');
		$album->id_lang              = $_B['r']->get_int('id_lang', 'POST');
		$album->album_vip            = $_B['r']->get_int('album_vip', 'POST');
		$album->album_hot            = $_B['r']->get_int('album_hot', 'POST');
		$album->alias                = fixTitle($_B['r']->get_string('alias', 'POST'));

		$related                 = array();
		$related['related_list'] = ',' . implode(",", $_B['r']->get_array('related_id', 'POST')) . ',';
		$chk_related             = $_B['r']->get_int('chk_related', 'POST');
		//if($chk_related){
		$related['show'] = 0;
		if ($chk_related) {
			$related['show'] = 1;
		}

		$related['show_quantity'] = $_B['r']->get_int('show_quantity_', 'POST');
		$related['related_order'] = $_B['r']->get_int('related_order_', 'POST');
		//}
		$album->related = json_encode($related);

		$related_cate    = array();
		$chk_cat_related = $_B['r']->get_int('chk_cat_related', 'POST');
		if ($chk_cat_related) {
			$related_cate['show']          = 1;
			$related_cate['show_quantity'] = $_B['r']->get_int('show_quantity', 'POST');
			$related_cate['related_order'] = $_B['r']->get_int('related_order', 'POST');
			$album->related_cate           = json_encode($related_cate);
		}

		$result = $album->addAlbum(); //run

		if ($result['status']) {
			$_SESSION['success'] = lang('success_album_add');
			if ($continue == 'albumUpdate') {
//add lang next
				header("Location: " . $_B['home'] . '/' . $mod . '-albumUpdate-' . $result['last_id'] . '-' . $get_lang);
			} else if ($continue == 'albumNew') {
//add new next
				header("Location: " . $_B['home'] . '/' . $mod . '-' . $continue . '-lang-' . $get_lang);
			} else {
				header("Location: " . $_B['home'] . '/' . $mod . '-' . $continue . '-lang-' . $dfLang);
			}
			exit();
		} else {
			$_SESSION['error_submit'] = $result['error'];
			if ($_SESSION['error_submit'] == 'empty') {
				$_SESSION['error_submit'] = lang('error_empty_title');
				header("Location: " . $_B['home'] . '/' . $mod);
			}
		}

	}

} else {
//Load theme
	$content_module = $_B['temp']->load('albumNew');
}