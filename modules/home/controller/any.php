<?php 
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
class Any extends \Bncv2\Core\Controller
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function truong()
	{
		$db=db_connect_mod('notify');
		$obj=new Model('address_province',$db);
		echo '<pre>';
		print_r(12312);
		echo '</pre>';
		die();
		$json=$obj->get();
		echo json_encode($json);
		die();

	}
	public function getNotify()
	{
		
		$author=$this->request->get_string('author','POST');
		if($author=='nxt'){
			$result=$this->getNotifyController();
		}
		echo json_encode($result);
		exit();
	}
	
	public function ajaxDeleteFile()
	{
		$file=$this->request->get_string('path','POST');
		$this->deleteFile($file);
		return true;
	}
}