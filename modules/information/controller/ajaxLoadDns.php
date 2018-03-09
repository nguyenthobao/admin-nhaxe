<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/ajaxLoadDns.php 
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/15/2014, 16:57 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
$domain = $_B['r']->get_string('domain','POST');

include_once(DIR_MODULES.$mod."/model/dns.php");

$model_dns = new Dns();
$dns = $model_dns->getDNSbyDomain($domain);
// echo "<pre>";
// print_r($dns);
// echo "</pre>";


include_once $_B['temp']->load('postDns');
exit();