<?php

if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
/*
 * Uploads controller
 */
 $uploads = new uploads();
 $uploads->Lfile = $_FILES["Lfile"];
 $uploads->optionsUpload = array('max_size' => 1600);
 $uploads->slide_id = $_B['r']->get_int('slide_id','POST');
 $uploads->tmp_id = $_B['r']->get_string('tmp_id','POST');
 $uploads->create_time = date("Y-m-d H:i");
 $result = $uploads->upload();
 echo json_encode($result);
