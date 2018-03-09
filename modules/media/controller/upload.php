<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/home.php
 * @Author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 09/10/2014, 10:30 AM
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}

$l           = $upload->upload($_B['web']['idw'], 'media', 'upload');
$REQUEST_URI = $_SERVER['REQUEST_URI'];

preg_match("/CKEditorFuncNum=([0-9]+)\\&langCode/", $REQUEST_URI, $matches);
$CKEditorFuncNum = $matches[1];
$link            = $_B['upload_path'] . $l;
echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("' . $CKEditorFuncNum . '", "' . $link . '", "");</script>';
die();
?>