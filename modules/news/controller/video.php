<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/news.php 
 * @Author Mạnh Hùng (hungdct1083@gmail.com)
 * @Createdate 08/15/2014, 16:36 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}  
$_S['breadcrumb_page'] = $_L['breadcrumb_addvideo'];
$videoMD = new Video();
$action = $_B['r']->get_string('action','POST');
$continue = $_B['r']->get_string('continue','POST');
$get_lang = $_B['r']->get_string('lang','GET');


if(empty($get_lang)){
	$get_lang ='vi';

}	
	$id = $_B['r']->get_int('id','GET');
	$lang_use = explode(',',$_B['cf']['lang_use']);
	if (!empty($id)) {
		$_S['breadcrumb_page'] = $_L['breadcrumb_editvideo'];
		if ($get_lang=='vi') {
				$category = $videoMD->getCatParentVD();	
		}
		foreach ($lang_use as $key => $v) {
			$url_lang[$v]['url'] = $_B['home'].'/'.$mod.'-video-'.$id.'-'.$v;
		}
	}else{
		//Get ngôn ngữ đã config trong db để set làm menu lang
		foreach ($lang_use as $k => $v) {
			if ($v=='vi') {
				$url_lang[$v]['url'] = $_B['home'].'/'.$mod.'-video-lang-vi';
				//su dung de check khi add noi dung voi ngon ngu khac.
			}else{
				//In url trang doi voi truong hop them noi dung.
				$url_lang[$v]['url'] = 'javascrip:void(0);';
				$url_lang[$v]['exist']='notExist';
			}
		}
		$category = $videoMD->getCatParentVD();	
	}

	if (!empty($action)){
			$result = $videoMD->$action();
			if ($result['status']) { 
				$_SESSION['success'] = lang('success');
				if ($continue=='video_lang'){
					header("Location: ".$_B['home'].'/'.$mod.'-video-'.$result['last_id'].'-'.$get_lang);
				}else if($continue=='list'){
					header("Location: ".$_B['home'].'/'.$mod.'-'.$continue.'-lang-'.$get_lang);
				}else{
					header("Location: ".$_B['home'].'/'.$mod.'-'.$continue);	
				}
				exit();
			}
			else{
				$_SESSION['error_submit'] = $result['error'];
			} 
			
	}
	
	$cat = $videoMD->getVideoByID($id);
	if ($cat=='notTranslate') {
		$_SESSION['error_submit'] = lang('notTranslate');
		header("Location: ".$_B['home'].'/'.$mod.'-list-lang-vi'); 
		exit();
	}

//$categorys = new Category();
//$cat = $videoMD->getCategoryByID($id);	

$content_module = $_B['temp']->load('video');

