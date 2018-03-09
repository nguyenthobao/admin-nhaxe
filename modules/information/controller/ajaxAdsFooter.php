<?php

if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

$status = $_B['r']->get_int('status', 'POST');
include_once DIR_MODULES . $mod . "/model/footer.php";
$footer    = new Footer();
$configAds = $footer->configAdsFooter($status);
if ($status == 1) {
	$result = array(
		'status'  => true,
		'message' => 'Thao tác bật thành công',
	);
} else {
	$result = array(
		'status'  => true,
		'message' => 'Thao tác tắt thành công',
	);
}
echo json_encode($result);
