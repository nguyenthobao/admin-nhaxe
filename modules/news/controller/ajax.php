<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/ajax.php 
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/24/2014, 13:32 PM
 */  
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
$action = $_B['r']->get_string('action','POST');
if ($action=='searchNewsVip'||$action=='searchNewsHot'||$action=='saveSettingNewsCat'||$action=='saveSettingNewsHome'||$action=='delImgSetting'||$action=='delIconSetting'||$action=='delBgSetting') {
	include_once(DIR_MODULES.$mod."/model/setting.php");
	$setting = new Setting();
	$result = $setting->$action();
}else{
	$name = $_B['r']->get_string('name','POST');
	if ($name) $action = $name;
	$id = $_B['r']->get_int('key','POST');
	include_once(DIR_MODULES.$mod."/model/categorylist.php");
	$cat = new CategoryList();
	if (!empty($action)){
			$result = $cat->$action();
	}
}
