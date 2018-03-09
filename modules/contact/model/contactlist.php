<?php

if (!defined('BNC_CODE')) {
    exit('Access Denied');
}

class Contactlist {
    public $idw, $r, $infolist;
    private $uid;
    public function __construct() {
        global $_B;
        $this->r   = $_B['r'];
        $this->idw = $_B['web']['idw'];
        $this->uid = $_B['uid'];

    }
    public function addContactInfo() {
        $lang = $this->r->get_string('lang', 'GET');

        //START UPLOAD
        include DIR_HELPER_UPLOAD;
        $options   = array('max_size' => 1600);
        $upload    = new BncUpload($options);
        $name_img  = $upload->upload($this->idw, 'contact', 'img_cat');
        $name_icon = $upload->upload($this->idw, 'contact', 'icon_cat');
        $name_bg   = $upload->upload($this->idw, 'contact', 'bg_cat');

        $data = array(
            'idw'    => $this->idw,
            'info'   => $this->r->get_string('info', 'POST'),
            'maps'   => base64_encode($this->r->get_string('maps', 'POST')),
            'email'   => $this->r->get_string('email', 'POST'),
            'status' => $this->r->get_string('status', 'POST'),
            'img'    => $name_img,
            'icon'   => $name_icon,
            'bg'     => $name_bg,
        );
       
        
        if(!empty($data['email'])){
            $pattern = '#^[a-z][a-z0-9\._]{2,31}@[a-z0-9\-]{3,}(\.[a-z]{2,4}){1,2}$#';
            if(preg_match($pattern,$data['email'], $match)!= 1){
                unset($data['email']);
            }
        }else{
            unset($data['email']);
        }
        
        if (isset($_POST['img_cat']) && $_POST['img_cat'] == "1") {
            unset($data['img']);
        }
        if (isset($_POST['icon_cat']) && $_POST['icon_cat'] == "1") {
            unset($data['icon']);
        }
        if (isset($_POST['bg_cat']) && $_POST['bg_cat'] == "1") {
            unset($data['bg']);
        }

        //Check Exist
        $exist    = $this->checkExistContactInfo($lang);
        $infolist = new Model($lang . '_contactinfo');

        if ($exist != false) {
            $infolist->where('idw', $this->idw);
            $result = $infolist->update($data);
        } else {
            $result = $infolist->insert($data);
        }

        if ($result) {
            $return['status'] = true;
        } else {
            $return['status'] = false;
        }
        return $return;
    }

    public function checkExistContactInfo($lang) {
        $obj = new Model($lang . '_contactinfo');
        $obj->where('idw', $this->idw);
        return $obj->num_rows();

    }

    public function getContactInfo() {
        global $_B;
        $lang     = $this->r->get_string('lang', 'GET');
        $infolist = new Model($lang . '_contactinfo');
        $infolist->where('idw', $this->idw);
        $select       = '*';
        $data         = $infolist->getOne(null, null, $select);
        $data['maps'] = base64_decode($data['maps']);
        return $data;
    }
}
