<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/news.php
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/15/2014, 16:57 PM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
// thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('breadcrumb_add_news');
$_S['title']           = lang('title');
$_S['description']     = lang('description');

//goi Model news
$newss = new News();

//get request
$action   = $_B['r']->get_string('action', 'POST');
$continue = $_B['r']->get_string('continue', 'POST');
$get_lang = $_B['r']->get_string('lang', 'GET');
if (empty($get_lang)) {
	$content_module = $_B['temp']->load('home');
} else {
	$id       = $_B['r']->get_int('id', 'GET');
	$lang_use = explode(',', $_B['cf']['lang_use']);
	if (!empty($id)) {

		if ($get_lang == 'vi') {
			$news = $newss->getNewsID();
		}
		foreach ($lang_use as $key => $v) {
			$url_lang[$v]['url'] = $_B['home'] . '/' . $mod . '-news-' . $id . '-' . $v;
		}
	} else {
		//Get ngôn ngữ đã config trong db để set làm menu lang
		foreach ($lang_use as $k => $v) {
			if ($v == 'vi') {
				$url_lang[$v]['url'] = $_B['home'] . '/' . $mod . '-news-lang-vi';
				//su dung de check khi add noi dung voi ngon ngu khac.
			} else {
				//In url trang doi voi truong hop them noi dung.
				$url_lang[$v]['url']   = 'javascrip:void(0);';
				$url_lang[$v]['exist'] = 'notExist';
			}
		}
		//$news = $newss->getNewsID();
	}

	$category = $newss->getCatSearch();

	// Thực hiện action từ submit form. Tên action chính là tên function trong model
	if (!empty($action)) {
		$result = $newss->$action();
		// var_dump($result);
		// die();
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
	$news_edit = $newss->getNewsByID();

	$tmp_tags_array = array();
	$tags           = explode(',', $news_edit['tags']);
	foreach ($tags as $k => $v) {
		$tmp_tags = $newss->getTagName($v);
		if ($v != '' && $tmp_tags != false) {
			$tmp_tags_array[] = $tmp_tags;
		}

	}
	$news_edit['tags'] = implode(',', $tmp_tags_array);

	//Lấy ra các tin để khách chọn
	if (isset($news_edit['title'])) {
		$_S['breadcrumb_page'] = $_L['breadcrumb_edit_news'];
	}

	if (isset($id) && $id != 0) {

		$news_edit = $newss->getNewsByID();

		// $news_config = $newss->getNewsRelated('news_same_category');

		// $news_config_1 = $newss->getNewsRelated('news_related');
		// get News related
		if (isset($news_edit['related_news'])) {

			$related_news_id = explode(",", $news_edit['related_news']);

			foreach ($related_news_id as $item) {

				if (isset($item)) {

					$related_news_exist[] = $newss->getRelatedNewsByID($item);
				}
			}

			$related_news = $newss->getRelatedNews($related_news_id);
		}
		$tmp_tags_array = array();
		$tags           = explode(',', $news_edit['tags']);
		foreach ($tags as $k => $v) {
			$tmp_tags = $newss->getTagName($v);
			if ($v != '' && $tmp_tags != false) {
				$tmp_tags_array[] = $tmp_tags;
			}

		}
		$news_edit['tags'] = implode(',', $tmp_tags_array);
	} else {
		$related_news = $newss->getRelatedNews();
	}
	//Load theme cho page add news
	$content_module = $_B['temp']->load('news');
}
