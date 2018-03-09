<?php

if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class InformationBasic {
	public $idw,$r,$infolist;
	private $uid;
	public function __construct(){
			global $_B;	 
			$this->r   = $_B['r'];
			$this->idw = $_B['web']['idw'];
			$this->uid = $_B['uid'];
	}

	public function addInformationBasic(){
			$lang 	  = $this->r->get_string('lang','GET');
			$infolist = new Model($lang.'_information');

			include(DIR_HELPER_UPLOAD);
		  	$options    = array('max_size' => 1600);
			$upload     = new BncUpload($options);
			$up_img     = $upload->upload($this->idw,'informationbasic','img_news');
			$up_favicon = $upload->upload($this->idw,'informationbasic','favicon_news');
			$provinces_id = $this->r->get_string('provinces','POST');
			$provinces_id = explode('-', $provinces_id);
			$district_id  = $this->r->get_string('districtid','POST');
			$district_id  = explode('-', $district_id);
			$ward_id  = $this->r->get_string('wardid','POST');
			$ward_id  = explode('-', $ward_id);

			$data     = array(
				'idw'				=>$this->idw,
				'business'          =>$this->r->get_string('business','POST'),
				'phone'             =>$this->r->get_string('phone','POST'),
				'address'           =>$this->r->get_string('address','POST'),
				'email'             =>$this->r->get_string('email','POST'),
				'name'              =>$this->r->get_string('name','POST'),
				'provinces'         =>$provinces_id[0],
				'provinceid'        =>$provinces_id[1],
				'district'          =>$district_id[0],
				'districtid'		=>$district_id[1],
				'ward'              =>$ward_id[0],
				'wardid'            =>$ward_id[1],
				'meta_title'		=>$this->r->get_string('meta_title','POST'),
				'meta_keyword'		=>$this->r->get_string('meta_keyword','POST'),
				'meta_description'	=>$this->r->get_string('meta_description','POST'),
				'create_time'       =>time(),
			);

			if(isset($up_img) && !isset($up_img['status']) ){
				$data['img'] =$up_img;

			}else{$data['img']="";}
			if (isset($_POST['img_news'])&&$_POST['img_news']=="1") {
				unset($data['img']);
			}
			if(isset($up_favicon) && !isset($up_favicon['status'])){
				$data['icon']=$up_favicon;
			}else{
				$data['icon']="";
			}

			if(isset($_POST['favicon_news'])&&$_POST['favicon_news']=='1'){
				unset($data['icon']);
			}

		 	$infolist -> where('idw',$this->idw);
		 	if($infolist  -> num_rows() > 0 ){
		 		$infolist -> where('idw',$this->idw);
				$result = $infolist->update($data);
		 	}
		 	else{ 
		 		$result = $infolist->insert($data);
		 	}
			if ($result) {
				$return['status'] = true;
			}else{
				$return['status'] = false;
			}
			return $return;
	}

	public function getInformation(){
		$lang 	  = $this->r->get_string('lang','GET');
		$infolist = new Model($lang.'_information');
		$select = '*';
		$infolist->where('idw',$this->idw);
		$data   = $infolist->getOne(null,null,$select);
		return $data;
	}

	function postpage($url){
		$handle =curl_init();
		curl_setopt($handle, CURLOPT_URL,$url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($handle, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
		curl_setopt($handle,CURLOPT_USERPWD,'bncsysapi:bncsysapi');
		$output['data'] =curl_exec($handle);
		curl_close($handle);
		return json_decode($output['data'],'1');
	}	
	
}
