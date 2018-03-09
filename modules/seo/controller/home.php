<?php

if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
// thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('breadcrumb_feedback');
$_S['title']           = lang('title');
$_S['description']     = lang('description');
 
header("Location:".$_B['home']."/".$mod.'-seo-lang-vi');