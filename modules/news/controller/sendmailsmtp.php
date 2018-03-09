<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller.php 
 * @Author Huong Nguyen Ba (nguyenbahuong156@gamil.com)
 * @Createdate 09/05/2014, 12:05 AM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

$pic_attach = DIR_MODULES.'news/themes/images/pic_test_mail.jpg';
$pic = 'http://static1.webbnc.vn:8080/upload/web/35/3568/test/2014/10/22/11/14/141395129468.jpg';
$body =  file_get_contents(DIR_MODULES.'news/themes/sendmailsmtp.htm');
