<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/video.php
 * @Author Hùng
 * @Createdate 08/15/2014, 16:38 PM
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}

class Category extends GlobalCategory {
    public $idw, $catego, $r, $lang;
    private $uid;
    public function __construct() {
        global $_B;
        $this->r    = $_B['r'];
        $this->idw  = $_B['web']['idw'];
        $this->lang = $_B['cf']['lang'];
    }

    public function addcategory() {

        $getLangAndID = getLangAndID();
        $this->catego = new Model($getLangAndID['lang'] . '_category');

        $id = $this->r->get_int('id');
        if ($getLangAndID['lang'] != 'vi') {
            $id_lang = $this->r->get_int('id');
        }
        $title = $this->r->get_string('title', 'POST');
        $title = strip_tags($title);
        //START UPLOAD
        include DIR_HELPER_UPLOAD;
        $options   = array('max_size' => 1600);
        $upload    = new BncUpload($options);
        $name_img  = $upload->upload($this->idw, 'category', 'img_cat');
        $name_icon = $upload->upload($this->idw, 'category', 'icon_cat');
        $name_bg   = $upload->upload($this->idw, 'category', 'bg_cat');

        $data = array(
            'idw'              => $this->idw,
            'title'            => $title,
            'alias'            => fixTitle($this->r->get_string('alias', 'POST')),
            'short'            => $this->r->get_string('short', 'POST'),
            'status'           => $this->r->get_int('status', 'POST'),
            'details'          => $this->r->get_string('content', 'POST'),
            'meta_title'       => $this->r->get_string('meta_title', 'POST'),
            'meta_keyword'     => $this->r->get_string('meta_keyword', 'POST'),
            'meta_description' => $this->r->get_string('meta_description', 'POST'),
            'create_uid'       => $_B['uid'],
            'create_time'      => time(),
            'update_time'      => time(),
            'id_lang'          => (int) $id_lang,
            'img'              => $name_img,
            'icon'             => $name_icon,
            'bg'               => $name_bg,
        );

        if (isset($_POST['img_cat']) && $_POST['img_cat'] == "1") {
            unset($data['img']);
        }
        if (isset($_POST['icon_cat']) && $_POST['icon_cat'] == "1") {
            unset($data['icon']);
        }
        if (isset($_POST['bg_cat']) && $_POST['bg_cat'] == "1") {
            unset($data['bg']);
        }

        if (!empty($id)) {
            if ($this->r->get_string('is_save', 'POST') == 'on') {
                $str_alias = $this->r->get_string('alias', 'POST');
            } else {
                $str_alias = $this->r->get_string('title_alias', 'POST');
            }
            $data = array(
                'idw'              => $this->idw,
                'title'            => $title,
                'alias'            => fixTitle($str_alias),
                'short'            => $this->r->get_string('short', 'POST'),
                'status'           => $this->r->get_int('status', 'POST'),
                'details'          => urlencode(htmlentities(htmlspecialchars($this->r->get_string('content', 'POST')))),
                'meta_title'       => $this->r->get_string('meta_title', 'POST'),
                'meta_keyword'     => $this->r->get_string('meta_keyword', 'POST'),
                'meta_description' => $this->r->get_string('meta_description', 'POST'),
                'update_uid'       => $_B['uid'],
                'update_time'      => time(),
                'id_lang'          => (int) $id_lang,
                'img'              => $name_img,
                'icon'             => $name_icon,
                'bg'               => $name_bg,
            );
            if (isset($_POST['img_cat']) && $_POST['img_cat'] == "1") {
                unset($data['img']);
            }
            if (isset($_POST['icon_cat']) && $_POST['icon_cat'] == "1") {
                unset($data['icon']);
            }
            if (isset($_POST['bg_cat']) && $_POST['bg_cat'] == "1") {
                unset($data['bg']);
            }
            $this->catego->where($getLangAndID['field_id'], $id);
            $this->catego->where('idw', $this->idw);
            $result = $this->catego->update($data);
            if ($getLangAndID['lang'] != 'vi') {
                //Kiểm tra xem bản ghi đã tồn tại bên ngôn ngữ này chưa.
                //True : update
                //false: insert
                $checkExist = $this->checkExist($id, $getLangAndID['lang'], 'category');
                if ($checkExist == false) {
                    $result = $this->catego->insert($data);
                }
            }
        } else {

            $result = $this->catego->insert($data);
        }
        if ($id) {
            $return['last_id'] = $this->r->get_int('id');
        } else {
            $return['last_id'] = $result;
        }
        //$return['last_id'] = $this->r->get_int('id');

        if ($result) {
            $return['status'] = true;
        } else {
            $return['status'] = false;
            $return['error']  = $this->catego->getLastError();
        }
        return $return;
    }
    //get video
    public function getCategoryByID($id = null) {
        global $_B;
        if ($id != null) {
            $getLangAndID = getLangAndID();
            $this->catego = new Model($getLangAndID['lang'] . '_category');
            $this->catego->where($getLangAndID['field_id'], $id);
            $this->catego->where('idw', $this->idw);
            $result            = $this->catego->getOne(null, '*');
            $result['details'] = htmlspecialchars_decode(html_entity_decode(urldecode($result['details'])));
            //    $result['cat_id'] = explode(',', $result['cat_id']);
            if ($result) {
                return $result;
            }
        }

    }

}