<?php
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

$_S['breadcrumb_page'] = lang('breadcrumb_manager_contactqa');
$_S['title']           = lang('title');
$_S['description']     = lang('description');
//$action = $_B['r']->get_string('action','POST');

$contactqa =new Contactqa();

  $getQA   = $contactqa->getQA();
  foreach ($getQA as $k => $v) {
  	$getQA[$k]['create_time'] = date('H:i:s A - d/m/Y',$getQA[$k]['create_time']);
  	$getQA[$k]['update_time'] = date('H:i:s A - d/m/Y',$getQA[$k]['create_time_answer']);
  }
//load theme cho page contactview
$content_module = $_B['temp']->load('contactqa');