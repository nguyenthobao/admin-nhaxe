<?php
/**
 *
 */
class Model_RedirectUrl {

	function __construct() {
		global $_B;
		$this->idw   = $_B['web']['idw'];
		$this->db    = db_connect('seo');
		$this->model = new Model('redirect_url', $this->db);
	}
	 
	public function redirect_url($data)
	{
		foreach ($data as $key => $value) {
			$request = array(
				'idw' => $this->idw,
				'url_source' => $value['url_source'],
				'url_destination' => $value['url_destination'],				
			);
			$result= $this->model->insert($request);
		}

	}
	public function redirect_edit($data)
	{
		foreach ($data as $key => $value) {
			$request = array(
				'idw' => $this->idw,
				'url_source' => $value['url_source'],
				'url_destination' => $value['url_destination'],				
			);
			$this->model->where('id',$value['id']);
			$result= $this->model->update($request);
		}

	}
	public function delete_url($id)
	{
		$this->model->where('id',$id);
		$this->model->delete();
	}
	public function geturl()
	{
		$this->model->where('idw', $this->idw);
		$data = $this->model->get();
		return $data;
	}
}