<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/template.php
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 10/13/2014, 16:10 PM
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}

class Temp extends \Bncv2\Core\ModelBase {
    // public $blockUse = array(
    //     1 => array(),
    //     2 => array(),
    //     3 => array(),
    //     4 => array(),
    // );
    // public $blockUseInfo = array(
    //     1 => array(),
    //     2 => array(),
    //     3 => array(),
    //     4 => array(),
    // );
    // public $count = array(
    //     'pos'   => array(
    //         0 => 0,
    //         1 => 0,
    //         2 => 0,
    //         3 => 0,
    //         4 => 0,
    //     ),
    //     'store' => array(
    //         0 => 0,
    //         1 => 0,
    //         2 => 0,
    //         3 => 0,
    //         4 => 0,
    //     ),
    // );
    function __construct() {
        parent::__construct();
        $this->mBlocksUse = new Model($this->lang . '_block');

    }
    public function index($id) {
        $return['blocks']   = $this->getBlocks($id);
        $return['count']    = $this->count;
        $return['blockUse'] = $this->blockUse;
        return $return;
    }
    public function getBlocks($id = 4) {
        $blocksObj = new Model('blocks');
        $blocksObj->where('status', 1);
        $blocksObj->orderBy('sort', 'ASC');
        $this->blocksAll = $this->fixLangBlock($blocksObj->get(), $this->lang);

        $blocksUse = $this->mBlocksUse->where('position', $id)
            ->where('idw', $this->idw)
            ->orderBy('sort', 'ASC')
            ->get();
        $this->divide($blocksUse);
        $data = $this->getBlockPositon($this->blocksAll, $this->blockUse[$id]);
        return $data;
    }
    private function getBlockPositon($blocks, $info) {
        $idblocks = array();
        if (isset($info)) {
            foreach ($info as $key => $value) {
                $idblocks[] = $value['idblock'];
            }
        }
        foreach ($blocks as $key => $value) {
            if (in_array($value['id'], $idblocks)) {
                unset($blocks[$key]);
            }
        }
        return $blocks;
    }
    public function ajax() {
        $action = $this->request->get_string('action', "POST");
        if ($action == '') {
            $action = 'getstore';
        }
        $action = 'ajax_' . $action;
        $data   = $this->$action();
        echo json_encode($data);
    }

    private function ajax_saveposition() {
        global $mod_in_home, $_B;
        $position = $this->request->get_int('position', 'POST');
        $data     = json_decode($_POST['arr'], true);
        foreach ($data as $key => $value) {
            $this->ajax_saveposition_save($value, $position);
        }
        //Xu ly lai idblock
        $this->reProcessIdBlock();
        $return['status'] = true;
        $blocks           = $this->mBlocksUse->where('position', $position)->where('idw', $this->idw)->orderBy('sort', 'ASC')->get();
        foreach ($blocks as $k => $v) {
            $v['thumb']        = $this->getThumb($v);
            $v['name_default'] = $this->getNameDefault($v['file'], $v['module_str']);
            $blocks[$k]        = $v;
        }
        $get_lang = $this->lang;
        include $_B['temp']->load('block_pos_ajax');
        die;
    }

    private function ajax_saveposition_save($data, $position) {
        $checkExist = $this->checkExist($data, $position);
        if ($checkExist > 0) {
            $res = $this->mBlocksUse->where('idw', $this->idw)
                ->where('position', $position)
                ->where('idblock', $data['idblock'])
                ->update($data);
        } else {
            $data['idw']      = $this->idw;
            $data['position'] = $position;
            $res              = $this->mBlocksUse->insert($data);
        }
        return $res;
    }

    private function checkExist($data, $position) {

        return $this->mBlocksUse->where('idw', $this->idw)
            ->where('position', $position)
            ->where('idblock', $data['idblock'])
            ->num_rows();
    }

    private function getAll() {
        return $this->mBlocksUse->where('idw', $this->idw)->orderBy('idblock', 'ASC')->get(null, null, 'id');
    }

    private function reProcessIdBlock() {
        $data = $this->getAll();
        foreach ($data as $k => $v) {
            $data_update = array(
                'idblock' => $k,
                'id'      => $v['id'],
            );
            $this->mBlocksUse->where('idw', $this->idw)->update($data_update);
        }

    }

    private function ajax_hiddenblock() {
        $id    = $this->request->get_int('id', 'POST');
        $data  = json_decode($_POST['arr'], true);
        $idpos = $this->request->get_int('position', 'POST');

        $res = $this->mBlocksUse->where('idw', $this->idw)
            ->where('idblock', $id)
            ->where('position', $idpos)
            ->update($data);

        return array('status' => $res);

    }
    private function ajax_delblock() {
        $id    = $this->request->get_int('id', 'POST');
        $idpos = $this->request->get_int('position', 'POST');

        $res = $this->mBlocksUse->where('idw', $this->idw)
            ->where('idblock', $id)
            ->where('position', $idpos)
            ->delete();

        return array('status' => $res);
    }
    private function ajax_settingBlock() {
        $id     = $this->request->get_int('id', 'POST');
        $title  = $this->request->get_string('title', 'POST');
        $active = $this->request->get_array('active', 'POST');
        $short_textarea = $this->request->get_string('short_textarea', 'POST');
        //Check equal
        $checkEqual = $this->array_equal($active, $this->mod_in_home);

        if ($checkEqual == true) {
            $active = ',all,';
        } else {
            $active = ',' . implode(',', $active) . ',';
        }
        $data = array(
            'title'      => $title,
            'active_mod' => $active,
            'short'      => $short_textarea,
        );
        $res = $this->mBlocksUse->where('idw', $this->idw)
            ->where('id', $id)
            ->update($data);
        return array('status' => $res);
    }
    private function array_equal($a, $b) {
        return (is_array($a) && is_array($b) && array_diff($a, $b) === array_diff($b, $a));
    }
    private function ajax_getstore() {
        $data['blocks']       = $this->getBlocks();
        $data['count']        = $this->count;
        $data['datablockUse'] = $this->blockUse;
        return $data;
    }
    private function divide($blocks) {
        $this->blockUse[0] = $blocks;
        foreach ($blocks as $key => $value) {
            $value['thumb']        = $this->getThumb($value);
            $value['name_default'] = $this->getNameDefault($value['file'], $value['module_str']);
            $value['data']         = json_decode($value['data'], true);
            if (@is_array($this->blockUse[$value['position']]) && @!in_array($value, $this->blockUse[$value['position']])) {
                $this->blockUse[$value['position']][] = $value;
                // } elseif (!is_array($this->blockUse[$value['position']])) {
                //     $this->blockUse[$value['position']] = array($value);
                // }
            } elseif (!in_array($value['position'], $this->blockUse)) {
                $this->blockUse[$value['position']] = array($value);
            }
            @$this->count['pos'][$value['position']]++;
            $this->blockUseInfo[$value['position']][] = $value['idblock'];
        }
    }

    private function getNameDefault($file, $mod) {
        $blocksObj = new Model('blocks');
        $blocksObj->where('file', $file);
        $blocksObj->where('module_str', $mod);
        $data = $blocksObj->getOne();
        return $data[$this->lang . '_name'];
    }

    private function fixLangBlock($blocks, $lang = 'vi') {
        $this->count['store'][0] = count($blocks);
        $key_lang                = $lang . '_name';
        foreach ($blocks as $key => $value) {
            $blocks[$key]['name']   = $value[$key_lang];
            $blocks[$key]['thumb']  = $this->getThumb($value);
            $blocks[$key]['config'] = json_decode($value['config'], true);

            if (!isset($this->count['store'][$value['module']])) {
                $this->count['store'][$value['module']] = 1;
            } else {
                $this->count['store'][$value['module']]++;
            }
        }
        return $blocks;
    }
    private function getThumb($data) {
        if (file_exists('http://dev3.webbnc.vn/modules/' . $data['module_str'] . '/themes/blocks/thumb/' . $data['file'] . '.png')) {
            return 'http://dev3.webbnc.vn/modules/' . $data['module_str'] . '/themes/blocks/thumb/' . $data['file'] . '.png';
        } else {
            return 'http://dev2.webbnc.vn/themes/default/assets/no_image.gif';
        }
    }
}