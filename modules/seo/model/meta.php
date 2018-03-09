<?php

/**
 * @Project BNC v2 -> Module [seo]
 * @File /meta.php
 * @Author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 2015/06/18, 12:00 [ AM]
 */

class Model_Meta {
    public $langFeild;
    public function __construct() {
        global $_B;
        $this->idw = $_B['web']['idw'];

        $this->langFeild = getLangAndID();

    }
    public function insertMeta($setting) {
        //$this->insertMetFacebook($setting);
        $this->insertMetaHome($setting);
        $this->insertMetaProduct($setting);
        $this->insertMetaNews($setting);
        $this->insertMetaAlbum($setting);
        $this->insertMetaVideo($setting);
    }
    public function getMeta() {
        //$this->insertMetFacebook($setting);
        $data['home']    = $this->insertMetaHome(null, 'GET');
        $data['product'] = $this->insertMetaProduct(null, "GET");
        $data['news']    = $this->insertMetaNews(null, 'GET');
        $data['album']   = $this->insertMetaAlbum(null, 'GET');
        $data['video']   = $this->insertMetaVideo(null, 'GET');
        return $data;
    }
    private function insertMetFacebook($setting) {

    }
    private function insertMetaHome($setting = null, $get = null) {
        $db        = db_connect('information');
        $this->mIf = new Model($this->langFeild['lang'] . '_information', $db);
        $this->mIf->where('idw', $this->idw);
        $if = $this->mIf->getOne();

        if (!empty($if)) {
            if ($get == 'GET') {return $if;}
            $this->mIf = new Model($this->langFeild['lang'] . '_information', $db);
            $this->mIf->where('idw', $this->idw);
            $up = $this->mIf->update($setting['home']);
            return true;
        }

    }
    private function insertMetaProduct($setting = null, $get = null) {

        $db       = db_connect('product');
        $this->mP = new Model($this->langFeild['lang'] . '_setting', $db);
        $this->mP->where('idw', $this->idw);
        $p = $this->mP->getOne();
        if (!empty($p)) {
            if ($get == 'GET') {return $p;}
            $this->mP->where('idw', $this->idw);
            $up = $this->mP->update($setting['product']);
            return true;
        }
    }
    private function insertMetaNews($setting = null, $get = null) {

        $dbn      = db_connect('news');
        $this->mN = new Model($this->langFeild['lang'] . '_config', $dbn);
        $this->mN->where('idw', $this->idw);
        $this->mN->where('`key`', 'setting_page');
        $n = $this->mN->getOne();
        if (!empty($n)) {
            $data = json_decode($n['value_string'], 1);
            if ($get == 'GET') {return $data;}
            $data['meta_title']       = $setting['news']['meta_title'];
            $data['meta_keyword']     = $setting['news']['meta_keyword'];
            $data['meta_description'] = $setting['news']['meta_description'];

            $data = json_encode($data);
            $this->mN->where('idw', $this->idw);
            $this->mN->where('`key`', 'setting_page');
            $up = $this->mN->update(array('value_string' => $data));
            return true;
        } else {
            //{"title":"Tin t\u1ee9c","description":"M\u00f4 t\u1ea3 trang tin t\u1ee9c","meta_title":"meta tin tuc","meta_keyword":"tuwf khoas meta","meta_description":"mota meta","quantity_news":12,"img":"uploadv2\/web\/1\/1\/news\/2015\/04\/20\/11\/05\/1429502702_images-8.jpg"}
            $data['meta_title']       = $setting['news']['meta_title'];
            $data['meta_keyword']     = $setting['news']['meta_keyword'];
            $data['meta_description'] = $setting['news']['meta_description'];
            $data                     = json_encode($data);
            $up                       = $this->mN->insert(array('idw' => $this->idw, 'key' => 'setting_page', 'value_string' => $data));
        }

    }
    private function insertMetaAlbum($setting = null, $get = null) {
        $dbn       = db_connect('album');
        $this->mAb = new Model($this->langFeild['lang'] . '_config', $dbn);
        $this->mAb->where('idw', $this->idw);
        $this->mAb->where('`key`', 'home_config');
        $ab = $this->mAb->getOne();
        if (!empty($ab)) {
            $data                 = json_decode($ab['value_string'], 1);
            $data['meta_keyword'] = $data['meta_keywords'];
            if ($get == 'GET') {return $data;}
            $data['meta_title']       = $setting['album']['meta_title'];
            $data['meta_keywords']    = $setting['album']['meta_keyword'];
            $data['meta_description'] = $setting['album']['meta_description'];

            $data = json_encode($data);
            $this->mAb->where('idw', $this->idw);
            $this->mAb->where('`key`', 'home_config');
            $up = $this->mAb->update(array('value_string' => $data));
            return true;
        } else {
            //{"title":"Tin t\u1ee9c","description":"M\u00f4 t\u1ea3 trang tin t\u1ee9c","meta_title":"meta tin tuc","meta_keyword":"tuwf khoas meta","meta_description":"mota meta","quantity_news":12,"img":"uploadv2\/web\/1\/1\/news\/2015\/04\/20\/11\/05\/1429502702_images-8.jpg"}
            $data['meta_title']       = $setting['album']['meta_title'];
            $data['meta_keywords']    = $setting['album']['meta_keyword'];
            $data['meta_description'] = $setting['album']['meta_description'];
            $data                     = json_encode($data);
            $up                       = $this->mAb->insert(array('idw' => $this->idw, 'key' => 'home_config', 'value_string' => $data));
        }

    }
    private function insertMetaVideo($setting = null, $get = null) {
        $db        = db_connect('video');
        $this->mVd = new Model($this->langFeild['lang'] . '_setting', $db);
        $this->mVd->where('idw', $this->idw);
        $v = $this->mVd->getOne();
        if (!empty($v)) {
            if ($get == 'GET') {return $v;}
            $this->mVd->where('idw', $this->idw);
            $up = $this->mVd->update($setting['video']);
            return true;
        }
    }

}