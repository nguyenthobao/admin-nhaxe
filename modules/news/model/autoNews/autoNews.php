<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /Model/autoNews/autoNews.php
 * @Author Nguyen Ba Huong (nguyenbahuong156@gmail.com)
 * @Createdate 08/15/2014, 16:57 PM
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}
include_once DIR_MODULES . 'news/model/autoNews/autoGlobal.php';
class autoNews extends autoGlobal {
    public $idw, $catNewObj, $catNewObjvi, $r, $lang;
    private $uid;
    public function __construct() {
        global $_B;
        $this->r    = $_B['r'];
        $this->idw  = $_B['web']['idw'];
        $this->lang = $_B['cf']['lang'];
        $this->uid  = $_B['uid'];
    }

    public function tin247_com_cat() {
        // $cat = $this->callAPI('http://tin247.com/api/v2/channel.php');
        $cat = $this->callAPI('http://tin12.com/api/channel');
        if ($cat->status == 200) {
            $cats = $cat->data;
            sort($cats);
            echo json_encode($cats);exit();
        }
    }
    public function tin247_com_item() {
        $cat_id = $this->r->get_int('cat_id', 'POST');
        // $cat    = $this->callAPI('http://tin247.com/api/v2/category.php?iCat=' . $cat_id);
        $cat = $this->callAPI('http://tin12.com/api/category?iCat=' . $cat_id);
        if ($cat->status == 200) {
            $cats = $cat->data;
            sort($cats);
            echo json_encode($cats[0]);
            exit();
        }
    }

    public function tin247_com_item_content($id) {
        $content = $this->callAPI('http://tin12.com/api/detail?iNew=' . $id);
        return $content;

    }

    public function getCatSearch() {
        $id        = $this->r->get_int('id', 'GET');
        $catNewObj = new Model($this->lang . '_category');
        $select    = array('id', 'id_lang', 'title', 'parent_id', 'status', 'sort');
        $catNewObj->where('idw', $this->idw);
        $catNewObj->orderBy('sort', 'ASC');
        $data   = $catNewObj->get(null, null, $select);
        $result = $this->fix_tree_category($data);
        if ($result) {
            return $result;
        }
    }
    public function fix_tree_category($data = array(), $parent = 0, $line = '', $str_id = '', $trees = array()) {
        $result = array();
        if (sizeof($data) > 0) {
            foreach ($data as $k => $v) {
                if ($v['parent_id'] == $parent) {
                    $result[] = $v;
                    unset($data[$k]);
                }
            }
        }
        if (sizeof($result) > 0) {
            foreach ($result as $k => $v) {
                $trees[]             = $v;
                $i                   = count($trees) - 1;
                $trees[$i]['line']   = $line;
                $trees[$i]['str_id'] = $str_id;
                $trees               = $this->fix_tree_category($data, $v['id'], $line . '--', $str_id . $v['id'] . '|', $trees);
            }
        }
        return $trees;
    }

    public function copyNews($id, $cat_select, $cat_item) {
        $content = $this->tin247_com_item_content($id);
        $content = json_decode(json_encode($content), true);
        $content = $content['data'][0];
        $content['thumbnail_full']= 'https://cdn.tin12.com/'.$content['thumbnail_full'];
        $content['thumbnail']= 'https://cdn.tin12.com/'.$content['thumbnail'];
        //Get cat_id
        $data_cat = array();
        $cat_id   = json_decode(json_encode($this->callAPI('http://tin12.com/api/category?iCat=' . $cat_item)), true);
        foreach ($cat_id['data'] as $k => $v) {
            if ($v['id'] == $id) {
                $data_cat = $v;
            }
        }
       // Clone image
        // echo '<pre>';
        // print_r($data_cat['thumbnail_full']);
        // echo '</pre>';
        // die();
        $img = cloneImage($content['thumbnail_full'], $this->idw, 'news', fixTitle($data_cat['title']));
        //$img = $data_cat['thumbnail_full'];
        //Title
        $title = $content['title'];
        //source
        $source = $data_cat['website'];
        //content
        $contentA = $content['data'];
        //Author
        $author = $content['author'];

        $data = array(
            'idw'         => $this->idw,
            'cat_id'      => ',' . implode(',', $cat_select) . ',',
            'img'         => $img,
            'title'       => $title,
            'alias'       => fixTitle($title),
            'short'       => '',
            'details'     => $contentA,
            'status'      => 1,
            'create_uid'  => $this->uid,
            'create_time' => time(),
            'author'      => $author,
            'news_source' => $source,
        );
        ob_flush();
        flush();
        return $data;

    }
}