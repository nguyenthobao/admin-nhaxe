<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller.php 
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 09/05/2014, 12:05 AM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
global $_B;
echo "<pre>";
print_r($_POST);
echo "</pre>";
    	

$content_module = $_B['temp']->load('demophantrang');