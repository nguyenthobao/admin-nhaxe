<?php
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}
class Menu extends \Bncv2\Core\Controller {

    function __construct() {

        parent::__construct();
        $this->model = $this->loadModel('Modelmenu');
    }

    public function fixalias() {
        $model = new Model('vi_menu');
        $model->where('id', 26047, '>');
        $res = $model->get(null, null, 'id,namemenu,alias');
        foreach ($res as $k => $v) {
            if ($v['alias'] != '') {
                continue;
            } else {
                $data['alias'] = fixTitle($v['namemenu']);
                $model->where('id', $v['id']);
                $model->update($data);
            }
        }

        echo '<pre>';
        print_r('Đã Xong Nhé');
        echo '</pre>';
        die();
    }

    /**
     * [menutop description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-03
     * @return [type]                     [description]
     */
    public function menutop() {
        //Khai bao mac dinh
        global $_DATA;
        $_DATA['lang_tab'] = $this->langTab();
        $_DATA['lang']     = $this->lang;
        //Ket thuc bao mac dinh
        $_DATA['link_add']       = $this->home . '/' . $this->mod . '-' . $this->page . '-add-lang-' . $this->lang;
        $_DATA['type']           = 1;
        $result                  = $this->model->getMenuList($_DATA['type']);
        $_DATA['data']           = $this->parent($result['data']);
        $_DATA['menu_br']        = 'Quản lý menu trên';
        $_DATA['content_module'] = $this->temp->load('menulistfix');
    }
    /**
     * [menubottom description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-03
     * @return [type]                     [description]
     */
    public function menubottom() {
        //Khai bao mac dinh
        global $_DATA;
        $_DATA['lang_tab'] = $this->langTab();
        $_DATA['lang']     = $this->lang;
        //Ket thuc bao mac dinh
        $_DATA['link_add']       = $this->home . '/' . $this->mod . '-' . $this->page . '-add-lang-' . $this->lang;
        $_DATA['type']           = 2;
        $result                  = $this->model->getMenuList($_DATA['type']);
        $_DATA['data']           = $this->parent($result['data']);
        $_DATA['menu_br']        = 'Quản lý menu duới';
        $_DATA['content_module'] = $this->temp->load('menulistfix');
    }

    /**
     * [add description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-05
     */
    public function add() {
        //Khai bao mac dinh
        global $_DATA;
        $_DATA['lang_tab']       = $this->langTab();
        $_DATA['lang']           = $this->lang;
        $_DATA['list_cat']       = $this->model->merge_category();
        $menu                    = $this->model->getMenuList(1);
        $_DATA['link_back']      = $this->home . '/menu-menu-menutop-lang-' . $this->lang;
        $_DATA['menu']           = $this->fix_tree($menu['data'], 'parent_id');
        $_DATA['content_module'] = $this->temp->load('menu');
    }

    public function edit() {
        //Khai bao mac dinh
        global $_DATA;
        $_DATA['lang_tab']  = $this->langTab();
        $_DATA['lang']      = $this->lang;
        $_DATA['link_back'] = $this->home . '/menu-menu-menubottom-lang-' . $this->lang;
        $id                 = $this->request->get_int('id', 'GET');
        $_DATA['content']   = $this->model->getById($id);
        $menu               = $this->model->getMenuList($_DATA['content']['type']);
        if ($_DATA['content'] != '') {
            $_DATA['content']['direct_link_decode'] = json_decode($_DATA['content']['direct_link'], true);
        }
        $_SESSION['menu_img']  = $_DATA['content']['img'];
        $_SESSION['menu_icon'] = $_DATA['content']['icon'];
        $_DATA['list_cat']     = $this->model->merge_category();
        $_DATA['menu']         = $this->fix_tree($menu['data'], 'parent_id');
        foreach ($_DATA['menu'] as $k => $v) {
            if ($v['id'] == $id) {
                unset($_DATA['menu'][$k]);
            }
        }
        $_DATA['id']    = $id;
        $_DATA['alias'] = $_DATA['content']['alias'];
       
        $_DATA['content_module'] = $this->temp->load('menuEdit');
    }

    /**
     * [add description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-05
     */
    public function addToDb() {
        //Khai bao mac dinh
        global $_B, $_DATA;
        //Khai bao mac dinh
        $namemenu  = $this->request->get_string('namemenu', 'POST');
        $type      = $this->request->get_int('type', 'POST');
        $op        = $this->request->get_int('op', 'POST'); // 1 Content, 2 Link
        $linktoct  = $this->request->get_string('linktoct', 'POST');
        $linkto    = $this->request->get_string('linkto', 'POST');
        $parent_id = $this->request->get_int('parent_id', 'POST');
        $sort      = $this->request->get_int('sort', 'POST');
        $status    = $this->request->get_int('status', 'POST');
        $nofollow  = $this->request->get_int('nofollow', 'POST');
        $alias     = $this->request->get_string('alias', 'POST');
        $data      = array(
            'namemenu'    => $namemenu,
            'idw'         => $this->idw,
            'type'        => $type,
            'parent_id'   => $parent_id,
            'sort'        => $sort,
            'status'      => $status,
            'create_time' => time(),
            'nofollow'    => $nofollow,
            'alias'       => $alias,
        );

        if ($op == 1) {
            $tmp_link = explode('|', $linktoct);
            $link     = array(
                'mod'  => $tmp_link[0],
                'page' => $tmp_link[1],
                'sub'  => $tmp_link[2],
                'id'   => $tmp_link[3],
            );
            $data['direct_link'] = json_encode($link);
            $data['link']        = '';
        } else {
            $data['link']        = str_replace($_B['home_frontend'], '', $linkto);
            $data['direct_link'] = '';
        }

        //Upload

        if (isset($_SESSION['menu_icon']) && $_SESSION['menu_icon'] != false) {
            $data['icon']          = $_SESSION['menu_icon'];
            $_SESSION['menu_icon'] = false;

        } else {
            $data['icon'] = '';
        }
        if (isset($_SESSION['menu_img']) && $_SESSION['menu_img'] != false) {
            $data['img']          = $_SESSION['menu_img'];
            $_SESSION['menu_img'] = false;
        } else {
            $data['img'] = '';
        }
        $last = $this->model->insert($data);
        if ($type == 1) {
            header('Location:/menu-menu-add-lang-' . $this->lang);
        } else {
            header('Location:/menu-menu-add-lang-' . $this->lang);
        }
    }

    public function editToDb() {
        //Khai bao mac dinh
        global $_B, $_DATA;

        //Khai bao mac dinh
        $namemenu  = $this->request->get_string('namemenu', 'POST');
        $type      = $this->request->get_int('type', 'POST');
        $op        = $this->request->get_int('op', 'POST'); // 1 Content, 2 Link
        $linktoct  = $this->request->get_string('linktoct', 'POST');
        $linkto    = $this->request->get_string('linkto', 'POST');
        $parent_id = $this->request->get_int('parent_id', 'POST');
        $sort      = $this->request->get_int('sort', 'POST');
        $status    = $this->request->get_int('status', 'POST');
        $nofollow  = $this->request->get_int('nofollow', 'POST');
        $id        = $this->request->get_int('id_lang_default', 'POST');
        $alias     = $this->request->get_string('alias', 'POST');
        $data      = array(
            'namemenu'    => $namemenu,
            'idw'         => $this->idw,
            'type'        => $type,
            'parent_id'   => $parent_id,
            'sort'        => $sort,
            'status'      => $status,
            'create_time' => time(),
            'nofollow'    => $nofollow,

        );
        //Kiem tra xem nó co dong ý đổi hay không đã
        if ($_POST['changeSEO'] != false) {
            $data['alias'] = $alias;
        }
        if ($op == 1) {
            $tmp_link = explode('|', $linktoct);
            $link     = array(
                'mod'  => $tmp_link[0],
                'page' => $tmp_link[1],
                'sub'  => $tmp_link[2],
                'id'   => $tmp_link[3],
            );
            $data['direct_link'] = json_encode($link);
            $data['link']        = '';
        } else {
            $data['link']        = str_replace($_B['home_frontend'], '', $linkto);
            $data['direct_link'] = '';
        }

        //Upload
        if (isset($_SESSION['menu_icon']) && $_SESSION['menu_icon'] != false) {
            $data['icon']          = $_SESSION['menu_icon'];
            $_SESSION['menu_icon'] = false;
        } else {
            $data['icon'] = '';
        }
        if (isset($_SESSION['menu_img']) && $_SESSION['menu_img'] != false) {
            $data['img']          = $_SESSION['menu_img'];
            $_SESSION['menu_img'] = false;
        } else {
            $data['img'] = '';
        }

        //Check exist id_lang
        if (count($this->model->getById($id)) != 0) {
            $data['id_lang'] = $id;
            $last            = $this->model->update($data, $id);
        } else {
            $data['id_lang'] = $id;
            $last            = $this->model->insert($data);
        }
        if ($type == 1) {
            header('Location:/menu-menu-menutop-lang-' . $this->lang);
        } else {
            header('Location:/menu-menu-menubottom-lang-' . $this->lang);
        }

    }

    /**
     * [upload description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-05
     * @return [type]                     [description]
     */
    public function upload() {
        $name = $this->request->get_string('new_0', 'POST');
        include_once DIR_HELPER_UPLOAD;
        $options = array(
            'type_file' => 'img',
        );
        $objUpload = new BncUpload($options);
        if (isset($_FILES['menu_icon'])) {
            $link_img              = $objUpload->upload($this->idw, $this->mod, 'menu_icon', $name);
            $_SESSION['menu_icon'] = $link_img;
            $type                  = 'menu_icon';
        } else {
            $link_img             = $objUpload->upload($this->idw, $this->mod, 'menu_img', $name);
            $_SESSION['menu_img'] = $link_img;
            $type                 = 'menu_img';
        }

        if ($link_img != false) {
            $key      = $link_img;
            $url      = $this->home . '/menu-menu-deleteImg-lang-' . $this->lang;
            $link_img = $this->upload_path . '/' . $link_img;
            $result   = [
                'initialPreview'       => [
                    "<img src='" . $link_img . "' class='file-preview-image'>",
                ],
                'initialPreviewConfig' => [
                    ['caption' => $name, 'url' => $url, 'key' => $key],
                ],
                'append'               => true,
            ];
            echo json_encode($result);
        }
    }

    public function deleteImg() {
        $file = $this->request->get_string('key', 'POST');
        $type = $this->request->get_string('type', 'POST');
        $res  = $this->deleteFile($file);
        if ($type == 'menu_img') {
            $_SESSION['menu_img'] = false;
            unset($_SESSION['menu_img']);
        } else {
            $_SESSION['menu_icon'] = false;
            unset($_SESSION['menu_icon']);
        }
        $result = array(
            'status' => $res,
        );
        $this->setNotifyController($result);
        echo json_encode($result);

    }

    /**
     * [ajaxChange description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-04
     * @return [type]                     [description]
     */
    public function ajaxChange() {
        $value = $this->request->get_string('value', 'POST');
        $id    = $this->request->get_int('pk', 'POST');
        $type  = $this->request->get_int('type', 'POST');
        $name  = $this->request->get_string('name', 'POST');
        switch ($name) {
        case 'title':
            $data = array(
                'namemenu' => $value,
            );
            break;
        case 'sort':
            $data = array(
                'sort' => $value,
            );
            break;
        case 'follow':
            $data = array(
                'nofollow' => $value,
            );
            break;
        case 'status':
            $data = array(
                'status' => $value,
            );
            break;
        }

        $this->model->edit($data, $id);
        $result = array(
            'status' => true,
        );
        $this->setNotifyController($result);
        echo json_encode($result);
    }

    /**
     * [ajaxDelete description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-04
     * @return [type]                     [description]
     */
    public function ajaxDelete() {
        $value = $this->request->get_string('value', 'POST');
        $id    = $this->request->get_int('pk', 'POST');
        $name  = $this->request->get_string('name', 'POST');
        if ($name == 'delete') {
            $res = $this->model->delete($id);
        } elseif ($name = 'deleteMulti') {
            $res = false;
            $idm = $this->request->get_array('idm', 'POST');
            foreach ($idm as $v) {
                $res = $this->model->delete($v);
            }
        }
        $result = array(
            'status' => $res,
        );
        $this->setNotifyController($result);
        echo json_encode($result);

    }

    /**
     * [ajaxCopy description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-06
     * @return [type]                     [description]
     */
    public function ajaxCopy() {
        $ids    = $this->request->get_array('ids', 'POST');
        $copy   = $this->model->copy($ids, 1);
        $result = array(
            'status' => $copy,
        );
        $this->setNotifyController($result);
        echo json_encode($result);
    }

    /**
     * [ajaxLoadParent description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-06
     * @return [type]                     [description]
     */
    public function ajaxLoadParent() {
        $type          = $this->request->get_int('type', 'POST');
        $menu          = $this->model->getMenuList($type);
        $_DATA['menu'] = $this->fix_tree($menu['data'], 'parent_id');
        $path          = $this->temp->load('menu_cat_listfix');
        include $path;
        exit();
    }

    /**
     * [copyCatsProduct description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-06
     * @return [type]                     [description]
     */
    public function ajaxCopyCatsProduct() {
        $data = $this->model->copyCatsProduct();
        $res  = array(
            'status' => true,
        );
        $this->setNotifyController($res);
        echo json_encode($res);
        exit();
    }

}
?>

