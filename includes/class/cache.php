<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /includes/class/cache.php
 * @Author Quang Chau Tran (quangchauvn@gmail.com)
 * @Createdate 10/30/5014, 10:40 AM
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}
class CacheBNCadmin {
    private $dbname, $mod, $data, $s_name, $idw;
    public function __construct($s_name, $idw, $mod, $dbname, $data = null) {
        $this->mod    = $mod;
        $this->dbname = $dbname;
        $this->data   = $data;
        $this->s_name = $s_name;
        $this->idw    = $idw;
        $this->changeStatus();
    }
    //chuyen status cua dbname va idw ve dang co cap nhat
    private function changeStatus() {
        $cache = new CacheBNC();
        $key   = 'status_' . $this->dbname . $this->idw;
        $cache->set($key, true);
    }
    public function update() {

        $action = 'update_' . $this->mod;

        if (method_exists($this, $action)) {
            $this->$action();
        } else {
            $this->update_mod();
        }

    }
    //update cache cho các module không cau hinh dac biet
    private function update_mod() {

    }
    private function update_menu() {
        $key  = substr($this->dbname, 3);
        $keys = array(
            $this->s_name . '_' . $key,
        );
        $cache = new CacheBNC();

        foreach ($keys as $key => $value) {
            $cache->del($value);
        }
    }
}
// copy tu frontend phan duoi
class CacheBNC {
    /*
     * config memcache
     */
    private $memcache_port   = 11211;
    private $memcache_server = array('localhost');
    /*
     * config redis
     */
    private $redis_port   = 6379;
    private $redis_server = array('192.168.1.11');
    /*
     * other
     */
    private $drive;
    public $cache;
    public $cached;
    public function __construct($drive = 'memcache') {
        global $_CACHE;
        $this->cached = $_CACHE[$drive];
        $this->drive  = $drive;
        return $this->$drive();
    }
    /*
     * drives memcache
     */
    private function memcache() {
        $this->cache = new Memcache;
        foreach ($this->memcache_server as $key => $value) {
            $this->cache->addServer($value, $this->memcache_port);
        }
        //return $this->cache;
    }
    private function memcache_get($key, $compressed) {
        return $this->cache->get($key, $compressed);
    }
    private function memcache_set($key, $value, $compressed, $expire) {
        return $this->cache->set($key, $value, $compressed, $expire);
    }
    private function memcache_del($key) {
        return $this->cache->delete($key);
    }
    /*
     * drives redis
     */
    private function redis() {
        $this->cache = new Redis();
        foreach ($this->redis_server as $key => $value) {
            $this->cache->connect($value, $this->redis_port);
        }
        //return $this->cache;
    }
    private function redis_get($key, $compressed) {
        return $this->cache->get($key);
    }
    private function redis_set($key, $value, $compressed, $expire) {
        return $this->cache->set($key, $value);
    }
    private function redis_del($key) {
        return $this->cache->delete($key);
    }
    /*
     * public functions
     */
    public function get($key, $compressed = false) {
        if ($this->cached == false) {
            return false;
        }
        $function = $this->drive . '_get';
        return $this->$function($key, $compressed);
    }
    public function set($key, $value, $compressed = false, $expire = 0) {
        if ($this->cached == false) {
            return false;
        }
        $function = $this->drive . '_set';
        return $this->$function($key, $value, $compressed, $expire);
    }
    public function del($key) {
        if ($this->cached == false) {
            return false;
        }
        $function = $this->drive . '_del';
        return $this->$function($key);
    }

    public function del_tags($tags_name) {
        $tags = $this->get($tags_name);
        if (is_array($tags)) {
            foreach ($tags as $kt => $vt) {
                $this->del($vt);
            }
        }
        return true;
    }

}

?>