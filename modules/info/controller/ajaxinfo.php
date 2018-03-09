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

$name = $_B['r']->get_string('name','POST');
$action = $_B['r']->get_string('action','POST');
$actionsearch = $_B['r']->get_string('actionsearch','POST');
if ($name) $action = $name;
if ($name) $actionsearch = $name;
$id = $_B['r']->get_int('key','POST');
include_once(DIR_MODULES.$mod."/model/infolist.php");
include_once(DIR_MODULES.$mod."/model/info.php");
$info = new InfoList();
$infoSearch = new Info();
if (!empty($action) && method_exists($info,$action)){
	$result = $info->$action();
}
if (!empty($actionsearch) && method_exists($infoSearch,$actionsearch)){
	$result = $infoSearch->$actionsearch();
}
