<?php
/**
 * @Project BNC v2 -> api
 * @File /includes/class/api.php 
 * @Author Huong Nguyen Ba (nguyenbahuong156@gmail.com)
 * @Createdate 10/01/2014, 10:06 AM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
class Api{
	private $db,$r;
	private $username = 'bncsysapi';
	private $pass     = 'bncsysapi';
	public function __construct(){
		global $_B;				
		$this->r   = $_B['r'];
		// if (!(isset($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_USER'] == $this->username && $_SERVER['PHP_AUTH_PW'] == $this->pass)) {
		//     header("WWW-Authenticate: Basic realm=\"dev2.webbnc.vn\"");
		//     header("HTTP/1.0 401 Unauthorized");
		//     echo 'Dien thong tin tai khoan va mat khau de truy cap'; 
		//     exit();
		// }
	}
	
	public function getProvince(){
		$pro = new Model('address_province');
		$result = $pro->get(null,null,'*');
		echo json_encode($result);
		die();
	}
	public function getDistrict(){
		$id = $this->r->get_int('id','GET');
		$dis = new Model('address_district');
		$dis->where('provinceid',$id);
		$result = $dis->get(null,null,'*');
		echo json_encode($result);
		die();
	}

	public function getWard(){
		$iddis = $this->r->get_int('id','GET');
		$ward = new Model('address_ward');
		$ward->where('districtid',$iddis);
		$result = $ward->get(null,null,'*');
		echo json_encode($result);
		die();
	}

	public function sendMail($data=null){
		 
	}

}