<?php
/**
 * Code by Nguyen Xuan Truong
 */
class ModelFormCustom {
	function __construct() {
		global $_B, $web;
		$this->idw          = $_B['web']['idw'];
		$this->getLangAndID = getLangAndID(); //field_id
		$this->model        = new Model($this->getLangAndID['lang'] . '_formcustom');
		$this->model_email  = new Model($this->getLangAndID['lang'] . '_email_form');

	}
	public function add_email($data) {
		$result = $this->model_email->insert($data);
		return $result;
	}
	public function getNameForm($id_form) {
		$this->model->where('idw', $this->idw);
		$this->model->where('id', $id_form);		
		$result = $this->model->getOne(null, null, '*');
		return $result['title'];
	}
	public function getEmail($id_form) {
		$this->model_email->where('idw', $this->idw);
		$this->model_email->where('id_form', $id_form);		
		$result = $this->model_email->get(null, null, '*');
		return $result;
	}
	public function updateByIdEmail($data, $id_form) {
		$this->model_email->where($this->getLangAndID['field_id'], $id_form);
		$result = $this->model_email->update($data);
		return $result;
	}
	public function deleteEmail($id_form) {
		$this->model_email->where($this->getLangAndID['field_id'], $id_form);
		return $this->model_email->delete();
	}
	public function add($data) {
		$data['id_form']=$this->countIdForm();
		$result = $this->model->insert($data);
		return $result;
	}
	public function update_form($data, $id) {
		$this->model->where($this->getLangAndID['field_id'], $id);
		$result = $this->model->update($data);
		return $result;
	}

	public function updateByIdForm($data, $id_form) {
		$this->model->where($this->getLangAndID['field_id'], $id_form);
		$result = $this->model->update($data);
		return $result;
	}

	public function getFormByIdForm($id_form) {
		$this->model->where($this->getLangAndID['field_id'], $id_form);
		$result = $this->model->getOne(null, '*');
		return $result;
	}
	private function getTotal() {
		return $this->model->num_rows();
	}
	public function getList($page) {
		$per_page = 30;
		$total    = $this->getTotal();
		if (!$page || $page == 0 || $page == 1) {
			$page  = 1;
			$start = 0;
			$end   = $per_page;
			$limit = array($start, $end);
		} else {
			$start = ($page - 1) * $per_page;
			$end   = $per_page;
			$limit = array($start, $end);
		}
		$this->model->where('idw',$this->idw);
		//$this->model->where('status', 1);
		$content = $this->model->get(null, $limit, '*');
		// = $this->model->get(null, $limit, '*');
		$result['content'] = array();
		foreach ($content as $k => $v) {
			if ($this->getLangAndID['lang'] != 'vi') {
				$v['id'] = $v['id_lang'];
			}
			$result['content'][] = $v;
		}
		$url = 'template-customForm-listForm-lang-' . $_GET['lang'];
		if ($total > $per_page) {
			$result['pagination']          = pagination($per_page, $total, 5, $url);
			$result['pagination']['limit'] = $per_page;
		}

		return $result;
	}
	public function delete($id_form) {
		$this->model->where($this->getLangAndID['field_id'], $id_form);
		return $this->model->delete();
	}
	//**********************************COPY FORM***********************************//
	public function checkExist($id_form, $lang) {
		$oBj = new Model($lang . '_formcustom');
		//Kiem tra xem da ton tai chua
		$oBj->where($this->getLangAndID['field_id'], $id_form);
		return $oBj->num_rows();
	}

	public function create($data, $lang) {
		$oBj = new Model($lang . '_formcustom');
		//Kiem tra xem da ton tai chua
		return $oBj->insert($data);
	}

	public function updateCoppy($data, $lang, $id) {
		$oBj = new Model($lang . '_formcustom');
		$oBj->where($this->getLangAndID['field_id'], $id);
		//Kiem tra xem da ton tai chua
		return $oBj->update($data);
	}

	/************************DATA FORM****************************/
	public function getFieldForm($form_id) {
		$this->model->where($this->getLangAndID['field_id'], $form_id);
		return $this->model->getOne(null, 'field');
	}
	private function getTotalDataForm($form_id, $lang = 'vi') {
		$oBj = new Model('data_formcustom');
		$oBj->where('idw', $this->idw);
		$oBj->where('form_id', $form_id);
		$oBj->where('language', $lang);
		return $oBj->num_rows();
	}
	public function getDataForm($page, $per_page, $form_id, $lang = 'vi') {
		$lang = $_GET['lang'];

		$total = $this->getTotalDataForm($form_id, $lang);
		if (!$page || $page == 0 || $page == 1) {
			$page  = 1;
			$start = 0;
			$end   = $per_page;
			$limit = array($start, $end);
		} else {
			$start = ($page - 1) * $per_page;
			$end   = $per_page;
			$limit = array($start, $end);
		}
		$oBj = new Model('data_formcustom');
		$oBj->where('idw', $this->idw);
		$oBj->where('form_id', $form_id);
		$oBj->where('language', $lang);
		$this->model->orderBy('create_time', 'DESC');
		$data['content'] = $oBj->get(null, $limit, null);
		
		if ($total > $per_page) {
			$url                         = 'template-customForm-viewdata-' . $form_id . '-lang-' . $lang;
			$data['pagination']          = pagination($per_page, $total, 5, $url);
			$data['pagination']['limit'] = $per_page;
		}

		return $data;
	}

	public function deleteDataForm($id) {
		$oBj = new Model('data_formcustom');
		$oBj->where('idw', $this->idw);
		$oBj->where($this->getLangAndID['field_id'], $id);
		$result = $oBj->delete();
		return $result;
	}
	public function updateStatusDataForm($id, $data) {
		$oBj = new Model('data_formcustom');
		$oBj->where('idw', $this->idw);
		$oBj->where($this->getLangAndID['field_id'], $id);
		$result = $oBj->update($data);
		return $result;
	}
	
	public function countIdForm()
	{
		$this->model->where('idw',$this->idw);
		$this->model->orderBy('id_form','DESC');
		$data=$this->model->getOne(null,'id_form');
		if(isset($data['id_form'])){
			return $data['id_form']+1;
		}else{
			return 1;
		}
	}	
}