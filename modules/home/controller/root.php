<?php
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}
class Root extends \Bncv2\Core\Controller {

    public function __construct() {
        parent::__construct();
        $this->uid_allow = array(5785,301, 202, 1, 646, 1998, 3540, 157);
        //1998 - Thịnh - Sài gòn
        //646 Thu - Nhập liệu
        //577 Việt Bùi - chan
        //301 Trường
        //202 Dũng
        //1 Châu
        //3540 Hung
        //157 Doanh
        //5785 Phạm Đức Bình - CEO
        $this->allowResetPass = $this->allowDate = array(301, 1, 202, 3540);

        $user           = $this->determineUser($this->uid);
        $this->u_name   = $user['name'];
        $this->u_email  = $user['email'];
        $this->pathLogs = DIR_MODULES . 'home/logs/web.json';
        $this->cache    = new CacheBNC;
        // if ($this->uid==301 || $this->uid==3540) {

        // } else {
        //     $this->cacheKey = $this->uid . 'ROOT';
        //     if (!isset($_SESSION[$this->cacheKey]) || $_SESSION[$this->cacheKey] == false) {
        //             $check = $this->checkAccess();
        //     }
        // }

    }

    public function index() {
        global $_DATA, $_B;
        $_DATA['mod_theme'] = $_B['mod_theme'] . 'root/assets/';
        include $this->temp->load('/root/index');
        exit();
    }
    /**
     * @param $value
     */
    public function unload($value = '') {
        $_SESSION[$this->cacheKey] = false;
        $this->cache->del($this->cacheKey);
    }
    public function ajaxViewInfo() {
        global $_DATA, $_B;
        $web = $this->request->get_string('web', 'POST');
        $ws  = $this->determineWeb($web);
        if ($ws == false) {
            $res = array(
                'status' => false,
            );
        } else {
            $ws['start_date'] = date('d/m/Y', $ws['start_date']);
            $ws['end_date']   = date('d/m/Y', $ws['end_date']);
            $domain           = explode(',', $ws['domain']);
            $tmp_domain       = '';
            if (!empty($domain)) {
                foreach (array_filter(array_values($domain)) as $v) {
                    $tmp_domain .= $v . '</br>';
                }
            }
            $ws['domain'] = $tmp_domain;
            $res          = array(
                'status' => true,
                'data'   => $ws,
            );
        }
        echo json_encode($res);
        die();
    }

    public function ajaxResetPassword() {
        global $_DATA, $_B;
        if (in_array($_B['uid'], $this->allowResetPass) == false) {
            $res = array(
                'status'  => false,
                'message' => 'Không có quyền truy cập',
            );
            echo json_encode($res);
            exit();
        }
        $web  = $this->request->get_string('web', 'POST');
        $pass = $this->request->get_string('passw', 'POST');
        $ws   = $this->determineWeb($web);
        //Reset
        $url  = 'http://id.webbnc.vn/api/changePass/';
        $pvar = array(
            'email'        => $ws['email_user'],
            'new_password' => $pass,
        );
        $post = $this->postPage($url, $pvar, 'bncvn.vn', 30);
        echo $post;
        die();
    }

    /**
     * @param $url
     * @param $pvars
     * @param $referer
     * @param $timeout
     * @return mixed
     */
    private function postPage($url, $pvars, $referer, $timeout) {
        if (!isset($timeout)) {
            $timeout = 30;
        }

        $curl = curl_init();
        $post = http_build_query($pvars);
        if (isset($referer)) {
            curl_setopt($curl, CURLOPT_REFERER, $referer);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($curl, CURLOPT_USERPWD, "idbnc:tadicauca");
        curl_setopt($curl, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0", rand(4, 5)));
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/x-www-form-urlencoded"));
        $html = curl_exec($curl);
        curl_close($curl);

        return $html;
    }

    public function ajaxCopyTheme() {
        $src = $this->request->get_int('src', 'POST');
        $des = $this->request->get_int('des', 'POST');

        $theme_src = DIR_THEME_FRONTEND . $src . '/';
        $theme_des = DIR_THEME_FRONTEND . $des . '/';
        // $theme_src = DIR_THEME_FRONTEND . '1/';
        // $theme_des = DIR_THEME_FRONTEND . 'truongnx/';
        //Kiem tra ton tai khong
        if (file_exists($theme_src) == true) {
            $ou  = shell_exec("rm -rf $theme_des; cp -r -v $theme_src $theme_des; chmod -R 775 $theme_des; chown -R apache:apache $theme_des;");
            $res = array(
                'status' => true,
                'data'   => $ou,
            );
        } else {
            $res = array(
                'status' => false,
                'data'   => 'Không tồn tại giao diện nguồn',
            );
        }

        echo json_encode($res);
        die();
    }
    public function ajax() {
        global $_DATA, $_B;
        $type         = $this->request->get_string('type', 'POST');
        $web          = $this->request->get_string('web', 'POST');
        $ws           = $this->determineWeb($web);
        $idw          = $ws['idw'];
        $theme_id_old = $ws['theme_id'];
        if ($idw != false) {
            switch ($type) {
            case 'date':

                if (in_array($_B['uid'], $this->allowDate) == false) {
                    echo 'Không có quyền truy cập';
                    exit();
                }
                $start_date   = $this->request->get_string('start_date', 'POST');
                $end_date     = $this->request->get_string('end_date', 'POST');
                $end_date_str = $end_date;
                if ($start_date != '') {
                    $start_date         = strtotime(str_replace('/', '-', $start_date));
                    $data['start_date'] = $start_date;
                }
                $end_date = strtotime(str_replace('/', '-', $end_date));
                //Kiểm tra thời gian ra hạn, nếu trên 3 tháng -> web đang được sử dụng , nếu dưới 3 tháng, web đang triển khai
                //3 tháng
                $month3 = $end_date - time();
                if ($month3 > 7776000) {
                    $data['using'] = 1;
                }
                $data['end_date'] = $end_date;
                $res              = $this->update($data, $idw);
                if ($res == true) {
                    //Save log
                    $mes  = 'Lúc ' . date('d/m/Y H:s:i') . ' ' . $this->u_name . ' gia hạn web ' . $idw;
                    $more = 'Lúc ' . date('d/m/Y H:s:i') . ', <br>IP: ' . $_SERVER['REMOTE_ADDR'] . ' <br>Trình duyệt:' . $_SERVER['HTTP_USER_AGENT'] . '<br>' . $this->u_name . ' gia hạn web ' . $idw . ' tới ngày ' . $end_date_str;
                    $this->saveLog($idw, $mes, $more, 'date');
                }
                break;
            case 'theme':
                $theme_id         = $this->request->get_int('theme_id', 'POST');
                $data['theme_id'] = $theme_id;
                $res              = $this->update($data, $idw);
                if ($res == true) {
                    //Save log
                    $mes  = 'Lúc ' . date('d/m/Y H:s:i') . ' ' . $this->u_name . ' đổi theme web ' . $idw;
                    $more = 'Lúc ' . date('d/m/Y H:s:i') . ', <br>IP: ' . $_SERVER['REMOTE_ADDR'] . ' <br>Trình duyệt:' . $_SERVER['HTTP_USER_AGENT'] . '<br>' . $this->u_name . ' đổi theme web ' . $idw . '.Theme cũ ' . $theme_id_old . ' tới id theme ' . $theme_id;
                    $this->saveLog($idw, $mes, $more, 'theme');
                }
                break;
            }
            if ($res == false) {
                $result = array(
                    'status'  => false,
                    'message' => 'Có lỗi xảy ra. Vui lòng liên hệ với quản trị',
                );
            } else {
                $result = array(
                    'status'   => true,
                    'message'  => 'Thao tác thành công',
                    'log_mes'  => $mes,
                    'log_more' => $more,
                );
            }
        } else {
            $result = array(
                'status'  => false,
                'message' => 'Không tồn tại website này',
            );
        }
        echo json_encode($result);
        exit();
    }

    /**
     * @param $web
     * @return mixed
     */
    private function determineWeb($web) {
        $find          = array('https://', 'http://', '/');
        $replace       = array('', '', '');
        $web           = trim(str_replace($find, $replace, $web));
        $s_name_domain = array();
        preg_match("/([a-z0-9]+).bncvn.vn/i", $web, $matches);
        if (isset($matches[1]) == true) {
            $s_name_domain = array(
                'type' => 's_name',
                'val'  => $matches[1],
            );

        } else {
            $s_name_domain = array(
                'type' => 'domain',
                'val'  => $web,
            );
        }

        return $this->checkWeb($s_name_domain);
    }

    /**
     * [checkWeb description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-10-21
     * @param  [type]                     $web [description]
     * @return [type]                          [description]
     */
    private function checkWeb($web) {
        $db  = db_connect('user');
        $obj = new Model('web', $db);
        if ($web['type'] == 's_name') {
            $data = $obj->where('s_name', $web['val'])->getOne();
        } else {
            $data = $obj->where('domain', '%,' . $web['val'] . ',%', 'LIKE')->getOne();
        }

        if (isset($data['idw'])) {
            return $data;
        } else {
            return false;
        }

    }

    /**
     * @param $data
     * @param $idw
     * @return mixed
     */
    private function update($data, $idw) {
        $db  = db_connect('user');
        $obj = new Model('web', $db);
        $res = $obj->where('idw', $idw)->update($data);

        return $res;
    }

    /**
     * @param $uid
     * @return mixed
     */
    private function determineUser($uid) {
        if (in_array($uid, $this->uid_allow)) {
            if ($uid == 301) {
                $res = array(
                    'name'  => 'Trường NX',
                    'email' => 'truongnx@webbnc.vn',
                );
            } elseif ($uid == 202) {
                $res = array(
                    'name'  => 'Dũng HD',
                    'email' => 'dungdaohd@gmail.com',
                );
            } elseif ($uid == 1) {
                $res = array(
                    'name'  => 'Châu QC',
                    'email' => 'quangchauvn@gmail.com',
                );
            } elseif ($uid == 646) {
                $res = array(
                    'name'  => 'Ngọc Thu',
                    'email' => 'thucntt4890@gmail.com',
                );
            } elseif ($uid == 1998) {
                $res = array(
                    'name'  => 'Thịnh SG',
                    'email' => 'kaita0911@gmail.com',
                );
            } elseif ($uid == 3540) {
                $res = array(
                    'name'  => 'Hung HM',
                    'email' => 'hungdct1083@gmail.com',
                );
            } elseif ($uid == 157) {
                $res = array(
                    'name'  => 'Doanh LD',
                    'email' => 'doanhle94@gmail.com',
                );
            }

            return $res;
        } else {
            die('Vui lòng quay trở lại');
        }
    }

    /**
     * @param $idw
     * @param $mes
     * @param $more
     * @param $type
     */
    private function saveLog($idw, $mes, $more, $type) {
        // $content   = file_get_contents($this->pathLogs);
        // $content   = json_decode($content, true);
        // if(empty($content)){
        //     $content=array();
        // }
        $content = array(
            'idw'  => $idw,
            'type' => $type,
            'mes'  => $mes,
            'more' => $more,
        );

        $db  = db_connect('notify');
        $obj = new Model('root_logs', $db);
        $obj->insert($content);
        // $saveContent = json_encode($content);
        // $myfile      = fopen($this->pathLogs, "w") || die("Unable to open file!");
        // fwrite($myfile, $saveContent);
        // fclose($myfile);

        return true;
    }

    public function ajaxLoadLogs() {
        $web     = $this->request->get_string('web', 'POST');
        $type    = $this->request->get_string('type', 'POST');

        // $content = file_get_contents($this->pathLogs);
        // $content = json_decode($content, true);
        $out = array();
        if (empty($web)) {
            $db  = db_connect('notify');
            $obj = new Model('root_logs', $db);
            $obj->orderBy('id','DESC');
            $content=$obj->get(null,array(0,10));
            foreach ($content as $k => $v) {
                if ($k <= 10) {
                    $out[] = $v;
                } else {
                    break;
                }
            }
            echo json_encode($out);
            exit();
        } else {
            $idw = $this->determineWeb($web);
            $idw = $idw['idw'];
            if ($idw != false) {
                $db  = db_connect('notify');
            $obj = new Model('root_logs', $db);
            $obj->where('idw',$idw);
            $obj->where('type',$type);
            $obj->orderBy('id','DESC');
            $content=$obj->get(null,array(0,10));
                foreach ($content as $k => $v) {
                    $out[] = $v;
                    // if ($v['idw'] == $idw && $v['type'] == $type) {
                        
                    // }
                }
                if (count($out) == 0) {
                    $result = array(
                        'status'  => true,
                        'message' => 'Không có dữ liệu liên quan',
                    );
                } else {
                    $result = array(
                        'status' => true,
                        'logs'   => $out,
                    );
                }
            } else {
                $result = array(
                    'status'  => false,
                    'message' => 'Không tồn tại website này',
                );
            }
            echo json_encode($result);
            exit();
        }
    }
    public function checkAccess() {
       return false;
    }
    private function sendMailAccessCode() {
        return false;
    }

    public function setApp() {
        //$da        = $this->get_setting_show();
        $idw              = $this->request->get_string('idw', 'POST');
        $nxt_feature      = $this->request->get_array('nxt_feature', 'POST');
        $nxt_feature_name = $this->request->get_array('nxt_feature_name', 'POST');
        $nxt_feature_date = $this->request->get_array('nxt_feature_date', 'POST');
        $arrs             = array();
        foreach ($nxt_feature_name as $k => $v) {
            if ($nxt_feature[$k] == 'false') {
                $arrs[$v]['active'] = 0;
            } else {
                $arrs[$v]['active'] = 2;
            }

            $end_date               = strtotime(str_replace('/', '-', $nxt_feature_date[$k]));
            $arrs[$v]['end_date']   = $end_date;
            $arrs[$v]['start_date'] = time();
        }
        $db  = db_connect('notify');
        $obj = new Model('apps_active', $db);
        $obj->where('idw', $idw);
        $count = $obj->num_rows();
        if ($count) {
            $update = array(
                'content' => json_encode($arrs),
            );
            $obj->where('idw', $idw);
            $dt = $obj->update($update);
        } else {
            $insert = array(
                'idw'     => $idw,
                'content' => json_encode($arrs),
            );

            $dt = $obj->insert($insert);
        }
        $res = array(
            'status' => true,
        );
        echo json_encode($res);
        die();
        // $setting   = $this->get_setting($idw);
        // $apps_deal = array(
        //     'status'     => $this->request->get_int('hot_deal', 'POST'),
        //     'start_date' => $this->request->get_string('start_deal', 'POST'),
        //     'end_date'   => $this->request->get_string('end_deal', 'POST'),

        // );
        // $apps_quantity = array(
        //     'status'     => $this->request->get_int('price_quantity', 'POST'),
        //     'start_date' => $this->request->get_string('start_quantity', 'POST'),
        //     'end_date'   => $this->request->get_string('end_quantity', 'POST'),

        // );
        // $apps_properties = array(
        //     'status'     => $this->request->get_int('price_properties', 'POST'),
        //     'start_date' => $this->request->get_string('start_properties', 'POST'),
        //     'end_date'   => $this->request->get_string('end_properties', 'POST'),

        // );
        // $apps_big = array(
        //     'status'     => $this->request->get_int('price_big_quantity', 'POST'),
        //     'start_date' => $this->request->get_string('start_big', 'POST'),
        //     'end_date'   => $this->request->get_string('end_big', 'POST'),

        // );
        // $apps_auction = array(
        //     'status'     => $this->request->get_int('auction', 'POST'),
        //     'start_date' => $this->request->get_string('start_auction', 'POST'),
        //     'end_date'   => $this->request->get_string('end_auction', 'POST'),

        // );
        // if (!empty($setting)) {
        //     $data = array(
        //         'apps_deal'       => json_encode($apps_deal),
        //         'apps_quantity'   => json_encode($apps_quantity),
        //         'apps_properties' => json_encode($apps_properties),
        //         'apps_big'        => json_encode($apps_big),
        //         'apps_auction'    => json_encode($apps_auction),
        //     );
        //     $result = $this->edit_setting_idw($data, $idw);
        // } else {
        //     $data = array(
        //         'apps_deal'       => json_encode($apps_deal),
        //         'apps_quantity'   => json_encode($apps_quantity),
        //         'apps_properties' => json_encode($apps_properties),
        //         'apps_big'        => json_encode($apps_big),
        //         'apps_auction'    => json_encode($apps_auction),
        //     );
        //     $result = $this->add_setting($data);
        // }

    }

    // setting

    /**
     * @param $data
     * @return mixed
     */
    public function setBcake(){
           $email              = $this->request->get_string('email', 'POST');

           $date_begin      = $this->request->get_string('date_begin', 'POST');
           $start_date               = strtotime(str_replace('/', '-', $date_begin));

           $date_end = $this->request->get_string('date_end', 'POST');
           $end_date               = strtotime(str_replace('/', '-', $date_end));
           if($end_date<$start_date){
                $result['status'] = false;
                echo json_encode($result);
                exit();
           }
           $payloadName = array(
                'email'     => $email,
                'start_date' => $start_date,
                'end_date' => $end_date,
            );
           $host ='https://bncapp.net/api/admin-active-bcake';
           $process = curl_init($host);
           
           // curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/xml', $additionalHeaders));
           $username = 'active@webbnc.vn';
           $password = 'active@123@bncvn';
           curl_setopt($process, CURLOPT_HEADER, 0);
           curl_setopt($process, CURLOPT_USERPWD, $username . ":" . $password);
           curl_setopt($process, CURLOPT_TIMEOUT, 30);
           curl_setopt($process, CURLOPT_POST, 1);
           curl_setopt($process, CURLOPT_POSTFIELDS, $payloadName);
           curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
           $return = curl_exec($process);
           curl_close($process);
           if ($return) {
               $result['status'] = true;
           }
           
           echo json_encode($result);
           exit();
           
    }
    public function getBcake(){
           $email              = $this->request->get_string('email', 'POST');

           $payloadName = array(
                'email'     => $email,
            );
           $host ='https://bncapp.net/api/admin-get-active-bcake';
           $process = curl_init($host);
           
           // curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/xml', $additionalHeaders));
           $username = 'active@webbnc.vn';
           $password = 'active@123@bncvn';
           curl_setopt($process, CURLOPT_HEADER, 0);
           curl_setopt($process, CURLOPT_USERPWD, $username . ":" . $password);
           curl_setopt($process, CURLOPT_TIMEOUT, 30);
           curl_setopt($process, CURLOPT_POST, 1);
           curl_setopt($process, CURLOPT_POSTFIELDS, $payloadName);
           curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
           $return = curl_exec($process);
           curl_close($process);
           if($return)
           { 
             $return = json_decode($return,true);
             $return['data']['start_date'] = date('d/m/Y', $return['data']['start_date']);
             $return['data']['end_date'] = date('d/m/Y', $return['data']['end_date']);
           }
           
           echo json_encode($return['data']);
           exit();
           
    }
    public function add_setting($data) {
        $db                  = db_connect('product');
        $this->model_setting = new Model('vi_setting', $db);

        // $this->model_setting = new Model('vi_setting');
        $lastid = $this->model_setting->insert($data);
        if ($lastid) {
            $result['status'] = true;
        } else {
            $result['status'] = false;
            $result['error']  = $this->model_setting->getLastError();
        }

        return $result;
    }

    /**
     * @param $data
     * @param $idw
     * @return mixed
     */
    public function edit_setting_idw($data, $idw) {
        $db                  = db_connect('product');
        $this->model_setting = new Model('vi_setting', $db);
        $this->model_setting->where('idw', $idw);
        if ($this->model_setting->update($data)) {
            $result['status'] = true;
        } else {
            $result['status'] = false;
            $result['error']  = $this->model_setting->getLastError();
        }

        return $result;
    }

    /**
     * @param $idw
     * @return mixed
     */
    public function get_setting($idw) {
        $db                  = db_connect('product');
        $this->model_setting = new Model('vi_setting', $db);
        $this->model_setting->where('idw', $idw);
        $data = $this->model_setting->getOne();
        if (!empty($data) && !empty($data['setting_product'])) {
            $data['setting_product'] = json_decode($data['setting_product'], true);
        }
        if (!empty($data) && !empty($data['setting_product_detail'])) {
            $data['setting_product_detail'] = json_decode($data['setting_product_detail'], true);
        }
        if (!empty($data) && !empty($data['setting_home_tab'])) {
            $data['setting_home_tab'] = json_decode($data['setting_home_tab'], true);
        }
        if (!empty($data) && !empty($data['setting_home_tab_category'])) {
            $data['setting_home_tab_category'] = json_decode($data['setting_home_tab_category'], true);
        }
        if (!empty($data) && !empty($data['exchange_rate'])) {
            $data['exchange_rate'] = json_decode($data['exchange_rate'], true);
        }
        if (!empty($data) && !empty($data['setting_search_block'])) {
            $data['setting_search_block'] = json_decode($data['setting_search_block'], true);
        }

        return $data;
    }
    /**
     * @return mixed
     */
    public function get_setting_show() {
        $db                  = db_connect('product');
        $this->model_setting = new Model('vi_setting', $db);
        $this->model_setting->where('idw', $this->idw);
        $data = $this->model_setting->getOne();

        if (!empty($data)) {
            $re = json_decode($data['setting_product_show'], true);
        }

        return $re;
    }
    public function editApp() {
        $idw = $this->request->get_string('idw', 'POST');
        $db  = db_connect('notify');
        $obj = new Model('apps_active');
        $obj->where('idw', $idw);
        $dt = $obj->getOne();
        if (empty($dt)) {
            $res = array(
                'status' => false,
            );
        } else {

            $dt = json_decode($dt['content'], true);
            foreach ($dt as &$v) {
                $v['end_date'] = date('d/m/Y', $v['end_date']);
            }
            $res = array(
                'status' => true,
                'data'   => $dt,
            );
        }
        echo json_encode($res);
        die();
        // $this->model_setting = new Model('vi_setting', $db);
        // $idw = $this->request->get_string('idw','POST');
        // $this->model_setting->where('idw', $idw);
        // $data = $this->model_setting->getOne();

        // if(!empty($data)){
        //     $apps_deal = json_decode($data['apps_deal'], true);
        //     $apps_quantity = json_decode($data['apps_quantity'], true);
        //     $apps_properties = json_decode($data['apps_properties'], true);
        //     $apps_big = json_decode($data['apps_big'], true);
        //     $apps_auction = json_decode($data['apps_auction'], true);
        // }
        // $re['stt_deal']= $apps_deal['status'];
        // $re['start_deal']= $apps_deal['start_date'];
        // $re['end_deal']= $apps_deal['end_date'];

        // $re['stt_quantity']= $apps_quantity['status'];
        // $re['start_quantity']= $apps_quantity['start_date'];
        // $re['end_quantity']= $apps_quantity['end_date'];

        // $re['stt_properties']= $apps_properties['status'];
        // $re['start_properties']= $apps_properties['start_date'];
        // $re['end_properties']= $apps_properties['end_date'];

        // $re['stt_big']= $apps_big['status'];
        // $re['start_big']= $apps_big['start_date'];
        // $re['end_big']= $apps_big['end_date'];

        // $re['stt_auction']= $apps_auction['status'];
        // $re['start_auction']= $apps_auction['start_date'];
        // $re['end_auction']= $apps_auction['end_date'];

        // $res          = array(
        //     'status'=> true,
        //      'data'   => $re,
        // );

        echo json_encode($res);
    }

}