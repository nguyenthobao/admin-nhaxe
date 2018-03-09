<?php
 
date_default_timezone_set('Asia/Ho_Chi_Minh');
set_time_limit(2000);	
ini_set('max_execution_time', 2000);
if (isset($_COOKIE['chau']) ) {
	
	
    error_reporting(E_ALL ^ E_DEPRECATED ^ E_WARNING ^ E_NOTICE) ;
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
} else {
	error_reporting(0);
	//error_reporting(7);
	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
}


define('BNC_CODE', TRUE);
define('DIR_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('DIR_CONFIG', DIR_ROOT . 'config/');
define('DIR_TMP', DIR_ROOT . 'tmp/');
define('DIR_THEME', DIR_ROOT . 'themes/');
define('DIR_THEME_FRONTEND', DIR_ROOT . 'themes_frontend/');
define('DIR_CLASS', DIR_ROOT . 'includes/class/');
define('DIR_PAYMENT', DIR_ROOT . 'includes/class/payment.php');
define('DIR_MODULES', DIR_ROOT . 'modules/');
define('DIR_MODULES_FRONTEND', DIR_ROOT . 'modules_frontend/');
define('DIR_LANG', DIR_ROOT . 'lang/');
define('DIR_LANG_FRONTEND', DIR_ROOT . 'lang_frontend/');
define('DIR_FUNS', DIR_ROOT . 'includes/functions/');
//Thư viện
define('DIR_HELPER', DIR_ROOT . 'includes/helper/');
define('DIR_HELPER_UPLOAD', DIR_HELPER . 'upload.helper/upload.client.php');
define('DIR_HELPER_EXCEL', DIR_HELPER . 'Excel/PHPExcel.php');

define('DIR_ADDRESS', DIR_ROOT . 'includes/class/address.php');
define('DIR_VALIDATOR', DIR_CLASS . 'gump.class.php');
define('API_URL', 'http://dev2.webbnc.vn/api/');
define('DIR_TMP_FRONTEND', DIR_ROOT . 'tmp_frontend/');

//DIR_TMP_FRONTEND
/* End Define PATH */
include DIR_ROOT . 'includes/global.php';