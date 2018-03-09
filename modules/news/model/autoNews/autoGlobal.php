<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/autoNews/autoGlobal.php
 * @Author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 01/12/2015, 10:30 AM
 */

class autoGlobal{
	public function callAPI($url){
		$nbh   = curl_init();
		curl_setopt($nbh, CURLOPT_URL, $url);
		curl_setopt($nbh, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($nbh,CURLOPT_RETURNTRANSFER,1);
		$output = curl_exec ($nbh);
		curl_close($nbh);
		$output = json_decode($output);
	    return $output;
	}
}

?>