<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/ajaxbanner.php 
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/24/2014, 13:32 PM
 */  
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

$name = $_B['r']->get_string('name','POST');
$action = $_B['r']->get_string('action','POST');
$actionsearch = $_B['r']->get_string('actionsearch','POST');
if ($name) $action = $name;
if ($name) $actionsearch = $name;
$id = $_B['r']->get_int('key','POST');
include_once(DIR_MODULES.$mod."/model/bannerlist.php");
include_once(DIR_MODULES.$mod."/model/banner.php");
$banner = new BannerList();
$bannerSearch = new Banner();
if (!empty($action)){
		$result = $banner->$action();
}
if (!empty($actionsearch)){
		$result = $bannerSearch->$actionsearch();
}
