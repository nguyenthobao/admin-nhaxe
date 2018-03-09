<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/image.php 
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/15/2014, 16:57 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
// thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('breadcrumb_add_image');
$_S['title'] = lang('title');
$_S['description'] = lang('description');

$images = new Image();

//get request
$action = $_B['r']->get_string('action','POST');
$continue = $_B['r']->get_string('continue','POST');
$get_lang = $_B['r']->get_string('lang','GET');
if(empty($get_lang)){
	$content_module = $_B['temp']->load('home');
}else{
	$id = $_B['r']->get_int('id','GET');
	$lang_use = explode(',',$_B['cf']['lang_use']);
	if (!empty($id)) {
		
		if ($get_lang=='vi') {
				$image = $images->getImageID();
		}
		foreach ($lang_use as $key => $v) {
			$url_lang[$v]['url'] = $_B['home'].'/'.$mod.'-image-'.$id.'-'.$v;
		}
	}else{
		//Get ngôn ngữ đã config trong db để set làm menu lang
		foreach ($lang_use as $k => $v) {
			if ($v=='vi') {
				$url_lang[$v]['url'] = $_B['home'].'/'.$mod.'-image-lang-vi';
				//su dung de check khi add noi dung voi ngon ngu khac.
			}else{
				//In url trang doi voi truong hop them noi dung.
				$url_lang[$v]['url'] = 'javascrip:void(0);';
				$url_lang[$v]['exist']='notExist';
			}
		}		
	}
	$slide = $images->getSlideImage();
	
	if (!empty($action)){
		$result = $images->$action();
		if ($result['status']) {
			$_SESSION['success'] = lang('success');
			if ($continue=='image_lang'){
				header("Location: ".$_B['home'].'/'.$mod.'-image-'.$result['last_id'].'-'.$get_lang);
			}else if($continue=='imagelist'){
				header("Location: ".$_B['home'].'/'.$mod.'-'.$continue.'-lang-'.$get_lang);
			}else{
				header("Location: ".$_B['home'].'/'.$mod.'-'.$continue.'-lang-vi');
			}
			exit();
		}
		else{
			$_SESSION['error_submit'] = $result['error'];
		}
	}
	$image_edit = $images->getImageByID();
	if( isset($image_edit['slide_id']) ){
		$_S['breadcrumb_page'] = $_L['breadcrumb_edit_image'];
	}
	// echo "<pre>";
	// print_r($image_edit);
	// echo "</pre>";
	// die();
	//Load theme cho page add image
	$content_module = $_B['temp']->load('image');
}

