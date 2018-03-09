<?php
 
if(!defined('BNC_CODE')) {
    exit('Access Denied');
} 
$img = $_B['r']->get_string('img','POST');
$id = $_B['r']->get_int('id','POST');
$type = $_B['r']->get_string('type','POST');
if(!empty($type)){
	include_once(DIR_MODULES.$mod."/model/menutop.php");
	$Obj_menu=new MenuTop;
	if($type=='image'){
		$Obj_menu->deleteImage();

	}else{
		$Obj_menu->deleteIcon();	
	}
	$result=array(
			'msg'=>'Success'
		);
	echo json_encode($result);
	exit();
}else{
	echo 'Access Denied';
	exit();
}

