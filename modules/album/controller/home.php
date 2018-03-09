<?php
/**
 * @Project BNC v2 -> Admin -> Album
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
/**
 * home controller
 */
// lang layout
$_S['breadcrumb_page'] = lang('title_manager_album');
$_S['title']           = lang('title');
$_S['description']     = lang('description');

$time_now = date('Y-m-d H:i');

//get request
$action   = $_B['r']->get_string('action', 'POST');
$continue = $_B['r']->get_string('continue', 'POST');
$get_lang = $_B['r']->get_string('lang', 'GET');
if ($get_lang == '') {
	$get_lang = $dfLang;
}

//lang menu link
// $lang_use = explode(',', $_B['cf']['lang_use']);
// if (!in_array($get_lang, $lang_use)) {
// 	header("Location:" . $_B['home'] . "/" . $mod . '-albums-lang-' . $dfLang);
// }
//Get ngôn ngữ đã config trong db để set làm menu lang
foreach ($lang_use as $k => $v) {
	if ($v == $dfLang) {
		$url_lang[$v]['url'] = $_B['home'] . '/' . $mod . '-albumNew-lang-' . $dfLang;
		//su dung de check khi add noi dung voi ngon ngu khac.
	} else {
		//In url trang doi voi truong hop them noi dung.
		$url_lang[$v]['url']   = 'Javascript:;';
		$url_lang[$v]['exist'] = 'notExist';
	}
}

if ($action == 'search') {
	$value = json_encode($_POST, JSON_HEX_QUOT);
	$value = base64_encode($value);
	header("Location:" . $_B['home'] . "/" . $mod . '-albums-lang-' . $get_lang . '-value-' . $value);
}

$home = new home();
if ($_POST && $action == 'refesh_new') {
	$home->id          = $_B['r']->get_int('f5id', 'POST');
	$home->create_time = time();
	$home->f5Item('_album');
	$_SESSION['success'] = lang('success');
	header("Location:" . $_B['home'] . "/" . $mod . '-albums-lang-' . $get_lang);
}
if ($_POST && $action == 'delete_album_select') {
	$id_del = $_B['r']->get_array('name_id', 'POST');
	if (!empty($id_del)) {
		foreach ($id_del as $key => $value) {
			$home->deleteAlbum($value);
		}
	}
	$_SESSION['success'] = lang('success');
	$home->url           = $_B['home'] . "/" . $mod . '-albums-lang-' . $get_lang;
	$homeList            = $home->getList();
	if ($home->total > $home->max_rec) {
		$paging = $home->paging;
	}

} else {
	$home->time_now = $time_now;
	$categoryMenu   = $home->getCatParent(); // de lam select menu

	if (!empty($_GET['value'])) {
		$value = $_B['r']->get_string('value', 'GET');
		$value = base64_decode($value);
		$value = json_decode($value, JSON_HEX_QUOT);

		$home->search   = $value['action'];
		$home->title    = htmlspecialchars($value['title'], ENT_QUOTES);
		$value['title'] = htmlentities($value['title']);
		$home->status   = $value['status'];
		$home->category = $value['category'];
		$home->url      = $_B['home'] . "/" . $mod . '-albums-lang-' . $get_lang . '-value-' . $_GET['value'];
		$homeList       = $home->getList();
		if ($home->total > $home->max_rec) {
			$paging = $home->paging;
		}

	} else {
		$home->url = $_B['home'] . "/" . $mod . '-albums-lang-' . $get_lang;
		$homeList  = $home->getList();
		if ($home->total > $home->max_rec) {
			$paging = $home->paging;
		}

	}

}
$albumList = new home();
if($action=='ajaxCopyAlbum')
{
    $result = $albumList->$action();
}
foreach ($lang_use  as $key => $value) {
    if ($value != $get_lang )
    {
        $_DATA['lang_use'][]=$value; 
    }   
}
$content_module = $_B['temp']->load('home');