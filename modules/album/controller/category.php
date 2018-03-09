<?php
/**
 * @Project BNC v2 -> Admin -> Album
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

/**
 * category list controller
 */
 
// lang layout
$_S['breadcrumb_page'] = lang('title_manager_category');
$_S['title'] = lang('title');
$_S['description'] = lang('description');

//get request
$action = $_B['r']->get_string('action','POST');
$continue = $_B['r']->get_string('continue','POST');
$get_lang = $_B['r']->get_string('lang','GET');
if($get_lang=='') $get_lang = $dfLang;

//lang menu link
$lang_use = explode(',',$_B['cf']['lang_use']);
if(!in_array($get_lang, $lang_use)){
// header("Location:".$_B['home']."/".$mod.'-category-lang-'.$dfLang);
} 
//Get ngôn ngữ đã config trong db để set làm menu lang
foreach ($lang_use as $k => $v) {
if ($v==$dfLang) {
    $url_lang[$v]['url'] = $_B['home'].'/'.$mod.'-categoryNew-lang-'.$dfLang;
    //su dung de check khi add noi dung voi ngon ngu khac.
}else{
    //In url trang doi voi truong hop them noi dung.
    $url_lang[$v]['url'] = 'Javascript:;';
    $url_lang[$v]['exist']='notExist';
}
}

if($action=='search'){
$value = json_encode($_POST);
$value = base64_encode($value);
header("Location:".$_B['home']."/".$mod.'-category-lang-'.$get_lang.'-value-'.$value);
}

$categoryList = new category();
if($action=='ajaxCopyCategory')
{
    $result = $categoryList->$action();
}
if($_POST && $action=='delete_category_select'){
$id_del=$_B['r']->get_array('name_id','POST');

if(!empty($id_del)){

foreach ($id_del as $key => $value) {
$categoryList->id = $value;
$categoryList->quickDeleteCate();
}
$_SESSION['success'] = lang('success');
}
$cateList = $categoryList->getList();
$paging = 0;//$categoryList->paging;
//header("Location:".$_B['home']."/".$mod.'-category-lang-'.$get_lang);
}else{
if(!empty($_GET['value'])){
    $value = $_B['r']->get_string('value','GET');
    $value = base64_decode($value);
    $value = json_decode($value,1 |JSON_HEX_QUOT);
    
    $categoryList->search = $value['action'];
    $categoryList->title = htmlspecialchars($value['title'], ENT_QUOTES);
    $value['title'] = htmlentities($value['title']);
    $categoryList->status = $value['status'];
    //$categoryList->url = $_B['home']."/".$mod.'-category-lang-'.$get_lang.'-value-'.$_GET['value'];
    $cateList = $categoryList->getList();
    $paging = 0;//$categoryList->paging;
 
}else{
//$categoryList->url = $_B['home']."/".$mod.'-category-lang-'.$get_lang;
$cateList = $categoryList->getList();
$paging = 0;//$categoryList->paging;

}
}
foreach ($lang_use  as $key => $value) {
    if ($value != $get_lang )
    {
        $_DATA['lang_use'][]=$value; 
    }   
}
//Load theme
$content_module = $_B['temp']->load('category');
