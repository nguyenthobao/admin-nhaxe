<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /includes/global.php
 * @Author Quang Chau Tran (quangchauvn@gmail.com)
 * @Createdate 08/14/2014, 02:04 PM
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}

include_once DIR_ROOT . 'config/config.php';
include_once DIR_CLASS . 'cache.php';
include_once DIR_HELPER . 'cache/Cache.php';
include_once DIR_CLASS . 'permissions.php';

include_once DIR_CLASS . 'model.php';
include_once DIR_CLASS . 'db/mysqliDB.php';
include_once DIR_CLASS . 'request.php';
include_once DIR_CLASS . 'adminuser.php';
include_once DIR_CLASS . 'api.php';
include_once DIR_CLASS . 'template.php';
include_once DIR_CLASS . 'pagination.php';
include_once DIR_FUNS . 'global.php';

//Fix by truong nguyen
include_once DIR_CLASS . 'model.class.php';
include_once DIR_CLASS . 'controller.class.php';

//default time zone
date_default_timezone_set('Asia/Ho_Chi_Minh');
//Check domain truy cập
allowOrgin();

$web['query_string'] = $_GET;
//for dev
$time0              = (float) microtime_float();
$_B['cache']        = new CacheBNC();
$_B['query_string'] = $_GET;
//db connect
db_connect();
unset($_B['db_host']);
unset($_B['db_user']);
unset($_B['db_password']);
unset($_B['db_name']);
unset($_B['db_charset']);
unset($_B['db_port']);
 
session_start();
ob_start();
// $checkLoginV = checkLogin();

// if (isset($_GET['xteam'])) {
//     setcookie('is_xteam', 1, time()+2592000);
//     header('Location: ' . $_B['home']);
// }
// if (isset($_GET['nbh'])) {
//     setcookie('HUONGNB', 1, 0, 'http://dev2.webbnc.vn');
// }
//info user

//get info of web
$ad = new Adminuser();

$_B['temp_ad'] = new Template();
$_B['lang']    = $_B['r']->get_string('lang', 'GET');
// if(empty($_COOKIE['is_xteam'])){
//     include $_B['temp_ad']->load('baotri');
//     exit();
// }

$_B['ip']      = getIp();
$_B['url_cur'] = curPageURL();

if (isset($_GET['set_web'])) {
    $tenrg = $_GET['set_web'];
    setcookie("__bnc__", base64_encode($tenrg), time() + 3600 * 24 * 365);
    header('Location: ' . $_B['home']);
    die;
}

$_GET['s_name'] = false;
if (isset($_COOKIE['__bnc__'])) {
    $_GET['s_name'] = base64_decode($_COOKIE['__bnc__']);
} else {
    include $_B['temp_ad']->load('selectweb');
    exit();
}
$_B['webhome']   = 'http://' . $_GET['s_name'] . '.nhaxe.vn';
// $_B['webchange'] = 'http://id.webbnc.vn/dang-xuat-http://adminweb.anvui.vn/change.web';
$_B['webname']   = $_GET['s_name'];

$_B['bnc_notify'] = $ad->get_bnc_notify();
$_B['web']        = $ad->get_info_web();
$_B['cf']         = $ad->get_config_admin();



// if ($_COOKIE['sv']) {
//             var_dump($_B['cf']['lang_use_admin']);
// }
if (isset($_B['cf']['lang_use_admin'])) {
    $_B['lang_default'] = $_B['cf']['lang_use_admin'];
}else{
    $_B['lang_default']='vi';
}



$domain     = array($_B['web']['s_name'].'.nhaxe.vn');
$tmp_domain = array_filter(array_values(explode(',', $_B['web']['domain'])));
if (is_array($tmp_domain)) {
    $domain = array_merge($domain, $tmp_domain);
}
$_B['webdomain'] = $_SESSION['domain'] = $domain;
$_SESSION['mod'] = $_GET['mod'];
if ($_B['web']['domain'] != false) {
    $tmp_redirect = array_filter(array_values(explode(',', $_B['web']['domain'])));
    foreach ($tmp_redirect as $v) {
        $_B['web']['redirect'][] = 'http://' . $v;
    }
} else {
    $_B['web']['redirect'][] = 'http://'.$_B['web']['s_name'].'.nhaxe.vn';
}

//set cache idw
$_B['cache']->set('idw', $_B['web']['idw']);

//Thông báo thời gian hết hạn
$enddate = date('H:i:s d-m-Y', $_B['web']['end_date']);
$time    = explode(' ', $enddate);
$times   = explode(':', $time[0]);
$dates   = explode('-', $time[1]);
//
$_B['web']['configTheme'] = $ad->getConfigTheme($_B['web']['theme_id']);

if (!$_B['web']) {
    $error = 'Web bạn chọn không tồn tại!';
    include $_B['temp_ad']->load('selectweb');
    exit();
}
// if ($_COOKIE['sv']) {
//             var_dump($_B['lang']);
// }
if (isset($_B['cf']['lang'])) {
    include DIR_LANG . $_B['lang_default'] . '/main.php';
} else {
    include DIR_LANG . $_B['lang_default'] . '/main.php';
}
//Setting config send mail
$_B['mail']['host']       = 'mta1.mailbnc.vn';
$_B['mail']['port']       = 25;
$_B['mail']['from']       = 'noreply@mailbnc.vn';
$_B['mail']['name_from']  = 'BNC system';
$_B['mail']['reply']      = 'info@webbnc.net';
$_B['mail']['name_reply'] = 'Webbnc.vn';
$_B['mail']['altBody']    = 'Mail được gửi từ hệ thống mailbnc.vn';

//list cac modules
$mods             = $ad->get_modules();
$_B['listModule'] = $ad->get_modules_list();

$mod = $_B['r']->get_string('mod', 'GET');
//Logout All
// if (!$_COOKIE['sv']) {
//     $ad->LogoutWebUser();
//     header('Location: http://id.webbnc.vn/dang-xuat-http://adminweb.anvui.vn/');
//     die("Hệ thống bảo trì. Vui lòng trở lại sau ít phút.");
// }

if ($mod == 'webuserlogout') {
    $ad->LogoutWebUser();
    header('Location: ' . $_B['home']);
}
if (empty($mod) || !array_key_exists($mod, $mods)) {
    $mod = 'home';
}

$mods_not_in_home = array(
    'sso',
    'menu',
    'receiveemail',
    'ads',
    'dns',
    'template',
    'designthemes',
    'seo',
    'list',
    'poll',
    'information',
    'shopfb',
    'media',
    'home',
    'commentvtwo',
    'marketing',
    'sms',
    'notify',
    'nhanhvn',
);
$mod_in_home = array('home');
foreach ($mods as $key => $value) {
    if (!in_array($key, $mods_not_in_home)) {
        $mod_in_home[] = $key;
    }

}

//xu ly menu, goi ngon ngu menu
$_B['menu'] = $ad->menu;
foreach ($mods as $key => $value) {
    if (file_exists(DIR_MODULES . $key . '/lang/' . $_B['lang_default'] . '/menu.php')) {       
            include DIR_MODULES . $key . '/lang/' . $_B['lang_default'] . '/menu.php'; 
         }

}

// goi ngon ngu module
if (isset($_B['cf'])) {
    include DIR_MODULES . $mod . '/lang/' . $_B['lang_default'] . '/main.php';
} else {
    include DIR_MODULES . $mod . '/lang/' . $_B['lang_default'] . '/main.php';
}
// set url giao dien module
$_B['mod_theme'] = $_B['home'] . '/modules/' . $mod . '/themes/';
// $_B['mod_theme']=str_replace('adminweb.anvui.vn', 'cdn-gd-v2-ad.ibnc.vn', $_B['mod_theme']);
//dong ket noi DB chinh va mo ket noi DB theo tung module

$_B['temp'] = new Template($mod);



if (!isset($_B['uid'])) {
    $ad->checkLogin();
}
 
 

if(
    isset($_GET['changepass'])
    && $_GET['changepass'] == 1
    )
{
    $data1['oldPassword'] = $_B['r']->get_string('pass', 'POST');
    $data1['newPassword'] = $_B['r']->get_string('pass1', 'POST');

    $token = $_B['web']['tokenKey'];

    $rt = $ad->PostAnvuiForm('https://dobody-anvui.appspot.com/web_admin/changepassword',$data1,$token);
    if($rt['code'] == 200){
        $res['status'] = true;
    }
    else
    {
        $res['status'] = false;
    } 
    header('Content-Type: application/json');
    echo json_encode($res); 
    die;
}

$_B['user_perm'] = $ad->check_perm();


 
if ($_B['user_perm'] == 'guest' && $mod != 'sso') {
    
    $web_email = $_B['r']->get_string('email', 'POST');
    if ($web_email != '') {
        $web_password = $_B['r']->get_string('password', 'POST');
        $web_save     = $_B['r']->get_int('save_login', 'POST');
        $return       = $ad->LoginWebUser($web_email, $web_password, $web_save);
        if ($return['status']) {
            header('Location: ' . $_B['home']);
        }
    } 

    if (isset($_B['uweb']['uid'])) {
       
            $return['error']  = "Bạn không phải chủ web này, hãy đăng nhập lại bằng tài khoản chủ web!";
            $return['logout'] = true; 
    }
    include $_B['temp_ad']->load('login');
}
 else {
    $_SESSION['active_perm'] = $_B['active_perm'];
    $_B['cf']                = $ad->get_config_admin();
    $_B['menu']              = $ad->getMenu();
    
    if ($_GET['mod'] != 'home' && $_GET['page'] != 'root') {
        $ad->config_apps();
        foreach ($_B['menu'] as $k => $v) {
            if ($v['mod'] == 'news') {
                foreach ($v['submenu'] as $k_s => $v_s) {
                    if ($v_s['title'] == 'loadnews' && $_B['config_apps']['news']['feature']['auto_news']['status'] != 2) {
                        unset($_B['menu'][$k]['submenu'][$k_s]);
                    }
                }
            } elseif ($v['mod'] == 'information') {
                foreach ($v['submenu'] as $k_s => $v_s) {
                    if ($v_s['title'] == 'user_user') {
                        foreach ($v_s['submenu'] as $k_ss => $v_ss) {
                            if ( ($v_ss['title'] == 'user_permission' || $v_ss['title']=='user_web_admin') && $_B['config_apps']['user']['feature']['permission']['status'] != 2) {
                                unset($_B['menu'][$k]['submenu'][$k_s]['submenu'][$k_ss]);
                            }
                        }
                    }

                }
            }elseif ($v['mod'] == 'permission' && $_B['config_apps']['user']['feature']['permission']['status'] != 2) {
                unset($_B['menu'][$k]);
            }
        }
    }

 
    unset($_B['db']);
    db_connect($mod);
    if ($_B['user_perm'] == 'user_mod') {
        if (check_perm_add()) {
            die('ko co quyen');
        }
    }
    include DIR_MODULES . "{$mod}/main.php";
}

if (!empty($content_module)) {
    include $_B['temp_ad']->load('index');
} else {
    exit();
}

// for dev
// $time1 = microtime_float();
// $time = $time1-$time0;
// echo '<div style="position: fixed; bottom: 0; left: 50px; font-size: 12px; background: rgb(3, 170, 177); color: #fff; padding: 2px;">';
// echo 'Time: '.number_format($time,5). " - ";
// echo 'Memory: '.convert(memory_get_usage());
// echo '</div>';
