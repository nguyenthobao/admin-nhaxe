<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/news.php 
 * @Author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 08/15/2014, 16:36 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

global $_B;
$r = $_B['r'];

$submit_form = $r->get_string('submit','POST');

switch($submit_form)
{
	case 'addnew':
		include_once (DIR_MODULES."news/controller/news.php");
	default: echo "Default"	;
	
}
