<?php
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}
class ContactView {
    public $idw, $r, $lang, $result_id, $contactview;
    public function __construct() {
        global $_B;
        $this->r         = $_B['r'];
        $this->idw       = $_B['web']['idw'];
        $this->lang      = $_B['cf']['lang'];
        $this->result_id = "";
    }
    public function getContact($value = null) {
        $lang          = $this->r->get_string('lang', 'GET');
        $contactview   = new Model($lang . '_contact');
        $str_customers = trim($this->replate_string($value['search_customers']));
        $str_email     = trim($this->replate_string($value['search_email']));
        if ($value['action'] == 'searchContact') {
            if ($value['create_time'] != '') {
                //xu ly datetime
                $datetime  = explode('-', $value['create_time']);
                $datetime1 = mktime(0, 0, 0, (int) $datetime[1], (int) $datetime[0], (int) $datetime[2]);
                $datetime2 = mktime(0, 0, 0, (int) $datetime[1], (int) $datetime[0] + 1, (int) $datetime[2]);

                $contactview->where('create_time', $datetime1, '>');
                $contactview->where('create_time', $datetime2, '<');
            }
            if (!empty($value['search_customers'])) {
                $contactview->where('customers', '%' . $str_customers . '%', 'like');
            }
            if (!empty($value['search_phone'])) {
                $contactview->where('phone', '%' . ($value['search_phone']) . '%', 'like');
            }
            if (!empty($value['search_email'])) {
                $contactview->where('email', '%' . $str_email . '%', 'like');
            }
            if (($value['status_news'] != '') and ($value['status_news'] != 'all')) {
                $contactview->where('status', $value['status_news']);
            }
        }

        $contactview->where('idw', $this->idw);
        $total = $contactview->num_rows();

        $max    = 20;
        $maxNum = 5;
        if ($value['action'] == 'searchContact') {
            $url = 'contact-contactview-lang-' . $lang . '-value-' . $_GET['value'];
        } else {
            $url = 'contact-contactview-lang-' . $lang;
        }
        $page       = pagination($max, $total, $maxNum, $url);
        $start      = $page['start'];
        $pagination = $page['pagination'];
        $select     = '*';

        $contactview->where('idw', $this->idw);
        //check tim kiem
        if ($value['action'] == 'searchContact') {
            if ($value['create_time'] != '') {
                //xu ly datetime
                $datetime  = explode('-', $value['create_time']);
                $datetime1 = mktime(0, 0, 0, (int) $datetime[1], (int) $datetime[0], (int) $datetime[2]);
                $datetime2 = mktime(0, 0, 0, (int) $datetime[1], (int) $datetime[0] + 1, (int) $datetime[2]);

                $contactview->where('create_time', $datetime1, '>');
                $contactview->where('create_time', $datetime2, '<');
            }
            if (!empty($value['search_customers'])) {
                $contactview->where('customers', '%' . $str_customers . '%', 'like');
            }
            if (!empty($value['search_phone'])) {
                $contactview->where('phone', '%' . ($value['search_phone']) . '%', 'like');
            }
            if (!empty($value['search_email'])) {
                $contactview->where('email', '%' . $str_email . '%', 'like');
            }
            if (($value['status_news'] != '') and ($value['status_news'] != 'all')) {
                $contactview->where('status', $value['status_news']);
            }
        }

        //edn tim kiem
        $contactview->orderBy('id', 'DESC');
        $result['data'] = $contactview->get(null, array($start, $max), $select);
        foreach ($result['data'] as $key => $value) {
            $result['data'][$key]['content_base64']        = base64_encode($value['content']);
            $result['data'][$key]['content_answer_base64'] = base64_encode($value['content_answer']);
            $result['data'][$key]['create_time']           = date('H:i:s A - d/m/Y', $result['data'][$key]['create_time']);
            $result['data'][$key]['update_time']           = date('H:i:s A - d/m/Y', $result['data'][$key]['update_time']);
        }
        if ($total > 20) {
            $result['pagination'] = $pagination;
        }
        return $result;

    }

    public function activeStatusContact() {
        global $_B;
        $lang        = $this->r->get_string('lang', 'GET');
        $id          = $this->r->get_int('key', 'POST');
        $status      = $this->r->get_string('status', 'POST');
        $contactview = new Model($lang . '_contact');
        $update      = array('status' => $status);
        $contactview->where('id', $id);
        $contactview->where('idw', $this->idw);
        $result = $contactview->update($update);
    }
    public function deleteContact($id = null) {
        $lang = $this->r->get_string('lang', 'GET');
        $id   = $this->r->get_int('key', 'POST');
        if (!is_numeric($id) or $id == 0) {
            $data['status'] = false;
            return json_encode($data);
        }

        $contactview = new Model($lang . '_contact');
        $contactview->where('id', $id);
        $contactview->where('idw', $this->idw);
        $contactview->delete();

        $data['status'] = true;
        return json_encode($data);
    }
    public function deleteMultiID() {
        $lang = $this->r->get_string('lang', 'GET');
        $ids  = $this->r->get_array('name_id', 'POST');
        foreach ($ids as $k => $v) {
            $contactview = new Model($lang . '_contact');
            $contactview->where('id', $v);
            $contactview->where('idw', $this->idw);
            $contactview->delete();
        }
        $r['status'] = true;
        return $r;

    }

    public function sendmailsmtp() { 
        return false;
    }
    public function replate_string($str) {
        if (strpos($str, "'") !== false) {
            $str = str_replace("'", "&#039;", $str);
        } elseif (strpos($str, '"') !== false) {
            $str = str_replace('"', "&quot;", $str);
        } elseif (strpos($str, "<") !== false) {
            $str = str_replace("<", "&lt;", $str);
        } elseif (strpos($str, ">") !== false) {
            $str = str_replace(">", "&gt;", $str);
        }
        return $str;
    }
}