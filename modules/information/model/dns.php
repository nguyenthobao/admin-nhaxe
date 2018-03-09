<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/categorylist.php 
 * @Author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 08/21/2014, 14:31 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class Dns{
	public function __construct(){
			global $_B;
			$this->r    = $_B['r'];
			$this->idw  = $_B['web']['idw'];
			$this->lang = $_B['cf']['lang'];
	}
	/**
	 * [getDomainFromWeb lấy toàn bộ domain của một website]
	 * @return [array] [trả ra dữ liệu dns của tất cả các domain]
	 */
	public function getDomainFromWeb()
	{
		global $_B;
		$domains = explode(",", $_B['web']['domain']);
		foreach ($domains as $k=>$v) {
			if (!empty($v)) {
				$dns['domain'][] = $v;
				if ($ns = $this->getDNSbyDomain($v)) {
					$dns['dns'][$v] = $ns;
				}
			}
		}
		
		return $dns;
	}
	/**
	 * [getDNSbyDomain  lấy thông tin các bản ghi dns theo domain]
	 * @return [array] [trả ra mảng dữ dns của một domain]
	 */
	public function getDNSbyDomain($domain){
		
		$ch   = curl_init();
		$url  = "https://dns-orig.webbnc.vn/get_domain_json.php?domain=".$domain;
	    
		$ch     = curl_init ($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERPWD, "dns_get_json:bananhhuong");
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		$output = curl_exec ($ch);
		
		    	
		if ($output==true) {
			$result = array();
			$output = json_decode($output);
			$code   = curl_getinfo($ch, CURLINFO_HTTP_CODE );
		    if ($output->status==true) {
		    	if (empty($output->data)) {
		    		return false;
		    	}
		    	foreach ($output->data as $v) {
		    		$result[] = array(
						'name'    =>$v->name,
						'type'    =>$v->type,
						'content' =>$v->content
		    			);
		    	}
		    }
		    return $result;	
		}else{
			return false;
		}
		
	}
}