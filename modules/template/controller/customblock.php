<?php
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
// thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('breadcrumb_customblock');
$_S['title']           = lang('title');
$_S['description']     = lang('description');

//get
$get_lang = $_B['r']->get_string('lang', 'GET');

$content_module = $_B['temp']->load('blockcustom');