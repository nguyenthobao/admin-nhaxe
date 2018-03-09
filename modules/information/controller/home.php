<?php

if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
// thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('breadcrumb_regtrade');
$_S['title']           = lang('title');
$_S['description']     = lang('description');

$content_module = $_B['temp']->load('regtrade');
//header("Location:".$_B['home']."/".$mod.'-informationbasic-lang-vi');