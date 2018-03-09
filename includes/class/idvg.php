<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /includes/class/idvg.php 
 * @Author Huong Nguyen Ba (nguyenbahuong156@gmail.com)
 * @Createdate 23/03/2015, 10:55 AM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
include_once DIR_CLASS.'symetricTicket.php';
class Idvg {

	public function __construct() {
		global $_B;
		$this->request = $_B['r'];

		// if (!empty($this->request->get['access_code'])) {
		// 	$this->session->data['access_code']  = $this->request->get['access_code'];
		// 	$arr_idvg = $this->access_token($this->session->data['access_code'],'','');
		// 	$json = json_decode($arr_idvg,'json');
		// 	$token =  $json['objects'][0]['access_token'];
			
		// 	if (isset($token)) {
		// 		$stt_token = $this->access_token('',$token,'acc');
		// 		 if ($stt_token) {
		//          	$json_acc = json_decode($stt_token,'json');
	 //        	}
		// 	}
		// }
	}

	public function getInfoIdVG($access_code){
		if (!empty($access_code)) {
			$arr_idvg = $this->access_token($access_code,'','');
			$json = json_decode($arr_idvg,'json');
			$this->token =  $json['objects'][0]['access_token'];
		}
		if (!empty($this->token)) {
				$stt_token = $this->access_token('',$this->token,'acc');
				 if ($stt_token) {
		         	$json_acc = json_decode($stt_token,'json');
	        	}
		}else{
			return false;
		}
		return $json_acc['objects'][0]['acc'];
	}
	public function getTicketIdvg($username,$password){
		 $s = new SymetricTicket(array(
                'username'=>$username,
                'password'=>$password,
                'timestamp'=>time(),
                'remember'=>true,
            ), '7b674ca3487e2afdfeaf201cf03e704a8845be5a705c0b35a8723ac495cb05ed|01e6d28a6328a13c501fe7127b282d74');

    		$ticket = $s->encrypt();
    		$ticket = urlencode($ticket);
    		return $ticket;
	}
	public function access_token($accessCode,$token='',$with=''){ 
		if ($accessCode) {
			$url = 'https://id.vatgia.com/oauth2/accessCode/'.$accessCode;
		}else if ($token) {
			$url  = "https://id.vatgia.com/oauth2/accessToken/".$token."?with=acc";
		}
	        $ch = curl_init(); 
	        curl_setopt($ch, CURLOPT_URL, $url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($ch, CURLOPT_USERPWD, "webbnc_2:SJzhQMHCdWr0YO1pwvBN");
	        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	        $output = curl_exec($ch);
	        $info = curl_getinfo($ch);
	        curl_close($ch);
	        return $output;
	}
}
?>