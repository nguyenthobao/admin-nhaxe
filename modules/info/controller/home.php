<?php

if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
// thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('title_manager_mod');
$_S['title']           = lang('title');
$_S['description']     = lang('description');

header("Location:".$_B['home']."/".$mod.'-infolist-lang-vi');