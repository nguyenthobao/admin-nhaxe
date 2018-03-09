<?php
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}


$_S['breadcrumb_page'] = lang('breadcrumb_manager_contact');
$_S['title']           = lang('title');
$_S['description']     = lang('description');

$get_lang  = $_B['r']->get_string('lang','GET');
$id         = $_B['r']->get_int('id','GET');

if(empty($get_lang)){
 $get_lang = 'vi';
}
 $lang_use  = explode(',',$_B['cf']['lang_use']);
 if (!empty($id)) {
  foreach ($lang_use as $key => $v) {
   $url_lang[$v]['url'] = $_B['home'].'/'.$mod.'-contactview-'.$id.'-'.$v;
  }
 }else{
 //Get ngôn ngữ đã config trong db để set làm menu lang
  foreach ($lang_use as $k => $v) {
   if ($v=='vi') {
   $url_lang[$v]['url']    = $_B['home'].'/'.$mod.'-contactview-lang-vi'; 
   }else{
   //In url trang doi voi truong hop them noi dung.
   $url_lang[$v]['url']    = 'javascrip:void(0);';
   $url_lang[$v]['exist']  ='notExist';
   }
  }
 }
//Gọi modle contactview

$contactview =new contactview();
$action = $_B['r']->get_string('action','POST');
if (!empty($action)){
 //xu ly rieng cho phan tim kiem;
 if($action =="searchContact"){
  $value = json_encode($_POST);
  $value = base64_encode($value);
  header("Location:".$_B['home']."/".$mod.'-contactview-lang-'.$get_lang.'-value-'.$value);
 }
 else // cac action con lai
 {
  $result = $contactview->$action();

  if ($result['status']) {
   $_SESSION['success'] = lang('success');
   header("Location:".$_B['home']."/".$mod.'-contactview-lang-'.$get_lang);
   exit();
  }else{
   $_SESSION['error_submit'] =  $result['error'];
  }
 }
    
}
else
{
	if(!empty($_GET['value'])){
		$value = $_B['r']->get_string('value','GET');
		$value = base64_decode($value);
		$value = json_decode($value,1);
	}
	else
	{
		$value = null;
	}

	$contact = $contactview->getContact($value);
} 
//load theme cho page contactview
$content_module = $_B['temp']->load('contactview');