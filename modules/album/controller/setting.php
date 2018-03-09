<?php
/**
 * @Project BNC v2 -> Admin -> Album
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

/**
 * setting album controller
 */

// lang layout
$_S['breadcrumb_page'] = lang('breadcrumb_setting');
$_S['title']           = lang('title');
$_S['description']     = lang('description');

//get request
$action   = $_B['r']->get_string('action', 'POST');
$continue = $_B['r']->get_string('continue', 'POST');
$get_lang = $_B['r']->get_string('lang', 'GET');

//lang menu link
$lang_use = explode(',', $_B['cf']['lang_use']);
if (!in_array($get_lang, $lang_use)) {
	header("Location:" . $_B['home'] . "/" . $mod . '-setting-lang-' . $dfLang);
}
$id = $_B['r']->get_int('id', 'GET');
foreach ($lang_use as $key => $v) {
	$url_lang[$v]['url']   = $_B['home'] . '/' . $mod . '-setting-lang-' . $v;
	$url_lang[$v]['exist'] = '';
}
$setting = new setting();
if (!empty($_POST)) {
	if ($_B['r']->get_string('continue', 'POST') == 'reset_default') {
		$setting->defaultSetting();
	} else {
		$data = array(); //data json
		/*
		 * image upload
		 */
		//upload
		if (!empty($_FILES['avatar']['name']) || !empty($_FILES['icon']['name']) || !empty($_FILES['bg_image']['name'])) {
			include DIR_HELPER_UPLOAD;
			$options = array('max_size' => 1600);

			$upload = new BncUpload($options);

			if (!empty($_FILES['avatar']['name'])) {
				$avatarUpload = $upload->upload($idw, 'album', 'avatar');
			}
			if (!empty($avatarUpload)) {
				$avatar = $avatarUpload;
			}

			if (!empty($_FILES['icon']['name'])) {
				$iconUpload = $upload->upload($idw, 'album', 'icon');
			}
			if (!empty($iconUpload)) {
				$icon = $iconUpload;
			}

			if (!empty($_FILES['bg_image']['name'])) {
				$bg_imageUpload = $upload->upload($idw, 'album', 'bg_image');
			}
			if (!empty($bg_imageUpload)) {
				$bg_image = $bg_imageUpload;
			}
		}
		//upload end

		$data['avatar']   = (isset($avatar) ? $avatar : $_B['r']->get_string('avatar', 'POST'));
		$data['icon']     = (isset($icon) ? $icon : $_B['r']->get_string('icon', 'POST'));
		$data['bg_image'] = (isset($bg_image) ? $bg_image : $_B['r']->get_string('bg_image', 'POST'));

		$data['title']            = $_B['r']->get_string('title', 'POST');
		$data['description']      = $_B['r']->get_string('description', 'POST');
		$data['meta_title']       = $_B['r']->get_string('meta_title', 'POST');
		$data['meta_keywords']    = $_B['r']->get_string('meta_keywords', 'POST');
		$data['meta_description'] = $_B['r']->get_string('meta_description', 'POST');
		$data['display_sort']     = $_B['r']->get_string('display_sort', 'POST');
		$data['display_number']   = $_B['r']->get_string('display_number', 'POST');
		$data['display_type']     = $_B['r']->get_string('display_type', 'POST');
		$album_cate               = $_B['r']->get_array('album_cate', 'POST');
		$album_related            = $_B['r']->get_array('album_related', 'POST');
		if (!isset($album_cate['status'])) {
			$album_cate['status'] = 1;
		}

		if (!isset($album_related['status'])) {
			$album_related['status'] = 1;
		}
		$nxt['album_cate']    = $album_cate;
		$nxt['album_related'] = $album_related;

		$data['related']       = $nxt;
		$setting->value_string = json_encode($data);
		$setting->homeSetting();
	}
	$_SESSION['success'] = lang('success');
}
$json = $setting->getSetting();
if (!empty($json)) {
	$json2 = json_decode($json['value_string'], true);
	$json  = json_decode($json['value_string']);

	$cf['title']            = $json->{'title'};
	$cf['description']      = $json->{'description'};
	$cf['meta_title']       = $json->{'meta_title'};
	$cf['meta_keywords']    = $json->{'meta_keywords'};
	$cf['meta_description'] = $json->{'meta_description'};
	$cf['display_sort']     = $json->{'display_sort'};
	$cf['display_number']   = $json->{'display_number'};
	$cf['display_type']     = $json->{'display_type'};
	$cf['avatar']           = $json->{'avatar'};
	$cf['icon']             = $json->{'icon'};
	$cf['bg_image']         = $json->{'bg_image'};
	$cf['related']          = $json2['related'];

}
//Load theme
$content_module = $_B['temp']->load('setting');