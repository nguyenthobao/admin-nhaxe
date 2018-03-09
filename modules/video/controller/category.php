<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/category.php 
 * @Createdate 08/15/2014, 16:57 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
// thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('breadcrumb_category');
$_S['breadcrumb_category']= $_L['breadcrumb_category'];
$_S['title'] = lang('title');
$_S['description'] = lang('description');

//goi Model category
$categorys = new Category();

//get request
$action = $_B['r']->get_string('action','POST');
$mod=$_B['r']->get_string('mod','GET');
$continue = $_B['r']->get_string('continue','POST');
$get_lang = $_B['r']->get_string('lang','GET');
if(empty($get_lang)){
	$content_module = $_B['temp']->load('home');
}else{	
	$id = $_B['r']->get_int('id','GET');
	$lang_use = explode(',',$_B['cf']['lang_use']);
	if (!empty($id)) {
		
		$category = $categorys->getCatParent();	
				/*$category = $categorys->unset($id);
				if($categoryTMP['parent_id'] != $id)
				{				
					$category=$categoryTMP;
				}
				unset($arr[$keys]); */

		foreach ($lang_use as $key => $v) {
			$url_lang[$v]['url'] = $_B['home'].'/'.$mod.'-category-'.$id.'-'.$v;
		}
	}else{
		//Get ngôn ngữ đã config trong db để set làm menu lang
		foreach ($lang_use as $k => $v) {
			if ($v=='vi') {
				$url_lang[$v]['url'] = $_B['home'].'/'.$mod.'-category-lang-vi';
				//su dung de check khi add noi dung voi ngon ngu khac.
			}else{
				//In url trang doi voi truong hop them noi dung.
				$url_lang[$v]['url'] = "javascrip:void(0)";
				$url_lang[$v]['mes']='Bạn phải đăng ngôn ngữ mặc định trước';
				$url_lang[$v]['exist']='notExist';
			}
		}
		$category = $categorys->getCatParent();	
	}
	

	// Thực hiện action từ submit form. Tên action chính là tên function trong model
	if (!empty($action)){
			$result = $categorys->$action();
			if ($result['status']) { 
				$_SESSION['success'] = lang('success');
				if ($continue=='category_lang'){
					header("Location: ".$_B['home'].'/'.$mod.'-category-'.$result['last_id'].'-'.$get_lang);
				}else if($continue=='categorylist'){
					header("Location: ".$_B['home'].'/'.$mod.'-'.$continue.'-lang-'.$get_lang);
				}else{
					header("Location: ".$_B['home'].'/'.$mod.'-'.$continue.'-lang-'.$get_lang);	
				}
				exit();
			}
			else{
				$_SESSION['error_submit'] = $result['error'];
			} 
			
	}
	//Lay du lieu cua mot danh muc
	$cat = $categorys->getCategoryByID($id);
	if ($cat=='notTranslate') {
		$_SESSION['error_submit'] = lang('notTranslate');
		header("Location: ".$_B['home'].'/'.$mod.'-categorylist-lang-vi'); 
		exit();
	}
	if( isset($cat['title']) ){
		$_S['breadcrumb_page'] = $_L['breadcrumb_editcategory'];
		$_S['breadcrumb_category']= $_L['breadcrumb_editcategory'];
	}	
	//Load theme cho page add category
	$content_module = $_B['temp']->load('category');
}