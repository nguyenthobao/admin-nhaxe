<?php
 
if(!defined('BNC_CODE')) {
    exit('Access Denied');
} 
$action = $_B['r']->get_string('action','POST');

include_once(DIR_MODULES.$mod."/model/seo.php");
include_once(DIR_MODULES.$mod."/model/redirectUrl.php");
$seos = new Seo();
if (!empty($action)){
	if($action=="redirect_url")
	{
		$Urlstart = $_B['r']->get_array('Urlstart','POST');
		$Urlend = $_B['r']->get_array('Urlend','POST');
		//$id = $_B['r']->get_array('id','POST');
		foreach ($Urlstart as $key => $value) {
			if($value==false || $Urlend[$key]== false)
			{
				continue;
			}
			$Url[$key]['url_source']= $value;
			$Url[$key]['url_destination']= $Urlend[$key];
		}
		$redirect= new Model_RedirectUrl();
		$result= $redirect->$action($Url);
	}
	elseif($action=="redirect_edit")
	{
		$Urlstart_edit = $_B['r']->get_array('Urlstart_edit','POST');
		$Urlend_edit  = $_B['r']->get_array('Urlend_edit','POST');
		$id = $_B['r']->get_array('id_array','POST');
		foreach ($Urlstart_edit as $key => $value) {
			if($value==false || $Urlend_edit[$key]== false)
			{
				continue;
			}
			$Url[$key]['url_source']= $value;
			$Url[$key]['url_destination']= $Urlend_edit[$key];
			$Url[$key]['id'] = $id[$key];
		}
		$redirect= new Model_RedirectUrl();
		$result= $redirect->$action($Url);
	}elseif ($action=="delete_url") {
		$id = $_B['r']->get_int('id','POST');
		$redirect= new Model_RedirectUrl();
		$result= $redirect->$action($id);
	}
	else{
		$result = $seos->$action();
	}
	
}
