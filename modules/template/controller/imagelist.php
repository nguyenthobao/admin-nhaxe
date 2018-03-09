<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/imagelist.php 
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/21/2014, 14:27 PM
 */  
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
// thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('title_manager_image');

$_S['title'] = lang('title_manager_image');
$_S['description'] = lang('description');

$get_lang = $_B['r']->get_string('lang','GET');

//Add category bắt buộc phải thêm tiếng việt trước
$addImage = $_B['home'].'/'.$mod.'-image-lang-vi';
$deleteMultiID = $_B['home'].'/'.$mod.'-imagelist-deleteMultiID-lang-vi';

//goi Model categorylist
$imageList = new ImageList();

$lang_use = explode(',',$_B['cf']['lang_use']);
//Get ngôn ngữ đã config trong db để set làm menu lang
foreach ($lang_use as $k => $v) {
	$url_lang[$v]['exist'] = '';
	$url_lang[$v]['url'] = '';
}
$id = $_B['r']->get_int('id','GET');

$image = array();
$slide = $imageList->getSlideImage();
$action = $_B['r']->get_string('action','POST');
if ($ad->tableExits($get_lang.'_slide_image')) {
	if (!empty($id)){
		$image = $imageList->getImageSlideId($id);
		// echo "<pre>";
		// print_r($image);
		// echo "</pre>";
		// die();		
	}else{
		$image = $imageList->getImage();		
		}
}

	if (!empty($action)){
	 	//xu ly rieng cho phan tim kiem;
	 	if($action =="searchImage"){
		  	$value = json_encode($_POST);
		  	$value = base64_encode($value);
		  	header("Location:".$_B['home']."/".$mod.'-imagelist-lang-'.$get_lang.'-value-'.$value);
	 	}else{
	  		$result = $imageList->$action();
	  		if ($result['status']) {
				$_SESSION['success'] = lang('success');
				header("Location:".$_B['home']."/".$mod.'-imagelist-lang-'.$get_lang);
				exit();
			}else{
				$_SESSION['error_submit'] =  $result['notify_error'];
			}
	 	}  
	}else{
		if (!empty($_GET['value'])) {
			$image = $imageList->searchImage();
		}else{
			if (!empty($id)){
				$image = $imageList->getImageSlideId($id);	
			}else{
				$image = $imageList->getImage();		
				}
			}
	}
$content_module = $_B['temp']->load('imagelist');
