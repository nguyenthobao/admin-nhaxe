<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/home.php
 * @Author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 09/10/2014, 10:30 AM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

global $_B;
$data = array(
	'idw' => $_B['web']['idw'],
	);
$data = json_encode($data);
$media = base64_encode($data);

$content_module = $_B['temp']->load('media');

?>