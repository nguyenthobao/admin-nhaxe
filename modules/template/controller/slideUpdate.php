<?php

if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

/**
 * update slide controller
 */
 
// lang layout
$_S['breadcrumb_page'] = lang('breadcrumb_slide_edit');
$_S['title'] = lang('title');
$_S['description'] = lang('description');

//get request
$action = $_B['r']->get_string('action','POST');
$continue = $_B['r']->get_string('continue','POST');
$get_lang = $_B['r']->get_string('lang','GET');

//lang menu link
$lang_use = explode(',',$_B['cf']['lang_use']);
if(!in_array($get_lang, $lang_use)){
header("Location:".$_B['home']."/".$mod.'-slides-lang-'.$dfLang);
} 
$id = $_B['r']->get_int('id','GET');
if (!empty($id)) {
    foreach ($lang_use as $key => $v) {
        $url_lang[$v]['url'] = $_B['home'].'/'.$mod.'-slideUpdate-'.$id.'-'.$v;
        $url_lang[$v]['exist']='';
    }
}else{
//Get ngôn ngữ đã config trong db để set làm menu lang
foreach ($lang_use as $k => $v) {
if($v==$dfLang){
    $url_lang[$v]['url'] = $_B['home'].'/'.$mod.'-slideNew-lang-'.$dfLang;
    $url_lang[$v]['exist']='';
    //su dung de check khi add noi dung voi ngon ngu khac.
}else{
    //In url trang doi voi truong hop them noi dung.
    $url_lang[$v]['url'] = 'Javascript:;';
    $url_lang[$v]['exist']='notExist';
}
}
}

$slide = new slideUpdate();

if($_POST){// post action

if (!empty($action) AND $action == 'updateSlide'){
    /*
     * post data
     */
    $slide->id                      = $_B['r']->get_int('id','GET');
    $slide->title                   = $_B['r']->get_string('title','POST');
    $slide->description             = $_B['r']->get_string('description','POST');
    $slide->status                  = $_B['r']->get_int('status','POST');
    $slide->position                = $_B['r']->get_int('position','POST');
    $slide->update_time             = date("Y-m-d H:i");
    $slide->meta_title              = $_B['r']->get_string('meta_title','POST');
    $slide->meta_keywords           = $_B['r']->get_string('meta_keywords','POST');
    $slide->meta_description        = $_B['r']->get_string('meta_description','POST');
    $slide->sort                    = $_B['r']->get_int('sort','POST');
    $slide->tmp_id                  = $_B['r']->get_string('tmp_id','POST');
    $slide->id_lang                 = $_B['r']->get_int('id_lang','POST');
    $slide->get_lang                = $_B['r']->get_string('lang','GET');
        
    $result = $slide->updateSlide();//run
    
    if ($result['status']) {
        $_SESSION['success'] = lang('success');
        if ($continue=='slideUpdate'){
            header("Location: ".$_B['home'].'/'.$mod.'-slideUpdate-'.$result['last_id'].'-'.$get_lang);
        }else if($continue=='slides'){
            header("Location: ".$_B['home'].'/'.$mod.'-'.$continue.'-lang-'.$get_lang);
        }else{
            header("Location: ".$_B['home'].'/'.$mod.'-slides-lang-'.$get_lang); 
        }
        exit();
    }
    else{
        $_SESSION['error_submit'] = $result['error'];
    } 
        
}

}else{

$slide->id = $_B['r']->get_string('id','GET');
$slide->get_lang = $_B['r']->get_string('lang','GET');
$editItem = $slide->getSlideItem();

$images = $slide->getImages();

//update an toan
if ($editItem=='errorUpdate') {
$_SESSION['error_submit'] = lang('error_update_slide');
header("Location: ".$_B['home'].'/'.$mod.'-slides'); 
exit();
}
//chuyen huong neu danh muc cha chua co ban dich
if ($editItem=='notTranslate') {
$_SESSION['error_submit'] = lang('parent_not_translate');
header("Location: ".$_B['home'].'/'.$mod.'-slides'); 
exit();
}

//Load theme
$content_module = $_B['temp']->load('slideUpdate');

}
