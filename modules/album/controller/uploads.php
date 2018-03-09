<?php
/**
 * @Project BNC v2 -> Admin -> Album
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
/*
 * Uploads controller
 */
$uploads                = new uploads();
$uploads->Lfile         = $_FILES["Lfile"];
$uploads->optionsUpload = array('max_size' => 1600);
$uploads->album_id      = $_B['r']->get_int('album_id', 'POST');
$uploads->tmp_id        = $_B['r']->get_string('tmp_id', 'POST');
$uploads->create_time   = time();
$result                 = $uploads->upload();
echo json_encode($result);
