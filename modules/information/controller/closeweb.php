<?php

/**
 * @Project BNC v2 -> Module [infomation->closeweb]
 * @File /closeweb.php
 * @Author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 2015/06/19, 16:09 [ AM]
 */
    	
class Closeweb {
	function __construct() {
		global $_B;
		$this->temp        = $_B['temp'];
		$this->request     = $_B['r'];
		$this->idw         = $_B['web']['idw'];

		$this->model = new ModelCloseweb;
	}

	public function index() {

		global $_DATA, $_B;
		if (!empty($_POST['action']) && $_POST['action']=='saveCloseweb') {
			$content    = $this->request->get_string('content','POST');
			
			$styleClose = $this->request->get_string('styleClose','POST');
			$data['status'] = $this->request->get_int('status','POST');
			$data['closeweb'] = array( 'status'=>$data['status'],'style'=>$styleClose,'content'=>$content,'contentCus'=>$contentCus);
			$save = $this->model->saveCloseWeb($data);
			if ($save) {
				$result['status'] = true;
				echo json_encode($result);exit();
			}
		}
		$_DATA['data'] = $this->model->getCloseWeb();
		
		$_DATA['content_module'] = $this->temp->load('closeweb');
	}
}