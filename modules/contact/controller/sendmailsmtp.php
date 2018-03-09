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
$content= '“Quan điểm cá nhân của tôi thì không nên cứng nhắc, doanh nghiệp có thể
 tùy theo điều kiện của mình để cân đối ngày nghỉ. Có thể theo hoặc theo tùy điều kiện sản xuất kinh doanh” -
  Thứ tưởng Phạm Minh Huân nói.';
$pic_attach = DIR_MODULES.'news/themes/images/pic_test_mail.jpg';
$pic = 'http://static1.webbnc.vn:8080/upload/web/35/3568/test/2014/10/22/11/14/141395129468.jpg';
$body =  file_get_contents(DIR_MODULES.'contact/themes/sendmailsmtp.htm');
$body = str_replace("#content#", $content,$body);
