<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/ajaxslide.php
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/24/2014, 13:32 PM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

$name         = $_B['r']->get_string('name', 'POST');
$action       = $_B['r']->get_string('action', 'POST');
$actionsearch = $_B['r']->get_string('actionsearch', 'POST');
if ($name) {
	$action       = $name;
	$actionsearch = $name;
}

$id = $_B['r']->get_int('key', 'POST');
if (!empty($action)) {
	include_once DIR_MODULES . $mod . "/model/slidelist.php";
	$slide = new SlideList();
	if (method_exists($slide, $action)) {
		$result = $slide->$action();
	}

}
if (!empty($actionsearch)) {

	include_once DIR_MODULES . $mod . "/model/slide.php";
	$slideSearch = new Slide();
	if (method_exists($slideSearch, $actionsearch)) {
		$result = $slideSearch->$actionsearch();
	}

}
