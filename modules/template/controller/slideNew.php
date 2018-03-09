<?php

if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
/**
 * add slide controller
 */

// lang layout
$_S['breadcrumb_page'] = lang('breadcrumb_slide_new');
$_S['title'] = lang('title');
$_S['description'] = lang('description');

//tmp slide id
$tmpIdSlide = strtotime(date("Y-m-d H:i:s")).rand(1,9);

$slide = new slideNew();

//get request
$action = $_B['r']->get_string('action','POST');
$continue = $_B['r']->get_string('continue','POST');
$get_lang = $_B['r']->get_string('lang','GET');

if($get_lang!=$dfLang)
header("Location: ". $_B['home'].'/'.$mod.'-slideNew-lang-'.$dfLang); //ve ngon ngu mac dinh

//lang menu link
$lang_use = explode(',',$_B['cf']['lang_use']);

//Get ngôn ngữ đã config trong db để set làm menu lang
foreach ($lang_use as $k => $v) {
if ($v==$dfLang) {
    $url_lang[$v]['url'] = $_B['home'].'/'.$mod.'-slideNew-lang-'.$dfLang;
    $url_lang[$v]['exist']='';
    //su dung de check khi add noi dung voi ngon ngu khac.
}else{
    //In url trang doi voi truong hop them noi dung.
    $url_lang[$v]['url'] = 'Javascript:;';
    $url_lang[$v]['exist']='notExist';
}
}

if($_POST){// post action

if (!empty($action) AND $action == 'addSlide'){
/*
 * post data
 */
    $slide->title                   = $_B['r']->get_string('title','POST');
    $slide->description             = $_B['r']->get_string('description','POST');
    $slide->status                  = $_B['r']->get_int('status','POST');
    $slide->position                = $_B['r']->get_int('position','POST');
    $slide->create_time             = date("Y-m-d H:i");
    $slide->meta_title              = $_B['r']->get_string('meta_title','POST');
    $slide->meta_keywords           = $_B['r']->get_string('meta_keywords','POST');
    $slide->meta_description        = $_B['r']->get_string('meta_description','POST');
    $slide->sort                    = $_B['r']->get_int('sort','POST');
    $slide->tmp_id                  = $_B['r']->get_string('tmp_id','POST');
    $slide->id_lang                 = $_B['r']->get_int('id_lang','POST');
    
    $result = $slide->addSlide();//run
    
    if ($result['status']) {
        $_SESSION['success'] = lang('success_slide_add');
        if ($continue=='slideUpdate'){//add lang next
            header("Location: ".$_B['home'].'/'.$mod.'-slideUpdate-'.$result['last_id'].'-'.$get_lang);
        }else if($continue=='slideNew'){//add new next
            header("Location: ".$_B['home'].'/'.$mod.'-'.$continue.'-lang-'.$get_lang);
        }else{
            header("Location: ".$_B['home'].'/'.$mod.'-'.$continue.'-lang-'.$dfLang); 
        }
        exit();
    }
    else{
        $_SESSION['error_submit'] = $result['error'];
        if($_SESSION['error_submit']=='empty') {
            $_SESSION['error_submit'] = lang('error_empty_title');
            header("Location: ". $_B['home'].'/'.$mod);
    }
    } 
        
}

}else{
//Load theme
$content_module = $_B['temp']->load('slideNew');
}