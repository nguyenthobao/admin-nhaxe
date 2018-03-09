<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /config/main.php
 * @Author Quang Chau Tran (quangchauvn@gmail.com)
 * @Createdate 08/14/2014, 02:04 PM
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}
$_B                  = $_NOB                  = array();
$_NOB['db_host']     = '127.0.0.1';
$_NOB['db_user']     = 'sql_anvui';
$_NOB['db_password'] = 'JPs2gdCcquRV7WpR_4jP';
$_NOB['db_charset']  = 'utf8';
$_NOB['db_name']     = 'db_anvui';
$_NOB['db_port']     = 3306;
$_B['home']          = 'http://adminweb.anvui.vn';
$_B['home_frontend'] = 'http://demo.nhaxe.vn/';
$_B['theme']         = 'default';
$_B['home_theme']    = $_B['home'] . '/themes/' . $_B['theme'] . '/';
// $_B['home_theme']   = str_replace('adminweb.anvui.vn', 'cdn-gd-v2-ad.ibnc.vn',$_B['home_theme']);
//$_B['upload_path']  = 'http://dev2.webbnc.vn/cdn/';
// $_B['upload_path']  = 'http://s2.webbnc.vn/';
$_B['upload_path']  = 'http://cdn.anvui.vn/';
$_B['langs']        = array('vi');
$_B['lang_default'] = 'vi';
$_B['cf']['lang_use'] = 'vi,vi';
$_B['sortmodules']  = array(
    'home',
    'information',
    'template',
    'info', 
    'category',
    'menu', 
    'news',
    'album',
    'video',
    'qaa',
    'recruit',
    'document',  
    'maps',
    'list',
    'feedback',
    'contact',
    'receiveemail',
    'poll',
    'commentvtwo',  

);

$_B['perms'] = array(
    'perm_full'   => 31,
    'perm_add'    => 16,
    'perm_del'    => 8,
    'perm_edit'   => 4,
    'perm_view'   => 2,
    'perm_public' => 1,
);

$_CACHE['redis']    = true;
$_CACHE['memcache'] = true;

$_B['config_apps'] = array(
    'news'    => array(
        'title'   => 'Tin tức',
        'feature' => array(
            'auto_news' => array(
                'title'      => 'Tự động lấy tin tức',
                'mod'        => 'news',
                'page'       => 'loadnews',
                'sub'        => 'index',
                'status'     => null, //0 An, 1 hien, 2 deactive
                'end_date'   => '', //Thời gian hết hạn
                'start_date' => '', //Thời gian bắt đầu dùng
            ),
        ),
    ),
    'user'    => array(
        'title'   => 'Thành viên',
        'feature' => array(
            'permission' => array(
                'title'      => 'Phân quyền',
                'mod'        => 'user',
                'page'       => 'permission',
                'sub'        => 'index',
                'status'     => null, //0 An, 1 hien, 2 deactive
                'end_date'   => '', //Thời gian hết hạn
                'start_date' => '', //Thời gian bắt đầu dùng
            ),
        ),
    ),
    'template'    => array(
        'title'   => 'Giao diện',
        'feature' => array(
            'mobile' => array(
                'title'      => 'Phiên bản mobile',
                'mod'        => 'template',
                'page'       => 'template',
                'sub'        => 'index',
                'status'     => null, //0 An, 1 hien, 2 deactive
                'end_date'   => '', //Thời gian hết hạn
                'start_date' => '', //Thời gian bắt đầu dùng
            ),
            'wattermark' => array(
                'title'      => 'Đóng dấu ảnh',
                'mod'        => 'template',
                'page'       => 'template',
                'sub'        => 'index',
                'status'     => null, //0 An, 1 hien, 2 deactive
                'end_date'   => '', //Thời gian hết hạn
                'start_date' => '', //Thời gian bắt đầu dùng
            ),
        ),
    ),
    'product' => array(
        'title'   => 'Sản phẩm',
        'feature' => array(
            'block-hot-deal'            => array(
                'title'      => 'Khuyến mãi event',
                'mod'        => 'product',
                'page'       => 'product',
                'sub'        => 'add|edit',
                'status'     => null, //0 An, 1 hien, 2 deactive
                'end_date'   => '', //Thời gian hết hạn
                'start_date' => '', //Thời gian bắt đầu dùng
            ),
            'block-price_quantity_it'   => array(
                'title'      => 'Giá theo số lượng',
                'mod'        => 'product',
                'page'       => 'product',
                'sub'        => 'add|edit',
                'status'     => null, //0 An, 1 hien, 2 deactive
                'end_date'   => '', //Thời gian hết hạn
                'start_date' => '', //Thời gian bắt đầu dùng
            ),
            'block-price_properties_it' => array(
                'title'      => 'Giá theo thuộc tính',
                'mod'        => 'product',
                'page'       => 'product',
                'sub'        => 'add|edit',
                'status'     => null, //0 An, 1 hien, 2 deactive
                'end_date'   => '', //Thời gian hết hạn
                'start_date' => '', //Thời gian bắt đầu dùng
            ),
            'block-price_big_quantity'  => array(
                'title'      => 'Giá sỉ',
                'mod'        => 'product',
                'page'       => 'product',
                'sub'        => 'add|edit',
                'status'     => null, //0 An, 1 hien, 2 deactive
                'end_date'   => '', //Thời gian hết hạn
                'start_date' => '', //Thời gian bắt đầu dùng
            ),
            'block-auction'             => array(
                'title'      => 'Đấu giá',
                'mod'        => 'product',
                'page'       => 'product',
                'sub'        => 'add|edit',
                'status'     => null, //0 An, 1 hien, 2 deactive
                'end_date'   => '', //Thời gian hết hạn
                'start_date' => '', //Thời gian bắt đầu dùng
            ),
        ),
    ),

);