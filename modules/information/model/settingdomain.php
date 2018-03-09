<?php

if (!defined('BNC_CODE')) {
    exit('Access Denied');
}

class SettingDomain {
    public $idw, $r, $infolist, $web;
    private $uid;
    private $model;
    public function __construct() {
        global $_B;
        $this->r      = $_B['r'];
        $this->domain = $_B['web']['domain'];
        $this->idw    = $_B['web']['idw'];
        $this->uid    = $_B['uid'];
        $db_web       = db_connect();
        $this->model  = new Model('web', $db_web);

    }

/* If your visitor comes from proxy server you have use another function
to get a real IP address: */
    public function getRealIPAddress() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function info() {

        $list_ip = array(
            '203.162.120.70',
        );
        //$this->model->where('idw',$this->idw);
        //$list_domain_exist=$this->model->getOne(null,'domain');
        $list_domain_exist = explode(',', $this->domain);

        foreach ($list_domain_exist as $k => $v) {
            if (!empty($v)) {
                $result[] = array(
                    'ip'     => $this->getDNSbyDomainFix($v),
                    'domain' => $v,
                    'no_dot' => str_replace('.', '', $v),
                );
                $domainlist[] = $v;
            }
        }
        if (isset($domainlist)) {
            $data['domainlist'] = implode(',', $domainlist);
        } else {
            $data['domainlist'] = false;
        }

        $data['list_domain_exist'] = $result;
        $data['list_ip']           = (isset($list_ip) ? $list_ip : null);
        return $data;
    }

    /**
     * [getDNSbyDomain  lấy thông tin các bản ghi dns theo domain]
     * @return [array] [trả ra mảng dữ dns của một domain]
     */
    public function getDNSbyDomain($domain) {

        $ch  = curl_init();
        $url = "http://dns-orig.webbnc.vn/get_domain_json.php?domain=" . $domain;
        $ch  = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "dns_get_json:bananhhuong");
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $output = curl_exec($ch);

        if ($output == true) {
            $output = json_decode($output);
            $code   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($output->status == true) {
                if (empty($output->data)) {
                    return false;
                }
                foreach ($output->data as $v) {
                    if ($v->type == 'A') {
                        return $v->content;
                    }

                }
            }

        } else {
            return false;
        }

    }
    /**
     * [getDNSbyDomainFix description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-05-25
     * @param  [type]                     $domain [description]
     * @return [type]                             [description]
     */
    public function getDNSbyDomainFix($domain) {

        $ch  = curl_init();
        $url = "http://dns-orig.webbnc.vn/get_domain_json.php?domain=" . $domain;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "dns_get_json:bananhhuong");
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $output = curl_exec($ch);

        if ($output == true) {
            $result = array();
            $output = json_decode($output);
            $code   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($output->status == true) {
                if (empty($output->data)) {
                    return false;
                }
                foreach ($output->data as $v) {
                    if ($v->name === trim($domain) && $v->type == 'A') {
                        return $v->content;
                    }
                }
            }
            return $result;
        } else {
            return false;
        }

    }

    public function addDomain($domain) {
        $this->model->where('idw', $this->idw);
        $getData   = $this->model->getOne(null, 'domain');
        $oldDomain = explode(',', $getData['domain']);
        $newdomain = ',';
        foreach ($oldDomain as $k => $v) {
            if (!empty($v)) {
                $newdomain .= $v . ',';
            }
        }
        // $newdomain .= $domain . ',';
        $domain     = explode(',', $domain);
        $domain_add = '';
        foreach ($domain as $k => $v) {
            if ($v != '') {
                $domain_add .= $v . ',';
            }
        }
        $newdomain .= $domain_add;
        $data = array(
            'domain' => $newdomain,
        );
        $this->model->where('idw', $this->idw);
        return $this->model->update($data);
    }

    public function removeDomain($domain) {
        $this->model->where('idw', $this->idw);
        $getData = $this->model->getOne(null, 'domain');
        //Update tro lai
        $getData['domain'] = explode(',', $getData['domain']);
        $newdomain         = ',';
        foreach ($getData['domain'] as $k => $v) {
            if (!empty($v) && $v != $domain) {
                $newdomain .= $v . ',';
            }
        }
        $data = array(
            'domain' => $newdomain,
        );
        $this->model->where('idw', $this->idw);
        return $this->model->update($data);
    }

    public function getFeed($domain_df) {
        $domain = parse_url($domain_df);
        if (isset($domain['host'])) {
            $domain = str_replace('www.', '', $domain['host']);
        } else {
            $domain = $domain_df;
        }
        $content = file_get_contents('https://dns-api.org/NS/' . $domain);
        $content = json_decode($content, true);
        $check   = false;
        foreach ($content as $k => $v) {
            preg_match("/ns(1|2).webbnc.vn/", $v['value'], $matches);
            if (isset($matches[1])) {
                $check = true;
            }
        }
        return $check;
    }

    public function checkDomainExistWeb($domain) {
        $this->model->where('domain', '%,' . $domain . '%', 'LIKE');
        $getData = $this->model->getOne(null, 'domain');
        if ($getData == true) {
            //Da ton tai trong 1 web khac
            return true;
        } else {
            return false;
        }

    }

}