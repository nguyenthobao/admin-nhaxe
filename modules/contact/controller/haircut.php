<?php
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

$_S['breadcrumb_page'] = lang('breadcrumb_manager_haircut');
$_S['title']           = lang('title');
$_S['description']     = lang('description');
//$action = $_B['r']->get_string('action','POST');

//load theme cho page contactview
$content_module = $_B['temp']->load('haircut');