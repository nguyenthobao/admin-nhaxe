<?php

if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

$id_tinh = $_B['r']->get_int('id_tinh', 'POST');
$key     = $_B['r']->get_int('key', 'POST');
include_once DIR_MODULES . $mod . "/model/informationbasic.php";
$informationbasic = new InformationBasic();
$advertisers_edit = $informationbasic->getInformation();
$urltinh          = API_URL . 'getDistrict/' . $id_tinh;
//$key              = API_URL . 'getDistrict/' . $key;
$address = new Address;
if (!empty($id_tinh)) {
	//$information = $informationbasic->postpage($urltinh);
	$information = $address->getDistrict($id_tinh);
	include_once $_B['temp']->load('district');
	exit();
} else {
	//$information = $informationbasic->postpage($key);
	$information = $address->getDistrict($key);
	include_once $_B['temp']->load('districtid');
	exit();
}
