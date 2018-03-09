<?php
namespace Bncv2\Core;
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}
class ModelBase {
    public function __construct() {
        global $_B;
        $this->langs        = explode(',', $_B['cf']['lang_use']);
        $this->lang_default = $_B['lang_default'];
        $this->mod          = $_GET['mod'];
        $this->page         = $_GET['page'];
        $this->sub          = $_GET['sub'];
        $this->lang         = $_GET['lang'];
        $this->lang_field   = $this->getLangField();
        $this->idw          = $_B['web']['idw'];
        $this->home         = $_B['home'];
        $this->request      = $_B['r'];
        $this->mod_in_home  = $_B['mod_in_home'];

    }

    /**
     * [getLangId description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-03
     * @return [type]                     [description]
     */
    public function getLangField() {
        if ($this->lang != $this->lang_default) {
            return 'id_lang';
        } else {
            return 'id';
        }
    }

    /**
     * [getUrlPagination description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-03
     * @return [type]                     [description]
     */
    public function getUrlPagination() {
        $url = $this->home . '/' . $this->mod . '-' . $this->page . '-' . $this->sub . '-lang-' . $this->lang;
        return $url;
    }

    /**
     * [setPriKey description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-04
     * @param  [type]                     $data [description]
     */
    public function setPriKey($data) {
        if ($this->lang != $this->lang_default) {
            foreach ($data as $k => $v) {
                $v['id']  = $v['id_lang'];
                $data[$k] = $v;
            }
        }
        return $data;
    }

}
?>
