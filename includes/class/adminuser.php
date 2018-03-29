<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /includes/class/adminusser.php
 * @Author Quang Chau Tran (quangchauvn@gmail.com)
 * @Createdate 08/14/2014, 06:00 PM
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}
class Adminuser {
    /**
     * @var mixed
     */
    public $idw;
    /**
     * @var mixed
     */
    public $s_name;
    /**
     * @var mixed
     */
    public $info;
    /**
     * @var mixed
     */
    public $config;
    /**
     * @var mixed
     */
    public $menu;
    /**
     * @var mixed
     */
    private $db, $r, $web, $cf;
    /**
     * @var string
     */
    private $name_cookie = 'webbncbeta';
    public function __construct() {
        global $_B;
        $this->db  = $_B['db'];
        $this->r   = $_B['r'];
        $this->idw = $_B['web']['idw'];
    }
    /**
     * @return mixed
     */
    public function getMenu() {
        global $_B, $_L;  

            $menu       = $this->menu;
         
           $mod_not_active = array(
                'marketing',
                'appbnc', 
                'qaa',
                'recruit',
                'feedback',
                'receiveemail',
                'poll',
                'apps',
                'permission',
                'analytics',
                'ads',
                'media',
                'user',
                'support',
                'home',
            );
 
            $mod_active = $this->getModActive(); 

            foreach ($menu as $key => $value) {
                if (  in_array($value['mod'], $mod_not_active)   ) {
                    unset($menu[$key]);
                } else {
                    $key_mod            = array_search($value['mod'], $mod_active);
                    $menu[$key]['sort'] = $key_mod + 3;
                }
                if ($value['mod'] == 'home') {
                    $menu[$key]['sort'] = 0;
                }
            }
            foreach ($menu as $key => $row) {
                if ($row['mod'] == 'seo' || $row['mod'] == 'user' || $row['mod'] == 'maps' || $row['mod'] == 'contact' || $row['mod'] == 'feedback') {
                    unset($menu[$key]);
                }
                $return_sort[$key] = $row['sort'];
            }
            array_multisort($return_sort, SORT_ASC, $menu);

           
            

            return $menu;
        

    }
    /**
     * [getModActive description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-06-12
     * @return [type]                     [description]
     */
    public function getModActive() {
        global $_B;
        //Bo nhung mod chua su dung
        unset($_B['listModule'][array_search('commentv2', $_B['listModule'])]);
        unset($_B['listModule'][array_search('deal', $_B['listModule'])]);
        unset($_B['listModule'][array_search('lists', $_B['listModule'])]);
        $oBj = new Model('web_mod');
        $oBj->where('idw', $_B['web']['idw']);
        $data = $oBj->getOne('customs_mod');
        if (isset($data['customs_mod'])) {
            if ($data['customs_mod'] != ',all,') {
                $sortmodules = array_values(array_filter(explode(',', $data['customs_mod'])));
            } else {
                $sortmodules = $_B['listModule'];
            }
        } else {
            $sortmodules = $_B['listModule'];
        }

        return $sortmodules;
    }

    public function check_perm() {
        global $_B; 
        if ( $_B['web']['userId'] == $_B['uweb']['userId']  ) {
            return 'boss';
        } 

        return 'guest';
    }
    // public function check_perm($mod,$page,$id,$act){
    //     return true;
    // }
    /**
     * @param $name
     */
    public function tableExits($name) {
        global $_B;
        if ($_B['db']->table_exist($name)) {
            return true;
        } else {
            return false;
        }

    }
    /**
     * Get list modules of adminuser.
     *
     * @return modules array
     */
    public function get_modules_list() {
        $listObj  = new Model('mod_list');
        $listfull = $listObj->get();
        $list     = array();
        foreach ($listfull as $key => $value) {
            $list[$value['idm']] = $value['name'];
        }

        return $list;
    }
    /**
     * @return mixed
     */
    public function get_modules() {
        global $_B;
        $dir     = DIR_MODULES;
        $dir_    = opendir($dir);
        $modules = array(
            'sso'          => array(
                'name_modue' => 'sso',
            ),
            'designthemes' => array(
                'name_modue' => 'designthemes',
            ),
            'list'         => array(
                'name_modue' => 'list',
            ),
            'maps'         => array(
                'name_modue' => 'maps',
            ),
            'notify'       => array(
                'name_modue' => 'notify',
            ),

        );
        while (($name = readdir($dir_)) !== false) {

            if (preg_match('/^[a-z]/', $name)) {
                if (array_key_exists($name, $modules)) {
                    continue;
                }

                if (is_dir($dir . $name)) {
                    $data = array();
                    if (file_exists($dir . $name . '/config.xml')) {
                        $data = $this->xml2array($dir . $name . '/config.xml');
                        /*if(!empty($data['config']['menus'])){
                    foreach ($data['config']['menus'] as $key => $value) {
                    $this->menu[] = $value;
                    }
                    } */
                    }
                    if (isset($data['config'])) {
                        $modules[$name] = $data['config'];
                    }

                }
            }
        }
        $sortmodules = $modules;
        foreach ($_B['sortmodules'] as $key => $value) {

            if (!empty($sortmodules[$value]['menus'])) {
                foreach ($sortmodules[$value]['menus'] as $k => $v) {
                    $this->menu[] = $v;
                }
            }
            unset($sortmodules[(string) $value]);
        }
        foreach ($sortmodules as $key => $value) {

            if (!empty($value['menus'])) {
                foreach ($value['menus'] as $key => $value) {
                    $this->menu[] = $value;
                }
            }
        }

        return $modules;
    }
    /**
     * Get BNC notify
     *
     * @return notufy array
     */
    public function get_bnc_notify() {
        $notify = new Model('bnc_notify', false);
        $notify->where('status', 1);
        $notify->orderBy('id', 'DESC');

        return $notify->get();
    }
    /**
     * Get info web (by idw or by s_name)
     *
     * @return info array
     */
    public function get_info_web() {
        $this->idw    = $this->r->get_int('idw', 'GET');
        $this->s_name = $this->r->get_string('s_name', 'GET');
        $web          = new Model('web', false);

        if (!empty($this->idw)) {
            $web->where('idw', $this->idw);
        } else {
            $web->where('s_name', $this->s_name);
        }

        $this->info   = $web->get();
        @$this->info  = $this->info[0];
        $this->idw    = $this->info['idw'];
        $this->s_name = $this->info['s_name'];

        return $this->info;
    }
    /**
     * @param $uid
     * @return mixed
     */
    public function getWebUid($uid) {
        $web = new Model('web', false);
        $web->where('uid', $uid);
        $webinfo = $web->getOne();
        if (isset($webinfo['s_name'])) {
            return $webinfo;
        } else {
            return false;
        }
    }
    /**
     * Check perm
     *
     * @return perm boolean
     */

    /**
     * Get config
     *
     * @return info array
     */
    public function get_config_admin() {
        $cf = new Model('web_cf_admin', false);
        $cf->where('idw', $this->idw);
        $this->config = $cf->get();
        foreach ($this->config as $k => $v) {
            if (!empty($v['value_int'])) {
                $config[$v['key']] = $v['value_int'];
            } else {
                $config[$v['key']] = $v['value_string'];
            }
        }
        $this->config = $config;

        return $this->config;
    }
    /**
     * Get config.xml của theme
     */
    public function getConfigTheme($theme_id) {
        $dir = DIR_THEME_FRONTEND . $theme_id . '/config.json';
        if (!file_exists($dir)) {
            copy(DIR_THEME_FRONTEND . '1/config.json', $dir);
            chmod($dir, 0664);
        }
        $configs = json_decode(file_get_contents($dir), 1);

        return $configs['config'];
    }
    /**
     * @param $url
     * @param $get_attributes
     * @param $priority
     * @return null
     */
    private function xml2array($url, $get_attributes = 1, $priority = 'tag') {
        global $_B;
        $contents = "";
        if (!function_exists('xml_parser_create')) {
            return array();
        }
        $parser = xml_parser_create('');
        if (!($fp = @fopen($url, 'rb'))) {
            return array();
        }
        while (!feof($fp)) {
            $contents .= fread($fp, 8192);
        }
        fclose($fp);
        xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8");
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, trim($contents), $xml_values);
        xml_parser_free($parser);
        if (!$xml_values) {
            return;
        }
        //Hmm...
        $xml_array          = array();
        $parents            = array();
        $opened_tags        = array();
        $arr                = array();
        $current            = &$xml_array;
        $repeated_tag_index = array();

        foreach ($xml_values as $data) {
            if ($_B['web']['idw'] == 2254) {
                $data['value'] = str_replace('lang-vi', 'lang-en', $data['value']);
            }
            unset($attributes, $value);
            extract($data);
            $result          = array();
            $attributes_data = array();
            if (isset($value)) {
                if ($priority == 'tag') {
                    $result = $value;
                } else {
                    $result['value'] = $value;
                }

            }
            if (isset($attributes) && $get_attributes) {
                foreach ($attributes as $attr => $val) {
                    if ($priority == 'tag') {
                        $attributes_data[$attr] = $val;
                    } else {
                        $result['attr'][$attr] = $val;
                    }
                    //Set all the attributes in a array called 'attr'
                }
            }
            if ($type == "open") {
                $parent[$level - 1] = &$current;
                if (!is_array($current) || (!in_array($tag, array_keys($current)))) {
                    $current[$tag] = $result;
                    if ($attributes_data) {
                        $current[$tag . '_attr'] = $attributes_data;
                    }

                    $repeated_tag_index[$tag . '_' . $level] = 1;
                    $current                                 = &$current[$tag];
                } else {
                    if (isset($current[$tag][0])) {
                        $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
                        $repeated_tag_index[$tag . '_' . $level]++;
                    } else {
                        $current[$tag] = array(
                            $current[$tag],
                            $result,
                        );
                        $repeated_tag_index[$tag . '_' . $level] = 2;
                        if (isset($current[$tag . '_attr'])) {
                            $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                            unset($current[$tag . '_attr']);
                        }
                    }
                    $last_item_index = $repeated_tag_index[$tag . '_' . $level] - 1;
                    $current         = &$current[$tag][$last_item_index];
                }
            } elseif ($type == "complete") {
                if (!isset($current[$tag])) {
                    $current[$tag]                           = $result;
                    $repeated_tag_index[$tag . '_' . $level] = 1;
                    if ($priority == 'tag' && $attributes_data) {
                        $current[$tag . '_attr'] = $attributes_data;
                    }

                } else {
                    if (isset($current[$tag][0]) && is_array($current[$tag])) {
                        $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
                        if ($priority == 'tag' && $get_attributes && $attributes_data) {
                            $current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
                        }
                        $repeated_tag_index[$tag . '_' . $level]++;
                    } else {
                        $current[$tag] = array(
                            $current[$tag],
                            $result,
                        );
                        $repeated_tag_index[$tag . '_' . $level] = 1;
                        if ($priority == 'tag' && $get_attributes) {
                            if (isset($current[$tag . '_attr'])) {
                                $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                                unset($current[$tag . '_attr']);
                            }
                            if ($attributes_data) {
                                $current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
                            }
                        }
                        $repeated_tag_index[$tag . '_' . $level]++; //0 and 1 index is already taken
                    }
                }
            } elseif ($type == 'close') {
                $current = &$parent[$level - 1];
            }
        }

        return ($xml_array);
    }
    public function LogoutWebUser() {
        global $_B;
        setcookie($this->name_cookie, '', time() - 86400 * 36, '/');
        $userlogin = new Model('web_user_login');
        $userlogin->where('cookie', $_B['cookie']);
        $userlogin->delete();

        return true;
    }
    /**
     * @param $email
     * @param $password
     * @param $remember
     * @return mixed
     */
    public function PostAnvui($url,$data){
        if(empty($token)){
            $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ2IjowLCJkIjp7InVpZCI6IkFETTExMDk3Nzg4NTI0MTQ2MjIiLCJmdWxsTmFtZSI6IkFkbWluIHdlYiIsImF2YXRhciI6Imh0dHBzOi8vc3RvcmFnZS5nb29nbGVhcGlzLmNvbS9kb2JvZHktZ29ub3cuYXBwc3BvdC5jb20vZGVmYXVsdC9pbWdwc2hfZnVsbHNpemUucG5nIn0sImlhdCI6MTQ5MjQ5MjA3NX0.PLipjLQLBZ-vfIWOFw1QAcGLPAXxAjpy4pRTPUozBpw';
        }
        $request_header = [
            'Content-Type:text/plain',
            sprintf('DOBODY6969: %s', $token)
        ];

        $ch = curl_init();

     
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_header);
 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec ($ch);

        curl_close ($ch); 
        return json_decode($response,1);
    }
     public function PostAnvuiForm($url,$data,$token){ 
        $request_header = [
            'Content-Type: application/x-www-form-urlencoded',
            sprintf('DOBODY6969: %s', $token)
        ];

        $ch = curl_init();

        
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_header);
 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec ($ch);

        curl_close ($ch); 
        return json_decode($response,1);
    }
    public function LoginWebUser($email, $password, $remember) {
        global $_B;
        if ($email == '') {
            $return['status'] = false;
            $return['error']  = lang('no_email');

            return $return;
        }
        // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //     $return['status'] = false;
        //     $return['error']  = lang('invalid_email');

        //     return $return;
        // }
        if ($password == '') {
            $return['status'] = false;
            $return['error']  = lang('no_pass');

            return $return;
        }

        $d['userName'] = $email;
        $d['password'] = $password;
        $rt = $this->PostAnvui('https://dobody-anvui.appspot.com/user/rlogin',$d);

//       var_dump($rt);exit();
        if($rt['code'] == 200 ){
            $return['status'] = true;

             // echo '<pre>';
        // var_dump($rt['results']['token']['tokenKey']); die;
//         var_dump($rt['results']['userInfo']['userStatus']); die;
            $webM = new Model('web');
            $webM->where('userId',$rt['results']['userInfo']['userId']);
            $webM->update(array('tokenKey'=>$rt['results']['token']['tokenKey'], 'userStatus'=>$rt['results']['userInfo']['userStatus']));



            $this->CookieWebUser($rt['results']['userInfo']);
        } else {
            $return['status'] = false;
//            $return['error']  = lang('no_email_wrong_pass');
            switch ($rt['results']['error']['propertyName']) {
                case 'USER_NOT_VERIFY_PHONE_INFO_YET':
                    $return['error'] = lang('Số điện thoại chưa được xác nhận. Hãy liên hệ số 19007034');
                    break;
                case 'USER_COMPANY_NOT_AVAILABLE':
                    $return['error'] = lang('Nhà vận tải chưa cam kết dịch vụ với ANVUI. Hãy liên hệ số 19007034');
                    break;
                default:
                    $return['error'] = lang('Tài khoản chưa được kích hoạt. Hãy liên hệ số 19007034');
                    break;
            }
        }


        // $password = md5('BNCID@' . $password . '@QCVN');

        // $password = md5($password . '|quangchauvn');

        // $userObj = new Model('user', false);
        // $userObj->where('idw', $this->idw);
        // $userObj->where('email', $email);
        // $userObj->where('password', $password);
        // if ($userObj->num_rows() > 0) {
            // $return['status'] = true;
            // $this->CookieWebUser($email, $remember);
        // } else {
            // $return['status'] = false;
            // $return['error']  = lang('no_email_wrong_pass');
        // }

        return $return;
    }
    /**
     * @param $email
     * @param $remember
     */
    private function CookieWebUser1($email, $remember) {

        $userObj = new Model('user', false);
        // $userObj->where('idw', $this->idw);
        $userObj->where('email', $email);
        $user = $userObj->getOne();

        if (isset($user['uid'])) {
            $this->setcookie($user, $remember);
        }

        return true;
    }
    private function CookieWebUser($userInfo) { 
            $this->setcookie($userInfo); 

        return true;
    }
    private function setcookie($u) {
        global $_B;
 
        $expire = time() + 8640000;
         
        $arr = str_split('ABCDEFGHIJKLMNOPXYZTKUV123456789');
        shuffle($arr);
        $arr    = array_slice($arr, 0, 10);
        $cookie = implode('', $arr);
        $cookie = md5($cookie . '|quangchauvn|' . $this->idw . $u['email']);

        $login_data = array(
            'idw'      => $this->idw,
            'uid'      => 1, 
            'userId'      => $u['userId'], 
            'username' => $u['userName'],
            'time'     => time(),
            'expire'   => $expire,
            'cookie'   => $cookie,
            'ip'       => $_B['ip'],
        );
        $userlogin = new Model('web_user_login', false);

        $cookieId = $userlogin->insert($login_data);
        //set cookie
        if ($cookieId) {
            setcookie($this->name_cookie, $cookie, $expire, '/');

            return true;
        } else {
            setcookie($this->name_cookie, '', time() - 86400 * 36, '/');

            return false;
        }
    }
    /**
     * @param $u
     * @param $remember
     */
    private function setcookie1($u, $remember) {
        global $_B;

        if ($remember == 1) {
            $expire = time() + 8640000;
        } else {
            $expire = 0;
        }

        $arr = str_split('ABCDEFGHIJKLMNOPXYZTKUV123456789');
        shuffle($arr);
        $arr    = array_slice($arr, 0, 10);
        $cookie = implode('', $arr);
        $cookie = md5($cookie . '|quangchauvn|' . $this->idw . $u['email']);

        $login_data = array(
            'idw'      => $this->idw,
            'uid'      => $u['uid'],
            'email'    => $u['email'],
            'username' => $u['username'],
            'time'     => time(),
            'expire'   => $expire,
            'cookie'   => $cookie,
            'ip'       => $_B['ip'],
        );
        $userlogin = new Model('web_user_login', false);

        $cookieId = $userlogin->insert($login_data);
        //set cookie
        if ($cookieId) {
            setcookie($this->name_cookie, $cookie, $expire, '/');

            return true;
        } else {
            setcookie($this->name_cookie, '', time() - 86400 * 36, '/');

            return false;
        }
    }
    public function giahan2Day() {
        global $_B;
        $mWeb = new Model('web', false);
        $mWeb->where('idw', $this->idw);
        $result = $mWeb->getOne(null, 'end_date,giahan');
        if ($result['end_date'] < time() && $result['end_date'] > 0 && $result['giahan'] < 1) {
            $end_date = time() + 2 * 86400;
            $mWeb->where('idw', $this->idw);
            $up = $mWeb->update(array('giahan' => 1, 'end_date' => $end_date));

            return true;
        }

        return false;
    }
    public function checkLogin() {
        global $_B;

        if (!isset($_COOKIE[$this->name_cookie])) {
            return false;
        }

        $cookie    = $_COOKIE[$this->name_cookie];
        $userlogin = new Model('web_user_login', false);
        $userlogin->where('idw', $this->idw);
        $userlogin->where('cookie', $cookie);

        if ($userlogin->num_rows() > 0) {
            $userlogin->where('cookie', $cookie);
            $datalogin = $userlogin->getOne();

           

            $_B['uweb']['uid']      = $datalogin['uid']; 
            $_B['uweb']['userId']      = $datalogin['userId']; 
            $_B['uweb']['username'] = $datalogin['username'];
            $_B['uweb']['avatar']   = 'http://id.webbnc.vn/data/img/avatar_default.jpg';
            $_B['cookie']           = $cookie;
        } else {
            return false;
        }

    }
    /**
     * @param $a
     * @param $k
     * @param $v
     * @return mixed
     */
    private function add_perm_to_op($a, $k, $v) {
        if (!array_key_exists($k, $a)) {
            $a[$k] = $v;
        } else {
            $v1 = $a[$k];
            foreach ($v1 as $key => $value) {
                $v2[$key] = $value || $v[$key];
            }
            $a[$k] = $v2;
        }

        if (
            $a[$k]['perm_add']
            && $a[$k]['perm_del']
            && $a[$k]['perm_edit']
            && $a[$k]['perm_view']
            && $a[$k]['perm_public']
        ) {
            $a[$k]['perm_full'] = true;
        }

        return $a;
    }

    /**
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-10-06
     * @param  [type]                     $params [description]
     * @return [type]                             [description]
     */
    private function extApp($params = null) {
        $obj = new Model('app');
        $obj->where('idw', $this->idw);
        $obj->where('status', 1);
        $res = $obj->get();
        if (count($res) != 0) {
            foreach ($res as $k => $v) {
                $tmp_title      = 'app_name_' . $v['id'];
                $_L[$tmp_title] = $v['app_name'];
                $v['name']      = $v['app_name'];
                $v['title']     = $tmp_title;
                $v['link']      = '/application-setting-index-' . $v['id'] . '-lang-vi';
                $v['icon']      = 'fa fa-cog';
                unset($v['app_name']);
                unset($v['id']);
                unset($v['idw']);
                unset($v['app_id']);
                unset($v['app_url_admin']);
                unset($v['app_url_frontend']);
                unset($v['app_secret']);
                unset($v['status']);
                $res[$k] = $v;
            }

            return $res;
        } else {
            return false;
        }
    }

    public function config_apps() {
        global $_B;
        $obj = new Model('apps_active');
        $obj->where('idw', $this->idw);
        $data = $obj->getOne();

        if (empty($data)) {
            return false;
        } else {
            $data = json_decode($data['content'], true);
            //Đưa vào mảng
            $arrs_feature_active = array();
            foreach ($data as $k => $v) {
                if ($v['active'] != 0 && $v['end_date'] >= time()) {
                    $arrs_feature_active[] = $k;
                }
            }
            foreach ($_B['config_apps'] as $k => $v) {
                foreach ($v['feature'] as $k_f => $v_f) {
                    if (in_array($k_f, $arrs_feature_active)) {
                        $v['feature'][$k_f]['status'] = 2;
                    }
                }
                $_B['config_apps'][$k] = $v;
            }
        }

    }
}

?>