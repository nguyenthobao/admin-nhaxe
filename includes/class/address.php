<?php
/**
 * @Project BNC v2 -> api
 * @File /includes/class/address.php 
 * @author Huong Nguyen Ba (nguyenbahuong156@gmail.com)
 * @Createdate 10/01/2014, 10:06 AM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
class Address{
	public $db,$r;
	
	public function __construct(){
		global $_B;				
		$this->r   = $_B['r'];
		$this->db = db_connect('user');	    	
	}
	public function getProvince(){
		$pro = new Model('address_province',$this->db);
		$result = $pro->get(null,null,'*');
		return $result;
	}
	public function getProvinceTax(){
		$pro_tax = new Model('address_province_au',$this->db);
		$result = $pro_tax->get(null,null,'*');
		return $result;
	}
	public function getDistrict($id){
		//$id = $this->r->get_int('id','GET');
		$dis = new Model('address_district',$this->db);
		$dis->where('provinceid',$id);
		$result = $dis->get(null,null,'*');
		return $result;
	}

	public function getWard($iddis){
		//$iddis = $this->r->get_int('id','GET');
		$ward = new Model('address_ward',$this->db);
		$ward->where('districtid',$iddis);
		$result = $ward->get(null,null,'*');
		return $result;
	}

	public function getProvinceByID($id){
		//$id = $this->r->get_string('id','GET');
		$pro = new Model('address_province',$this->db);
		$pro->where('provinceid',$id);
		$result = $pro->getOne(null,'*');
		return $result;
	}
	public function getDistrictByID($id){
		//$id = $this->r->get_string('id','GET');
		$dis = new Model('address_district',$this->db);
		$dis->where('districtid',$id);
		$result = $dis->getOne(null,'*');
		return $result;	
	}

}