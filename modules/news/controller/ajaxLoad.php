<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/ajaxLoad.php 
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/15/2014, 16:57 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

include_once(DIR_MODULES.$mod."/model/category.php");
$category = new Category();
$postCat = $category ->getCatSearch();
// echo "<pre>";
// print_r($postCat);
// echo "</pre>";
// die();
include_once $_B['temp']->load('postCategory');
exit();