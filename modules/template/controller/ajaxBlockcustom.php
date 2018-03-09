<?php
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

$action = $_POST['name'];
$blockcustom->$action();
