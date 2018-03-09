<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/ajax.php 
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
include_once(DIR_MODULES.$mod."/model/videolist.php");
include_once(DIR_MODULES.$mod."/model/video.php");
$catvideo = new VideoList();
$videosearch = new video();
if (!empty($action)){
		///$result = $cat->$actionvd();
		$result = $catvideo->$action();
}
if (!empty($actionsearch)){
		$result = $videosearch->$actionsearch();
}
