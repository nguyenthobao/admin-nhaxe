<?php

if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
$name        = $_B['r']->get_string('name', 'POST');
$id          = $_B['r']->get_int('key', 'POST');
$actionabove = $_B['r']->get_string('actionabove', 'POST');
if ($name) {
	$actionabove = $name;
}

$actionbelow = $_B['r']->get_string('actionbelow', 'POST');
if ($name) {
	$actionbelow = $name;
}

include_once DIR_MODULES . $mod . "/model/menulisttop.php";
include_once DIR_MODULES . $mod . "/model/menulistbottom.php";
$menuabove = new MenuListTop();
$menubelow = new MenuListBottom();
if (!empty($actionabove)) {
	$result = $menuabove->$actionabove();
}
if (!empty($actionbelow)) {
	$result = $menubelow->$actionbelow();
}
