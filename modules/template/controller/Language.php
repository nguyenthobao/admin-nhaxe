<?php
/**
 * Code By Nguyen Xuan Truong
 *
 */
class Language extends \Bncv2\Core\Controller {
    function __construct() {
        parent::__construct();
        global $_B;
        $this->temp              = $_B['temp'];
        $this->request           = $_B['r'];
        $this->idw               = $_B['web']['idw'];
        $this->langDefault       = $_B['cf']['lang'];
        $this->dir_mod_frontend  = DIR_MODULES_FRONTEND;
        $this->dir_lang_frontend = DIR_LANG_FRONTEND;

        $this->lang_des = $this->langDes();
    }

    /**
     * [copyBlocks description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-10-26
     * @return [type]                     [description]
     */
    public function copyBlocks() {
        $modelLang = $this->loadModel('Modellanguage');
        $copy      = $this->request->get_array('copy', 'POST');
        //Kiểm tra xem có empty không
        if ($copy['emptyBlocks']) {
            $modelLang->emptyBlock($copy['copyBlocks']);
        }
        //Lấy dữ liệu thuần
        $data = $modelLang->getBlocks($copy['currentLang']);
        //Copy
        foreach ($data as $k => $v) {
            if (!empty($v)) {
                unset($v['id']);
                $modelLang->copyBlocks($copy['copyBlocks'], $v);
            }
        }
        $res = array(
            'status'  => true,
            'message' => 'Sao chép thành công',
        );
        echo json_encode($res);
        exit();
    }

    /**
     * [copyHomes description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-10-26
     * @return [type]                     [description]
     */
    public function copyHomes()
    {
        $modelLang = $this->loadModel('Modellanguage');
        $copy=$this->request->get_array('copy','POST');
        //Kiểm tra xem có empty không
        if($copy['emptyHomes']){
            $modelLang->emptyHome($copy['copyHomes']);
        }
        //Lấy dữ liệu thuần
        $data=$modelLang->getHomes($copy['currentLang']);
        //Copy
        foreach ($data as $k => $v) {
            if(!empty($v)){
                unset($v['id']);
                $modelLang->copyHomes($copy['copyHomes'],$v);
            }
        }
        $res=array(
            'status'=>true,
            'message'=>'Sao chép thành công',
        );
        echo json_encode($res);
        exit();
    }

    public function langDes() {
        $strLang   = 'Afrikaans,af|Albanian,sq|Arabic,ar|Azerbaijani,az|Basque,eu|Bengali,bn|Belarusian,be|Bulgarian,bg|Catalan,ca|Chinese Simplified,zh-CN|Chinese Traditional,zh-TW|Croatian,hr|Czech,cs|Danish,da|Dutch,nl|English,en|Esperanto,eo|Estonian,et|Filipino,tl|Finnish,fi|French,fr|Galician,gl|Georgian,ka|German,de|Greek,el|Gujarati,gu|Haitian Creole,ht|Hebrew,iw|Hindi,hi|Hungarian,hu|Icelandic,is|Indonesian,id|Irish,ga|Italian,it|Japanese,ja|Kannada,kn|Korean,ko|Latin,la|Latvian,lv|Lithuanian,lt|Macedonian,mk|Malay,ms|Maltese,mt|Norwegian,no|Persian,fa|Polish,pl|Portuguese,pt|Romanian,ro|Russian,ru|Serbian,sr|Slovak,sk|Slovenian,sl|Spanish,es|Swahili,sw|Swedish,sv|Tamil,ta|Telugu,te|Thai,th|Turkish,tr|Ukrainian,uk|Urdu,ur|Vietnamese,vi|Welsh,cy|Yiddish,yi';
        $arrayLang = explode('|', $strLang);
        $arrayDes  = array();
        foreach ($arrayLang as $k => $v) {
            $tmp               = explode(',', $v);
            $arrayDes[$tmp[1]] = $tmp[0];
        }
        return $arrayDes;
    }

    public function index() {
        global $_DATA, $_B;
        $getConfig = $this->getConfig();
        if ($getConfig == false) {
            $_DATA['config'] = false;
        } else {
            $_DATA['config'] = $getConfig['value_int'];
        }

        $_DATA['all_lang']       = $_B['langs'];
        $_DATA['lang_translate'] = $this->lang_des;
        $_DATA['lang_default']   = $this->langDefault;
        $_DATA['content_module'] = $this->temp->load('Language');
    }

    public function ajaxLoadFolderMod() {
        global $_DATA;
        $type = $this->request->get_string('type', 'POST');

        if ($type == 'module' || $type == 'system') {
            $lang_select = $this->request->get_string('lang_select', 'POST');
            if ($type == 'module') {
                $mod  = $this->request->get_string('mod', 'POST');
                $path = $this->dir_mod_frontend . $mod . '/lang/' . $lang_select . '/';
            } elseif ($type == 'system') {
                $path = $this->dir_lang_frontend . '/' . $lang_select . '/';
            }

            $scan        = scandir($path, true);
            $non_allow_v = array('"', ';', "'");
            $non_allow_k = array("']", '$_L[\'');
            $lang        = array();
            foreach ($scan as $k => $v) {
                if ($v != '.' && $v != '..') {
                    $lang[$v]['NXT_count'] = 0;
                    $filestring            = file_get_contents($path . '/' . $v);
                    $filearray             = explode("\n", $filestring);
                    foreach ($filearray as $k2 => $v2) {
                        if (strpos($v2, '$_L') === 0) {
                            $tm_lang_line_array = explode('=', $v2);
                            $tmp_lang_k         = trim(str_replace($non_allow_k, '', $tm_lang_line_array[0]));
                            $tmp_lang_v         = strip_tags($tm_lang_line_array[1]);
                            $tmp_lang_v         = str_replace($non_allow_v, '', $tmp_lang_v);
                            $tmp_lang_v         = trim($tmp_lang_v);
                            $lang[$v]['NXT_count'] += 1;
                            $lang[$v][$tmp_lang_k] = $tmp_lang_v;
                        }
                    }
                }
            }
        }
        foreach ($lang as $k => $v) {
            if ($v['NXT_count'] != 0) {
                $_DATA['lang_nxt'][$k] = $v;
            }
        }

        $_DATA['content_module'] = $this->temp->load('LanguageAjax');
    }

    public function ajaxTranslate() {
        $keyword       = $this->request->get_string('nxt_translate', 'POST');
        $lang_src      = $this->request->get_string('lang_select', 'POST');
        $lang_des      = $this->request->get_string('lang_translate', 'POST');
        $nxt_no_verify = array(
            "ssl" => array(
                "verify_peer"      => false,
                "verify_peer_name" => false,
            ),
        );
        $non_allow = array('[', '[', '"');

        $tmp_keyword              = str_replace(' ', '%20', $keyword);
        $url                      = 'https://translate.google.com.vn/translate_a/single?client=t&sl=' . $lang_src . '&tl=' . $lang_des . '&hl=vi&dt=t&ie=UTF-8&oe=UTF-8&otf=1&ssel=3&tsel=4&kc=7&q=' . $tmp_keyword;
        $translate                = file_get_contents($url, false, stream_context_create($nxt_no_verify));
        $translate                = str_replace($non_allow, '', $translate);
        $translate                = preg_replace("/(\,)+/i", ',', $translate);
        $translate                = explode(',', $translate);
        $translate_src            = $translate[1];
        $translate_des            = $translate[0];
        $translate_des            = ucfirst(trim($translate_des));
        $after_translate['value'] = $translate_des;

        echo json_encode($after_translate);
        exit();

    }

    public function ajaxGetCustom() {
        $mod         = $this->request->get_string('mod', 'POST');
        $lang_select = $this->request->get_string('lang_select', 'POST');
        $type        = $this->request->get_string('type', 'POST');
        $path_lang   = DIR_TMP_FRONTEND . 'lang/' . $this->idw . '/' . $lang_select . '/' . $mod;
        $array_dir   = scandir($path_lang);
        unset($array_dir[0]); //unset .
        unset($array_dir[1]); //unset ..
        $key_v       = array();
        $non_allow_v = array('"', ';', "'", '>');
        $non_allow_k = array("']", '$_L[\'');
        foreach ($array_dir as $k => $v) {
            $key_v[$k]['file'] = $v;
            $filestring        = file_get_contents($path_lang . '/' . $v);
            $filearray         = explode("\n", $filestring);
            foreach ($filearray as $k2 => $v2) {
                if (strpos($v2, '$_L') === 0) {
                    $tm_lang_line_array = explode('=', $v2);
                    $tmp_lang_k         = trim(str_replace($non_allow_k, '', $tm_lang_line_array[0]));

                    $tmp_lang_v                        = strip_tags($tm_lang_line_array[1]);
                    $tmp_lang_v                        = str_replace($non_allow_v, '', $tmp_lang_v);
                    $tmp_lang_v                        = trim($tmp_lang_v);
                    $key_v[$k]['content'][$tmp_lang_k] = $tmp_lang_v;
                }
            }
        }
        if (count($key_v) == 0) {
            $result = array(
                'status' => false,
            );
        } else {
            $result = array(
                'status'  => true,
                'content' => $key_v,
            );
        }
        echo json_encode($result);
    }

    public function ajaxWiter() {
        global $_B;
        $key  = $this->request->get_array('key', 'POST');
        $text = $this->request->get_array('text', 'POST');
        $mod  = $this->request->get_string('mod', 'POST');
        $file = $this->request->get_string('file', 'POST');
        $lang = $this->request->get_string('lang', 'POST');

        $content = "<?php \n";
        foreach ($key as $k => $v) {
            $content .= '$_L[' . "'" . $key[$k] . "'" . ']=' . "'" . $text[$k] . "';\n";
        }
        $content .= "?>";
        //Kiem tra ton tai lang idw chua
        $path_lang = DIR_TMP_FRONTEND . 'lang/';
        $array_dir = scandir($path_lang);
        unset($array_dir[0]);
        unset($array_dir[1]);

        //Tao folder lang
        $path_lang_idw = $path_lang . $this->idw;
        if (!in_array($this->idw, $array_dir) && !is_dir($path_lang_idw)) {
            mkdir($path_lang_idw);
        }

        $path_lang_idw_lang = $path_lang_idw . '/' . $lang;
        $scan_lang_idw_lang = scandir($path_lang_idw_lang);
        unset($scan_lang_idw_lang[0]);
        unset($scan_lang_idw_lang[1]);
        if (!in_array($lang, $scan_lang_idw_lang) && !is_dir($path_lang_idw_lang)) {
            mkdir($path_lang_idw_lang);
        }

        $path_lang_idw_lang_mod = $path_lang_idw_lang . '/' . $mod;
        $scan_lang_idw_lang_mod = scandir($path_lang_idw_lang_mod);
        unset($scan_lang_idw_lang_mod[0]);
        unset($scan_lang_idw_lang_mod[1]);

        if (!in_array($mod, $scan_lang_idw_lang_mod) && !is_dir($path_lang_idw_lang_mod)) {
            mkdir($path_lang_idw_lang_mod);
        }

        $path_file_lang = $path_lang_idw_lang_mod . '/' . $file;
        @unlink($path_file_lang);
        $filePHP = fopen($path_file_lang, "w") or die("Unable to open file!");
        fwrite($filePHP, $content);
        fclose($filePHP);

        //Ket thuc xu ly
        $result = array(
            'status'  => true,
            'message' => 'Thao tác thành công',
        );
        echo json_encode($result);
    }

    public function resetAll() {
        if (isset($_POST['ok'])) {
            $path_lang = DIR_TMP_FRONTEND . 'lang/' . $this->idw;
            $this->delTree($path_lang);
        }
        //Ket thuc xu ly
        $result = array(
            'status'  => true,
            'message' => 'Thao tác thành công',
        );
        echo json_encode($result);
    }

    private function delTree($dir) {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->delTree("$dir/$file") : unlink("$dir/$file");
        }
        return @rmdir($dir);
    }

    public function changeLangCus() {
        $langCus = $this->request->get_int('langCus', 'POST');
        if ($this->checkExist() == false) {
            $this->addLangCus($langCus);
        } else {
            $this->updateLangCus($langCus);
        }
        $result = array(
            'status'  => true,
            'message' => 'Thanh cong',
        );
        echo json_encode($result);

    }

    private function addLangCus($langCus) {
        $db   = db_connect('user');
        $obj  = new Model('web_cf_front_end', $db);
        $data = array(
            'idw'       => $this->idw,
            'key'       => 'langCus',
            'value_int' => $langCus,
        );
        return $obj->insert($data);
    }

    private function updateLangCus($langCus) {
        $db  = db_connect('user');
        $obj = new Model('web_cf_front_end', $db);
        $obj->where('idw', $this->idw);
        $obj->where('`key`', 'langCus');
        $data = array(
            'value_int' => $langCus,
        );
        return $obj->update($data);
    }

    private function checkExist($langCus) {
        $db  = db_connect('user');
        $obj = new Model('web_cf_front_end', $db);
        $obj->where('idw', $this->idw);
        $obj->where('`key`', 'langCus');
        if ($obj->num_rows() != 0) {
            return true;
        } else {
            return false;
        }

    }

    public function getConfig() {
        if ($this->checkExist() == true) {
            $db  = db_connect('user');
            $obj = new Model('web_cf_front_end', $db);
            $obj->where('idw', $this->idw);
            $obj->where('`key`', 'langCus');
            return $obj->getOne();
        } else {
            return false;
        }
    }

}