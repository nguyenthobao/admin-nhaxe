<?php 
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

$get  = $_B['r']->get_string('key','POST');
if(empty($get)){
	die('Access Denied');
}
$count = new Count();
$result=array(
		'total_contact'=>$count->totalContact(),
		'link'=>'contact-contactview-lang-'.$_B['r']->get_string('lang','GET')
	);

echo json_encode($result);