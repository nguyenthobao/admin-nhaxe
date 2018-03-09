<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /moduels/home/main.php
 * @Author Quang Chau Tran (quangchauvn@gmail.com)
 * @Createdate 08/23/2014, 02:36 PM
 */
//cau hinh controller
$pages = array('setting', 'config', 'ajax', 'any','root');
$page  = $_B['r']->get_string('page', 'GET');
if (!in_array($page, $pages)) {
	$page = 'home';
}
$page_allow=array('any','root');
if (in_array($page,$page_allow)) {
	include_once DIR_MODULES . $mod . '/controller/' . $page . '.php';
	$controller=new $page;
	$controller->$_GET['sub']();
	if (!empty($_DATA['content_module'])) {
		$content_module = $_DATA['content_module'];
	}
} else {
	include_once DIR_MODULES . $mod . '/model/global_home.php';
	if (file_exists(DIR_MODULES . $mod . '/model/' . $page . '.php')) {
		include_once DIR_MODULES . $mod . '/model/' . $page . '.php';
	}
	include_once DIR_MODULES . $mod . '/controller/' . $page . '.php';

}

// xoa session thong bao thao tac
unset($_SESSION['success']);
unset($_SESSION['error_submit']);
