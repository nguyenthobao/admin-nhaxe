`<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/template.php
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 10/13/2014, 16:10 PM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
// thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('title_setting_basic');
$_S['title']           = lang('title');
$_S['description']     = lang('description');

//goi Model Template
$logo_web = new Logo();

//get request
$action   = $_B['r']->get_string('action', 'POST');
$continue = $_B['r']->get_string('continue', 'POST');
$get_lang = $_B['r']->get_string('lang', 'GET');
if (empty($get_lang)) {
	//$content_module = $_B['temp']->load('template');
	header("Location: " . $_B['home'] . '/' . $mod . '-template-lang-vi');
} else {
	$id       = $_B['r']->get_int('id', 'GET');
	$lang_use = explode(',', $_B['cf']['lang_use']);
	if (!empty($id)) {
		$_S['breadcrumb_page'] = $_L['title_setting_basic'];
		if ($get_lang == 'vi') {
			$logo = $logo_web->getLogoID();
		}
		foreach ($lang_use as $key => $v) {
			$url_lang[$v]['url'] = $_B['home'] . '/' . $mod . '-template-' . $id . '-' . $v;
		}
	} else {
		//Get ngôn ngữ đã config trong db để set làm menu lang
		foreach ($lang_use as $k => $v) {
			//if ($v=='vi') {
			$url_lang[$v]['url'] = $_B['home'] . '/' . $mod . '-template-lang-' . $v;
			//su dung de check khi add noi dung voi ngon ngu khac.
			// }else{
			// 	//In url trang doi voi truong hop them noi dung.
			// 	$url_lang[$v]['url'] = 'javascrip:void(0);';
			// 	$url_lang[$v]['exist']='notExist';
			// }
		}

	}
	// Thực hiện action từ submit form. Tên action chính là tên function trong model
	if (!empty($action)) {
		$result = $logo_web->$action();
		if ($result['status']) {
			$_SESSION['success'] = lang('success');
			if ($continue == 'addLogo') {
				header("Location: " . $_B['home'] . '/' . $mod . '-template-lang-' . $get_lang);
			} else if ($continue == 'addBackground') {
				header("Location: " . $_B['home'] . '/' . $mod . '-template-lang-vi');
			} else if ($continue == 'addAudio') {
				header("Location: " . $_B['home'] . '/' . $mod . '-template-lang-vi');
			} else if ($continue == 'giaodien') {
				header("Location: " . $_B['home'] . '/' . $mod . '-template-lang-vi');
			} else {
				header("Location: " . $_B['home'] . '/' . $mod . '-template-lang-vi');
			}
			exit();
		} else {
			$_SESSION['error_submit'] = $result['error'];
		}
	}
	$tempId  = $logo_web->getTempId();
	$logo_edit  = $logo_web->getLogoByID();
	$bg_edit    = $logo_web->getBackground();
	$audio_edit = $logo_web->getAudio();
	if (isset($id) && $id != 0) {
		$logo_edit = $logo_web->getLogoByID();
	}

	$watermark = $logo_web->watermark();
	if ($watermark == true) {
		$watermark = json_decode($watermark['value_string'], true);
	}

	//Load theme cho page template
	include DIR_HELPER_UPLOAD;
	$options   = array('max_size' => 1600, 'write_file' => true);
	$upload    = new BncUpload($options);
	$watermark = $upload->writeFile($_B['web']['idw'], 'setting.txt', null, 'GET');
	if ($watermark != '0') {
        $watermark            = json_decode($watermark, true);
        $watermark['ori_img'] = $watermark['image'] = $watermark['image'];
    }
    $path_new=pathinfo($_B['home_frontend']);
   	$_B['path_new']=$path_new['dirname'].'/modules/template/watermark/'.$_B['web']['idw'].'/';
   	if(isset($_COOKIE['truong'])){
    	echo '<pre>';
    	var_dump(file_exists(DIR_MODULES_FRONTEND . 'template/watermark/'));
    	echo '</pre>';
    	die();
    }else{
    	
    }
	$dir_font     = DIR_MODULES . $mod . "/themes/font";
	$files_font   = scandir($dir_font, 1);
	$name_font_ok = array();
	$objFontInfo  = new FontInfo();
	// $css          = '';
	// $count        = 0;
	foreach ($files_font as $k => $v) {
		if ($v != '..' && $v != '.') {
			$tmp_font      = $objFontInfo->getFontName($dir_font . '/' . $v);
			$name_font[$v] = $tmp_font[4];
			// $css .= "@font-face {
			// 	  font-family: '" . $tmp_font[4] . "';
			// 	  font-weight: '" . $tmp_font[2] . "';
			// 	  src: url('../font/" . $v . "');
			// 	  src: url('../font/" . $v . "') format('truetype');
			// 	}
			// 	.nxt_" . $count . "{
			// 		font-family:'" . $tmp_font[4] . "' !important;
			// 	}
			// 	";
			// $count += 1;
		}
	}
	krsort($name_font);

	$active_responsive = $logo_web->getConfigResponsive();
	 
	$content_module    = $_B['temp']->load('template');
}
