<?php
/**
 * @Project BNC v2 -> Module [seo]
 * @File /meta.php
 * @Author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 2015/06/18, 12:00 [ AM]
 */
class Meta {

    function __construct() {
        global $_B, $_DATA;
        $this->request = $_B['r'];
        $this->idw     = $_B['web']['idw'];
        $this->uid     = $_B['uid'];
        $this->lang    = $this->request->get_string('lang', 'GET');
        $this->model   = new Model_Meta;

    }

    public function index() {
        global $_B, $_DATA;
        $_DATA['listMod'] = array(
            'facebook' => 'Cài đặt admin Facebook',
            'home'     => 'Meta tại trang chủ',
            'product'  => 'Meta tại trang Sản phẩm',
            'news'     => 'Meta tại trang Tin tức',
            'video'    => 'Meta tại trang Video',
            'album'    => 'Meta tại trang Album',
        );
       
        $_DATA['meta']           = $this->model->getMeta();
        $_DATA['content_module'] = $_B['temp']->load('meta');
    }
    public function submit() {
        $setting = $this->request->get_array('setting', 'POST');
        if (!empty($setting)) {
            $this->model->insertMeta($setting);
        }
        header("Location:/seo-meta-lang-vi");
    }

}