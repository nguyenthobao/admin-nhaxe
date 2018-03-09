<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/ajax.php 
 * @Author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 08/24/2014, 13:32 PM
 */  
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
$id = $_B['r']->get_int('key','POST');
$action = $_B['r']->get_string('action','POST');
include_once(DIR_MODULES.$mod."/model/contactview.php");
$contactmodel = new Contactview();
if (!empty($action)){
	$result = $contactmodel->$action();
}
