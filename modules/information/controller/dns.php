<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/home.php
 * @Author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 09/10/2014, 10:30 AM
 */
$model_dns = new Dns();
$dns = $model_dns->getDomainFromWeb();
$content_module = $_B['temp']->load('dns');

