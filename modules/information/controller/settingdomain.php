<?php
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}
$domain = new SettingDomain();

//thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('breadcrumb_domain');
$_S['title']           = lang('title');
$_S['description']     = lang('description');

// $action   = $_B['r']->get_string('action','POST');
// $continue = $_B['r']->get_string('continue','POST');
$list_ip     = $_B['r']->get_array('list_ip', 'POST');
$list_domain = $_B['r']->get_array('list_domain', 'POST');
// if (!empty($list_ip) && !empty($list_domain)) {
//     $domain_update = '';
//     foreach ($list_ip as $k => $v) {
//         $ip = $v;
//         @$domain_update .= $list_domain[$k] . ',';
//         //@$param = file_get_contents('https://dns-orig.webbnc.vn/add_domain_by_bnc.php?username=webbnc&pass=anhchangdeptrai&domain=' . $list_domain[$k] . '&ip=' . $ip);
//         // @$param = file_get_contents('https://dns-orig.webbnc.vn/add_domain_by_bnc.php?username=webbnc&pass=anhchangdeptrai&domain=' . $list_domain[$k] . '&ip=203.162.120.70');
//     }

//     echo json_encode($domain->addDomain($domain_update));
//     exit();
// }
$domainremove = strtolower($_B['r']->get_string('domainremove', 'POST'));
if (!empty($domainremove)) {
    //$domain->removeDomain($domainremove);
    $result = array(
        'status' => true,
        'msg'    => 'Xoa thanh cong',
        'domain' => str_replace('.', '', $domainremove),
    );
    echo json_encode($result);
    exit();
}
$domaincheck = $_B['r']->get_string('domaincheck', 'POST');
$domaincheck = strtolower($domaincheck);
if (!empty($domaincheck)) {
    // if ($domain->getFeed($domaincheck) == false) {
    //     $result = array(
    //         'status' => false,
    //         'msg'    => 'Tên miền của bạn đã được trỏ về DNS Webbnc',
    //     );
    // } else {
    //     $result = array(
    //         'status' => true,
    //         'msg'    => lang('domain_ok'),
    //     );
    // }
    $result = array(
            'status' => true,
            'msg'    => lang('domain_ok'),
        );

    echo json_encode($result);
    exit();
}
$domain_check_exist_web = $_B['r']->get_string('domain_check_exist_web', 'POST');
$domain_check_exist_web = strtolower($domain_check_exist_web);
if (!empty($domain_check_exist_web)) {
    if ($domain->checkDomainExistWeb($domain_check_exist_web) == true) {
        $result = array(
            'status' => false,
            'msg'    => 'Tên miền đã được tồn tại trong một website khác. Nếu bạn là chủ nhân của tên miền hay liên hệ với phòng chăm sóc khác hàng của web BNC để thực hiện xác nhận tên miền',
        );
    } else {
        $result = array(
            'status' => true,
            'msg'    => lang('domain_ok'),
        );
    }
    echo json_encode($result);
    exit();
}
//goi Model informationbasic

//Thực hiện action từ submit form. Tên action chính là tên function trong model
if (!empty($action)) {
    $result = $domain->$action();
    if ($result['status']) {
        $_SESSION['success'] = lang('success');
        header("Location:" . $_B['home'] . "/" . $mod . '-settingdomain-lang-');
        exit();
    } else {
        $_SESSION['error_submit'] = $result['error'];
    }
}
$getIP = $domain->getRealIPAddress();
$info  = $domain->info();
$_DATA = $info;

//Load theme cho page settingdomain
$content_module = $_B['temp']->load('settingdomain');