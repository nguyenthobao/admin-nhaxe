<?php
 
if(!defined('BNC_CODE')) {
    exit('Access Denied');
} 
$action = $_B['r']->get_string('action','POST');
include_once(DIR_MODULES.$mod."/model/template.php");
$template = new Logo();
if (!empty($action)){
	$result = $template->$action();
}
