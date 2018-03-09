<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/viewnews.php
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/15/2014, 16:57 PM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
include_once DIR_MODULES . 'news/model/autoNews/autoNews.php';
$autoNews = new autoNews;
$action   = $_B['r']->get_string('action', 'POST');
$id       = $_B['r']->get_int('id', 'POST');
if ($action == 'view_news') {
	$content = $autoNews->tin247_com_item_content($id);
	$content = json_decode(json_encode($content), true);
	include_once $_B['temp']->load('viewNews');
} elseif ($action == 'copy_news') {
	$item_array   = $_B['r']->get_array('item_array', 'POST');
	$cate_array   = $_B['r']->get_array('cate_array', 'POST'); //Id cate chon de copy
	$cat_id_array = $_B['r']->get_array('cat_id_array', 'POST'); //Id theo item_array

	$path         = DIR_MODULES . 'news/process/process.json';
	$arr['total'] = count($item_array);

	foreach ($item_array as $k => $v) {
		if (trim($v) != '') {
			$result    = $autoNews->copyNews($v, $cate_array, $cat_id_array[$k]);
			// echo '<pre>';
			// print_r($result);
			// echo '</pre>';
			// die();
			$modelNews = new Model('vi_news');
			
			$modelNews->insert($result);
			
		}
	}
	echo json_encode(array('status' => true));
} elseif ($action == 'getProcess') {
	$result = array(
		'status'  => true,
		'process' => $_SESSION['processCloneNews'],
	);
	echo json_encode($result);

}

exit();