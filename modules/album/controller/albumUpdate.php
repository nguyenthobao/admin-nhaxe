<?php
/**
 * @Project BNC v2 -> Admin -> Album
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

/**
 * update album controller
 */

// lang layout
$_S['breadcrumb_page'] = lang('breadcrumb_album_edit');
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
		$url_lang[$v]['url']   = $_B['home'] . '/' . $mod . '-albumUpdate-' . $id . '-' . $v;
		$url_lang[$v]['exist'] = '';
	}
} else {
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
}

$album = new albumUpdate();

if ($_POST) {
// post action

	if (!empty($action) AND $action == 'updateAlbum') {
		/*
		 * post data
		 */

		$tags = explode(',', $_B['r']->get_string('tags', 'POST'));

		if (is_array($tags) == true) {
			$tag_id = ',';
			foreach ($tags as $k => $v) {
				$tag_id .= $album->addTags($v) . ',';
			}
		} else {
			$tag_id = '';
		}

		$album->id = $_B['r']->get_int('id', 'GET'); //($_B['r']->get_int('id','POST') !='' ? $_B['r']->get_int('id','POST') : $_B['r']->get_int('id','GET'));

		$album->title                = $album->txt_string($_B['r']->get_string('title', 'POST'));
		$album->contents_description = $_B['r']->get_string('contents_description', 'POST');
		$album->category_id          = ',' . implode(",", $_B['r']->get_array('category_id', 'POST')) . ',';
		$album->arr                  = $_B['r']->get_array('category_id', 'POST');
		$album->status               = $_B['r']->get_int('status', 'POST');
		$album->avatar               = $_B['r']->get_string('avatar', 'POST');
		$album->avatar_id            = $_B['r']->get_string('avatar_id', 'POST');
		$album->update_time          = time();
		$album->meta_title           = $_B['r']->get_string('meta_title', 'POST');
		$album->meta_keywords        = $_B['r']->get_string('meta_keywords', 'POST');
		$album->meta_description     = $_B['r']->get_string('meta_description', 'POST');
		$album->tags                 = $tag_id;
		$album->order_by             = $_B['r']->get_int('order_by', 'POST');
		$album->post_time            = $_B['r']->get_string('post_time', 'POST');
		$album->tmp_id               = $_B['r']->get_string('tmp_id', 'POST');
		$album->id_lang              = $_B['r']->get_int('id_lang', 'POST');
		$album->get_lang             = $_B['r']->get_string('lang', 'GET');
		$album->album_vip            = $_B['r']->get_int('album_vip', 'POST');
		$album->album_hot            = $_B['r']->get_int('album_hot', 'POST');
		$album->alias                = $_B['r']->get_string('alias', 'POST');
		$album->is_save              = $_B['r']->get_string('is_save', 'POST');
		$album->title_alias          = fixTitle($_B['r']->get_string('title_alias', 'POST'));
		$related                     = array();
		$related['related_list']     = ',' . implode(",", $_B['r']->get_array('related_id', 'POST')) . ',';
		$chk_related                 = $_B['r']->get_int('chk_related', 'POST');
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

		$result = $album->updateAlbum(); //run

		if ($result['status']) {
			$_SESSION['success'] = lang('success');
			if ($continue == 'albumUpdate') {
				header("Location: " . $_B['home'] . '/' . $mod . '-albumUpdate-' . $result['last_id'] . '-' . $get_lang);
			} else if ($continue == 'albums') {
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
	$categoryMenu    = '';
	$categoryMenu    = $album->getCatParent(); // de lam select menu
	$album->id       = $_B['r']->get_string('id', 'GET');
	$album->get_lang = $_B['r']->get_string('lang', 'GET');
	$editItem        = $album->getAlbumItem();
		
	if (empty($editItem['id'])) {
		$_S['breadcrumb_page'] = lang('breadcrumb_album_new');
	}

	$editTags    = explode(',', $editItem['tags']);
	$editTagsNew = array();
	foreach ($editTags as $k => $v) {
		if ($v != '') {
			$editTagsNew[] = $album->getTagName($v);
		}
	}
	$editItem['tags'] = implode(',', $editTagsNew);

//update an toan
	if ($editItem == 'errorUpdate') {
		$_SESSION['error_submit'] = lang('error_update_album');
		header("Location: " . $_B['home'] . '/' . $mod . '-albums');
		exit();
	}
	if (!empty($editItem['post_time'])) {
		if ($album->checkPostTime($editItem['post_time'])) {
			$editItem['post_time'] = '';
		}

	}

	$category_id = $editItem['category_id'];
	if (!$editItem) {
		$category_id = $album->category_id();
	}
	
	if (!empty($editItem['related_cate'])) {
		$related_cate                = json_decode($editItem['related_cate']);
		$editItem['chk_cat_related'] = $related_cate->{'show'};
		$editItem['show_quantity']   = $related_cate->{'show_quantity'};
		$editItem['related_order']   = $related_cate->{'related_order'};
	}
	$related = '';

	if (!empty($editItem['related'])) {
		$relatedJ                   = json_decode($editItem['related']);
		$editItem['chk_related']    = $relatedJ->{'show'};
		$editItem['show_quantity_'] = $relatedJ->{'show_quantity'};
		$editItem['related_order_'] = $relatedJ->{'related_order'};

		$editItem['related']        = explode(",", $relatedJ->{'related_list'});
		$editItem['related']        = array_filter($editItem['related']);
		$editItem['related']        = array_unique($editItem['related']);
		$editItem['related_not_in'] = $editItem['related'];
		foreach ($editItem['related'] as $key => $value) {
			$related[] = $album->getRelatedItem($value);
		}
		$editItem['related'] = $related;
	}
	$album->not_in = $editItem['related_not_in'];
	$related = $album->getRelated(); // de lam lien quan
	$images = $album->getImages();
	
//chuyen huong neu danh muc cha chua co ban dich
	if ($editItem == 'notTranslate') {
		$_SESSION['error_submit'] = lang('parent_not_translate');
		header("Location: " . $_B['home'] . '/' . $mod . '-albums');
		exit();
	}

//Load theme
	$content_module = $_B['temp']->load('albumUpdate');

}
