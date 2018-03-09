<?php
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
class Watermark {
	function __construct() {

	}

	public function addWatermark() {
		global $_B;

		$db_cf = db_connect();
		$cf    = new Model('web_cf_admin', $db_cf);
		$cf->where('idw', $_B['web']['idw']);
		//$cf->where('`key`', 'seo_url');
		$result = $cf->get();

		return $result;
	}

	public function getKey() {
		global $_B;
		$db_cf = db_connect();
		$cf    = new Model('web_cf_admin', $db_cf);
		$cf->where('idw', $_B['web']['idw']);
		$cf->where('`key`', 'watermark');
		$result = $cf->getOne();
		return $result;
	}

	public function update($data) {
		global $_B;
		$db_cf = db_connect();
		$cf    = new Model('web_cf_admin', $db_cf);
		$cf->where('idw', $_B['web']['idw']);
		$cf->where('`key`', 'watermark');
		$result = $cf->update($data);
		return $result;
	}

	public function add($data) {
		global $_B;
		$db_cf  = db_connect();
		$cf     = new Model('web_cf_admin', $db_cf);
		$result = $cf->insert($data);
		return $result;
	}

	public function rmkdir($path, $mode = 0777) {
		
	    $path = rtrim(preg_replace(array("/\\\\/", "/\/{2,}/"), "/", $path), "/");
	    $e    = explode("/", ltrim($path, "/"));
	    if (substr($path, 0, 1) == "/") {
	        $e[0] = "/" . $e[0];
	    }
	    $c  = count($e);
	    $cp = $e[0];
	    for ($i = 1; $i < $c; $i++) {
	        if (!is_dir($cp) && !@mkdir($cp, $mode)) {
	            return false;
	        }
	        $cp .= "/" . $e[$i];
	    }
	    return @mkdir($path, $mode);
	}
}