
<?php

	if (!defined('BNC_CODE')) {
		exit('Access Denied');
	}

	$id_huyen = $_B['r']->get_int('id_huyen', 'POST');
	$key      = $_B['r']->get_int('key', 'POST');
	include_once DIR_MODULES . $mod . "/model/informationbasic.php";
	$informationbasic = new InformationBasic();
	$advertisers_edit = $informationbasic->getInformation();
	$urlhuyen         = API_URL . 'getWard/' . $id_huyen;
	//$key              = API_URL . 'getWard/' . $key;
	$address = new Address;
	if (!empty($id_huyen)) {
		// $information = $informationbasic->postpage($urlhuyen);
		$information = $address->getWard($id_huyen);
		include_once $_B['temp']->load('ward');
		exit();
	} else {
		//$information = $informationbasic->postpage($key);
		$information = $address->getWard($key);
		include_once $_B['temp']->load('wardid');
		exit();
}
