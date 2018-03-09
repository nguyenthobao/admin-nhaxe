<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /includes/class/model.php
 * @author Quang Chau Tran (quangchauvn@gmail.com)
 * @Createdate 08/14/2014, 02:04 PM
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}
class Model {
    private $name, $db;
    private $mod, $page, $lang, $s_name, $uid, $permissions, $accessPermission;
    public function __construct($name = null, $ismod = true) {
        global $_B;
        if ($name == null) {
            $this->name = get_class($this);
        } else {
            $this->name = $name;
        }

        $this->db = $_B['db'];
        // if ($ismod) {
        $this->CopyTableLang();
        // }
        //Tat ca ngon ngu dang su dung
        $this->language_system = $this->getLanguagesSystem();

        //Kiem tra va khoi tao field neu chua ton tai
        $this->ExistAndCreateField();

        $this->permissions = new Permissions;

    }

    public function logsApi($name = null, $data = null) {
        global $_B;

        $dbs = $this->db_connect('dev2bnc_admin_logs');

        $table_logs = 'logapi';

        $dataInsert = array(
            'idw'         => $this->idw,
            'name'        => $name,
            'data'        => $data,
            'create_time' => date('d/m/Y H:i:s'),
        );
        $dbs->insert($table_logs, $dataInsert);
        //}
    }

    private function logs($action = null, $data = null) {
        global $_B;
        return false;
        //if(isset($_COOKIE['HUONGNB'])){
        $dbs           = $this->db_connect('dev2bnc_admin_logs');
        $this->mod     = (isset($_GET['mod'])) ? $_GET['mod'] : '';
        $this->page    = (isset($_GET['page'])) ? $_GET['page'] : '';
        $this->sub     = (isset($_GET['sub'])) ? $_GET['sub'] : '';
        $this->id_item = (isset($_GET['id'])) ? $_GET['id'] : '';
        $this->lang    = (isset($_GET['lang'])) ? $_GET['lang'] : $_B['lang_default'];
        $this->idw     = $this->getIdw($_GET['s_name']);
        //
        $table_logs = $this->idw . '_admin_logs';
        if (!$dbs->table_exist($table_logs)) {
            $dbs->rawQuery("CREATE TABLE `$table_logs` LIKE `admin_logs`");
        }
        $dataInsert = array(
            'idw'         => $this->idw,
            's_name'      => $_GET['s_name'],
            'uid'         => $_B['uid'],
            'full_name'   => $_B['full_name'],
            'email'       => $_B['email'],
            'mod'         => $this->mod,
            'page'        => $this->page,
            'sub'         => $this->sub,
            'id_item'     => $this->id_item,
            'perm'        => $_B['user_perm'],
            'action'      => $action,
            'action_url'  => $_B['url_cur'],
            'create_time' => time(),
            'ip'          => $_B['ip'],
            'agent'       => $_SERVER['HTTP_USER_AGENT'],
            'brower'      => json_encode(get_browser($_SERVER['HTTP_USER_AGENT'])),
            'data_post'   => (!empty($data)) ? json_encode($data) : null,
        );
        $dbs->insert($table_logs, $dataInsert);
        //}
    }

    /**
     * [getLanguagesSystem description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-12
     * @return [type]                     [description]
     */
    public function getLanguagesSystem() {
        global $_NOB;

        $db = new MysqliDb($_NOB['db_host'], $_NOB['db_user'], $_NOB['db_password'], $_NOB['db_name'], $_NOB['db_charset'], $_NOB['db_port']);
        return $db->rawQuery("SELECT code FROM db_anvui.language");
    }

    private function cacheUpdate($data = null) {
        global $mod, $_B;
        $cache = new CacheBNCadmin($_B['web']['s_name'], $_B['web']['idw'], $mod, $this->name, $data);
        $cache->update();
    }
    public function rawQuery($data) {
        return $this->db->rawQuery($data);
    }
    public function getLastQuery() {
        return $this->db->getLastQuery();
    }
    /*
     *@data  array
     */
    public function insert($data) {
        $this->permissions->accessPermission('insert');
        $this->logs(2, $data);
        $this->cacheUpdate($data);
        $this->buildFileCache();
        return $this->db->insert($this->name, $data);
    }
    /*
     *@data  array
     */
    public function update($data) {
        $this->permissions->accessPermission('update');
        $this->logs(3, $data);
        $this->cacheUpdate($data);
        $this->buildFileCache();
        return $this->db->update($this->name, $data);
    }
    /*
     */
    public function delete() {
        $this->permissions->accessPermission('delete');
        $this->logs(4);
        $this->cacheUpdate();
        $this->buildFileCache();
        return $this->db->delete($this->name);
    }
    /*
     *@columns array(string) so truong can lay
     *@numRows int (0,limit), array (v0,v1)
     */
    public function get($as = null, $numRows = null, $columns = '*') {
        $this->permissions->accessPermission('get');
        if ($as == null) {
            return $this->db->get($this->name, $numRows, $columns);
        } else {
            return $this->db->get($this->name . " " . $as, $numRows, $columns);
        }

    }
    /**
     * A convenient SELECT * function to get one record.
     *
     * @param string  $tableName The name of the database table to work with.
     *
     * @return array Contains the returned rows from the select query.
     */
    public function getOne($as = null, $columns = '*') {
        $this->permissions->accessPermission('getOne');
        if ($as == null) {
            return $this->db->getOne($this->name, $columns);
        } else {
            return $this->db->getOne($this->name . " " . $as, $columns);
        }

    }
    /**
     * This methods returns the ID of the last inserted item
     * author: Huong Nguyen Ba (nguyenbahuong156@gmail.com)
     * create time 19/08/2014 01:44 AM
     * @return integer The last inserted item ID.
     */
    public function getLastId() {
        return $this->db->getInsertId();
    }
    /**
     * This method allows you to specify multiple (method chaining optional) AND WHERE statements for SQL queries.
     *
     * @uses $MySqliDb->where('id', 7)->where('title', 'MyTitle');
     *
     * @param string $whereProp  The name of the database field.
     * @param mixed  $whereValue The value of the database field.
     *
     * @return MysqliDb
     */
    public function where($whereProp, $whereValue = null, $operator = null) {
        $this->db->where($whereProp, $whereValue, $operator);
        return $this;
    }
    /**
     * This method allows you to specify multiple (method chaining optional) OR WHERE statements for SQL queries.
     *
     * @uses $MySqliDb->orWhere('id', 7)->orWhere('title', 'MyTitle');
     *
     * @param string $whereProp  The name of the database field.
     * @param mixed  $whereValue The value of the database field.
     *
     * @return MysqliDb
     */
    public function orWhere($whereProp, $whereValue = null, $operator = null) {
        $this->db->orWhere($whereProp, $whereValue, $operator);
        return $this;
    }
    /**
     * This method allows you to specify multiple (method chaining optional) ORDER BY statements for SQL queries.
     *
     * @uses $MySqliDb->orderBy('id', 'desc')->orderBy('name', 'desc');
     *
     * @param string $orderByField The name of the database field.
     * @param string $orderByDirection Order direction.
     *
     * @return MysqliDb
     */
    public function orderBy($orderByField, $orderbyDirection = "DESC") {
        $this->db->orderBy($orderByField, $orderbyDirection);
        return $this;
    }
    /**
     * This method allows you to specify multiple (method chaining optional) GROUP BY statements for SQL queries.
     *
     * @uses $MySqliDb->groupBy('name');
     *
     * @param string $groupByField The name of the database field.
     *
     * @return MysqliDb
     */
    public function groupBy($groupByField) {
        $this->db->groupBy($groupByField);
        return $this;
    }
    /**
     * This method allows you to concatenate joins for the final SQL statement.
     *
     * @uses $MySqliDb->join('table1', 'field1 <> field2', 'LEFT')
     *
     * @param string $joinTable The name of the table.
     * @param string $joinCondition the condition.
     * @param string $joinType 'LEFT', 'INNER' etc.
     *
     * @return MysqliDb
     */
    public function join($as, $joinCondition, $joinType = '') {
        $this->db->join($as, $joinCondition, $joinType);
        return $this;
    }

    public function getLastError() {
        return $this->db->getLastError();
    }
    /**
     * A convenient num_rows
     *
     * @param string  $tableName The name of the database table to work with.
     *
     * @return int number rows from the select query.
     */
    public function num_rows() {
        return $this->db->num_rows($this->name);
    }
    /**
     * Copy table for multilang
     * Copy table lang_tablenam from vi_tablename and ADD id_lang (id of item from vi_tablenam)
     */
    private function CopyTableLang() {
        //return;
        if ($this->db->table_exist($this->name) === true) {
            return true;
        } else {
            //chua co bang, tien hanh nhan ban
            $langkey      = substr($this->name, 0, 3);
            $tabledefault = str_replace($langkey, 'vi_', $this->name);
            if ($this->db->table_exist($tabledefault)) {
                $this->db->rawQuery("CREATE TABLE `$this->name` LIKE `$tabledefault`");
            }
        }

    }

    /**
     * [ExistAndCreateField description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-12
     */
    private function ExistAndCreateField() {
        //Get all lang system
        $languages       = $this->language_system;
        $languages_array = array();
        foreach ($languages as $k => $v) {
            $languages_array[] = $v['code'];
        }
        //Tim lang key
        $langkey = substr($this->name, 0, 3);
        //Xoa dau _
        $lang_remove = str_replace('_', '', $langkey);
        if (in_array($lang_remove, $languages_array) == true) {
            $tabledefault = str_replace($langkey, 'vi_', $this->name);
        }

        if (isset($tabledefault)) {
            $query_get_columns_langdefault = 'SHOW COLUMNS FROM `' . $tabledefault . '`';
            $columns_langdefault           = $this->db->rawQuery($query_get_columns_langdefault);

            $query_get_columns_now = 'SHOW COLUMNS FROM `' . $this->name . '`';
            $columns_now           = $this->db->rawQuery($query_get_columns_now);

            //Kiem tra va so sanh co giong nhau khong

            //Khoi tao mang ten field - mac dinh cua lang vi
            $columns_field_name_df = array();
            foreach ($columns_langdefault as $k => $v) {
                $columns_field_name_df[] = $v['Field'];
            }

            //Khoi tao mang ten field - hien tai su dung
            $columns_field_name_nw = array();
            foreach ($columns_now as $k => $v) {
                $columns_field_name_nw[] = $v['Field'];
            }

            //So sanh 2 mang - filed khong ton tai
            $field_not_exist = $columns_field_name_df;
            foreach ($columns_field_name_df as $k => $v) {
                if (in_array($v, $columns_field_name_nw)) {
                    unset($field_not_exist[$k]);
                }
            }

            //Kiem tra nhung truong khong ton tai
            if (count($field_not_exist) == 0) {
                //Da du thi tra ve true, ket thuc xu ly
                return true;
            } else {
                //Chua du. xu ly tiep
                $columns_alter = array();
                foreach ($columns_langdefault as $k => $v) {
                    if (in_array($v['Field'], $field_not_exist) == true) {
                        //Build alter
                        //Thuoc tinh cua truong
                        $tmp_attr = '';
                        //Type
                        if (isset($v['Type']) && $v['Type'] != '') {
                            $tmp_attr .= $v['Type'];
                        }

                        //null
                        if (isset($v['Null']) && $v['Null'] != 'YES') {
                            $tmp_attr .= ' NOT NULL';
                        } else {
                            $tmp_attr .= ' NULL';
                        }

                        //Key - PRI
                        if (isset($v['Key']) && $v['Key'] == 'PRI') {
                            $tmp_attr .= ' PRIMARY KEY';
                        } elseif (isset($v['Key']) && $v['Key'] == 'UNI') {
                            $tmp_attr .= ' UNIQUE KEY';
                        }

                        //Default
                        if (isset($v['Default']) && $v['Extra'] != 'auto_increment' && $v['Null'] == 'YES') {
                            if ($v['Default'] == '') {
                                $tmp_attr .= ' DEFAULT NULL';
                            } else {
                                $tmp_attr .= ' DEFAULT ' . $v['Default'];
                            }
                        }

                        //Extra
                        if (isset($v['Extra']) && $v['Extra'] != '') {
                            $tmp_attr .= ' ' . $v['Extra'];
                        }

                        $tmp_alter = "ALTER TABLE `" . $this->name . "` ADD `" . $v['Field'] . "` " . $tmp_attr;
                        //Xu ly alter vao db
                        $this->db->rawQuery($tmp_alter);
                    }
                }
                return true;
            }
        }

    }

    private function db_connect($database = null) {
        global $_NOB;
        if ($database != null) {
            $dbs = $database;
        } else {
            $dbs = $_NOB['db_name'];
        }
        $db = new MysqliDb($_NOB['db_host'], $_NOB['db_user'], $_NOB['db_password'], $dbs, $_NOB['db_charset'], $_NOB['db_port']);
        if (!$db) {
            show_error(lang('error_connect_db'));
        }

        return $db;
    }
    /*
     * Lấy idw do lần đầu tiên load chỉ lấy được s_name
     * @Author: HuongNB (nguyenbahuong156@gmail.com)
     */
    private function getIdw($s_name) {
        $db = $this->db_connect();
        $db->where('s_name', $s_name);
        $idw = $db->getOne('web', null);
        return $idw['idw'];
    }

    /**
     * [reset description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-10-19
     * @return [type]                     [description]
     */
    public function reset() {
        return $this->db->reset();
    }

    public function buildFileCache() {
        global $_B;
        $domain = array_unique($_SESSION['domain']);
        foreach ($domain as $k => $v) {
            $home_mod    = 'home_' . $v;
            $current_mod = $_GET['mod'] . '_' . $v;
            $_B['cache']->del_tags($home_mod);
            $_B['cache']->del_tags($current_mod);
        }
        return true;

    }
}
?>
