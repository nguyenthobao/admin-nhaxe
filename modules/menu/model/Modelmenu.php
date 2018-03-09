<?php
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}

class Modelmenu extends \Bncv2\Core\ModelBase {

    function __construct() {
        parent::__construct();
        $this->mMenu         = new Model($this->lang . '_menu');
        $this->ids           = array();
        $this->idCatsProduct = array();
    }
    /**
     * [getMenuListTop description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-03
     * @param  integer                    $type [1= Top , 2 Bottom]
     * @return [type]                           [description]
     */
    public function getMenuList($type = 1) {
        $result['data'] = $this->getMenuItem($type);
        return $result;

    }

    /**
     * [getMenuItem description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-03
     * @param  integer                    $type  [description]
     * @param  [type]                     $start [description]
     * @return [type]                            [description]
     */
    public function getMenuItem($type = 1) {

        $this->mMenu->where('idw', $this->idw);
        $this->mMenu->where('type', $type);
        $this->mMenu->orderBy('sort', 'ASC');
        $result = $this->mMenu->get(null, null, '*');
        return $result;
    }

    /**
     * [edit description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-04
     * @param  [type]                     $data [description]
     * @param  [type]                     $id   [description]
     * @return [type]                           [description]
     */
    public function edit($data, $id) {
        $this->mMenu->where('idw', $this->idw);
        $this->mMenu->where('id', $id);
        return $this->mMenu->update($data);
    }

    /**
     * [delete description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-04
     * @param  [type]                     $id [description]
     * @return [type]                         [description]
     */
    public function delete($id) {
        $this->mMenu->where('idw', $this->idw);
        $this->mMenu->where('id', $id);
        return $this->mMenu->delete();
    }

    /**
     * [insert description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-05
     * @param  [type]                     $data [description]
     * @return [type]                           [description]
     */
    public function insert($data) {
        return $this->mMenu->insert($data);
    }

    /**
     *
     */

    public function update($data, $id) {
        $res = $this->mMenu->where('idw', $this->idw)
            ->where('id', $id)
            ->update($data);
        return $res;
    }
    /**
     * [getById description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-05
     * @param  [type]                     $id [description]
     * @return [type]                         [description]
     */
    public function getById($id) {
        $data = $this->mMenu->where('idw', $this->idw)
            ->where('id', $id)
            ->getOne(null, '*');
        return $data;
    }

    /**
     * [copy description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-05
     * @param  [type]                     $ids  [description]
     * @param  integer                    $type [description]
     * @return [type]                           [description]
     */
    public function copy($ids, $type = 1) {
        $newId      = array();
        $newsIdLang = array();
        if ($ids) {
            $data = $this->mMenu->where('id', $ids, 'IN')
                ->where('parent_id', $ids, 'NOT IN')
                ->where('idw', $this->idw)
                ->where('type', $type)
                ->get(null, null, '*');
            $this->copyChild($type, $data);
        }

        $idCopy = array();
        foreach ($this->ids as $k => $v) {
            unset($v['data']['id']);
            $v['data']['namemenu'] .= ' - Copy - ' . date('H:i:s d-m-Y');
            $v['data']['status'] = 0;
            $idCopy[$v['id']]    = $v;
        }
        foreach ($idCopy as $id => $result) {
            if ($result['parent_id'] != 0) {
                if (isset($newId[$result['parent_id']])) {
                    $result['data']['parent_id'] = $newId[$result['parent_id']];
                }
            }
            $result['data'][$this->getLangField()] = $newId[$result['id']];
            $latest_id                             = $this->insert($result['data']);
            $newId[$result['id']]                  = $latest_id;
        }
        unset($idCopy);
        return true;
    }

    /**
     * [copyChild description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-05
     * @param  [type]                     $type      [description]
     * @param  array                      $data      [description]
     * @param  integer                    $parent_id [description]
     * @return [type]                                [description]
     */
    public function copyChild($type, $data = array(), $parent_id = 0) {
        $current = array();
        if (count($data) > 0) {
            foreach ($data as $k => $v) {
                $this->ids[] = array(
                    'id'        => $v['id'],
                    'parent_id' => $parent_id,
                    'data'      => $v,
                );

                $current = $this->mMenu->where('parent_id', $v['id'])
                    ->where('idw', $this->idw)
                    ->where('type', $type)
                    ->get(null, null, '*');
                $this->copyChild($type, $current, $v['id']);
            }
        }
    }

    public function copyCatsProduct() {
        //var_dump($this->lang);
        $db_product = db_connect('product');
        $mP         = new Model($this->lang . '_category', $db_product);
        $data       = $mP->where('idw', $this->idw)->get(null, null, 'id,id_lang,parent,name,background,avatar');

        $newId      = array();
        $newsIdLang = array();
        $this->copyChildCatsProduct($data);
        $idCopy = $this->idCatsProduct;

        foreach ($idCopy as $id => $result) {
            if ($result['parent_id'] != 0) {
                if (isset($newId[$result['parent_id']])) {
                    $result['data']['parent_id'] = $newId[$result['parent_id']];
                }
            }
            $result['data']['id'] = $newId[$result['id']];
            $latest_id            = $this->insert($result['data']);
            $newId[$result['id']] = $latest_id;
        }

        unset($idCopy);
        return true;
    }
    public function copyChildCatsProduct($data = array(), $parent_id = 0) {
        $current    = array();
        $db_product = db_connect('product');
        $mP         = new Model($this->lang . '_category', $db_product);
        if (count($data) > 0) {
            foreach ($data as $k => $v) {
                $v['parent_id']   = $v['parent'];
                $v['namemenu']    = $v['name'];
                $v['img']         = $v['background'];
                $v['icon']        = $v['avatar'];
                $v['direct_link'] = json_encode(array('mod' => 'product', 'page' => 'product', 'sub' => 'category', 'id' => $v['id']));
                $v['create_time'] = time();
                $v['type']        = 1;
                $v['idw']         = $this->idw;
                $v['status']      = 1;
                $v['sort']        = 0;
                unset($v['parent']);
                unset($v['name']);
                unset($v['background']);
                unset($v['avatar']);
                $this->idCatsProduct[] = array(
                    'id'        => $v['id'],
                    'parent_id' => $parent_id,
                    'data'      => $v,
                );
                $current = $mP->where('parent', $v['id'])->where('idw', $this->idw)->get(null, null, 'id,id_lang,parent,name,background,avatar');
                $this->copyChildCatsProduct($current, $v['id']);
            }
        }
    }
    /**
     * [news description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-05
     * @return [type]                     [description]
     */
    private function news() {
        $db_news = db_connect('news');
        $mN      = new Model($this->lang . '_category', $db_news);
        $data    = $mN->where('idw', $this->idw)->get(null, null, 'id,id_lang,parent_id,title');
        return $this->setPriKey($data);
    }

    private function album() {
        $db_album_category = db_connect('album');
        $mA                = new Model($this->lang . '_album_category', $db_album_category);
        $data              = $mA->where('idw', $this->idw)->get(null, null, 'id,id_lang,parent_id,title');
        return $this->setPriKey($data);
    }

    private function qaa() {
        $db_qaa = db_connect('qaa');
        $mQ     = new Model($this->lang . '_faq_category', $db_qaa);
        $data   = $mQ->where('idw', $this->idw)->get(null, null, 'id,id_lang,parent_id,title');
        return $this->setPriKey($data);
    }

    private function video() {
        $db_video = db_connect('video');
        $mV       = new Model($this->lang . '_category', $db_video);
        $data     = $mV->where('idw', $this->idw)->get(null, null, 'id,id_lang,parent_id,title');
        return $this->setPriKey($data);
    }

    private function product() {
        $db_product = db_connect('product');
        $mP         = new Model($this->lang . '_category', $db_product);
        $data       = $mP->where('idw', $this->idw)->get(null, null, 'id,id_lang,parent,name as title');
        return $this->setPriKey($data);
    }

    private function category() {
        $db_category = db_connect('category');
        $mC          = new Model($this->lang . '_category', $db_category);
        $data        = $mC->where('idw', $this->idw)->where('status', 1)->get(null, null, 'id,id_lang,title');
        return $this->setPriKey($data);
    }
    private function recruit() {
        $db_recruit = db_connect('recruit');
        $mC         = new Model($this->lang . '_recruit', $db_recruit);
        $data       = $mC->where('idw', $this->idw)->where('status', 1)->get(null, null, 'id,id_lang,title');
        return $this->setPriKey($data);
    }
    private function info() {
        $db_info = db_connect('info');
        $mC      = new Model($this->lang . '_info', $db_info);
        $data    = $mC->where('idw', $this->idw)->where('status', 1)->get(null, null, 'id,id_lang,title');
        return $this->setPriKey($data);
    }
    public function merge_category() {
        $page = array(
            'basic' => array(
                'name'    => 'Trang cơ bản',
                'mod'     => '',
                'page'    => 'basic',
                'sub'     => '',
                'content' => array(
                    array(
                        'id'        => '',
                        'id_lang'   => '',
                        'parent_id' => 0,
                        'title'     => 'Trang chủ',
                        'line'      => '',
                        'str_id'    => '',
                        'content'   => '/|||',
                    ),
                    array(
                        'id'        => '',
                        'id_lang'   => '',
                        'parent_id' => 0,
                        'title'     => 'Trang Bản đồ',
                        'line'      => '',
                        'str_id'    => '',
                        'content'   => 'maps|||',
                    ),
                    array(
                        'id'        => '',
                        'id_lang'   => '',
                        'parent_id' => 0,
                        'title'     => 'Trang liên hệ',
                        'line'      => '',
                        'str_id'    => '',
                        'content'   => 'contact|||',
                    ),
                    array(
                        'id'        => '',
                        'id_lang'   => '',
                        'parent_id' => 0,
                        'title'     => 'Trang giới thiệu',
                        'line'      => '',
                        'str_id'    => '',
                        'content'   => 'info|||',
                    ),
                    array(
                        'id'        => '',
                        'id_lang'   => '',
                        'parent_id' => 0,
                        'title'     => 'Trang tuyển dụng',
                        'line'      => '',
                        'str_id'    => '',
                        'content'   => 'recruit|||',
                    ),
                ),
            ),
        );
        $category = array( 
            'news'     => array(
                'name'    => 'Tin tức',
                'mod'     => 'news',
                'page'    => 'category',
                'sub'     => 'cat',
                'content' => $this->fix_tree($this->news(), 'parent_id'),
            ),
            'album'    => array(
                'name'    => 'Album',
                'mod'     => 'album',
                'page'    => 'category',
                'sub'     => '',
                'content' => $this->fix_tree($this->album(), 'parent_id'),
            ), 
            'video'    => array(
                'name'    => 'Video',
                'mod'     => 'video',
                'page'    => 'category',
                'sub'     => 'cat',
                'content' => $this->fix_tree($this->video(), 'parent_id')),

            'category' => array(
                'name'    => 'Trang chuyên mục',
                'mod'     => 'category',
                'page'    => 'detail',
                'sub'     => 'view',
                'content' => $this->category(),
            ), 
            'info'     => array(
                'name'    => 'Giới thiệu',
                'mod'     => 'info',
                'page'    => 'detail',
                'sub'     => 'view',
                'content' => $this->info(),
            ),
        );
        return array_merge($page, $category);

    }
    public function fix_tree($data = array(), $col, $parent = 0, $line = '', $str_id = '', $trees = array()) {
        $result = array();
        if (count($data) > 0) {
            foreach ($data as $k => $v) {
                if ($v[$col] == $parent) {
                    $result[] = $v;
                    unset($data[$k]);
                }
            }
        }
        if (count($result) > 0) {
            foreach ($result as $k => $v) {
                $trees[]             = $v;
                $i                   = count($trees) - 1;
                $trees[$i]['line']   = $line;
                $trees[$i]['str_id'] = $str_id;
                $trees               = $this->fix_tree($data, $col, $v['id'], $line . '--', $str_id . $v['id'] . '|', $trees);
            }
        }
        return $trees;
    }

}