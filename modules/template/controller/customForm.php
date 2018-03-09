<?php
//Code by Nguyen Xuan Truong
//error_reporting(0);
class customForm {
	function __construct() {
		global $_B;
		$this->idw          = $_B['web']['idw'];
		$this->temp         = $_B['temp'];
		$this->request      = $_B['r'];
		$this->getLangAndID = getLangAndID(); //field_id
		$this->mCF          = new ModelFormCustom;

	}
	/**
	 * [index description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-05-27
	 * @return [type]                     [description]
	 */
	public function index() {
		global $_DATA, $_B;
		$_S['breadcrumb_page'] = lang('breadcrumb_add_slide');
		$_S['title']           = lang('title');
		$_S['description']     = lang('description');

		$id = $this->request->get_int('id', 'GET');
		if (!empty($id)) {
			$_DATA['item'] = $this->mCF->getFormByIdForm($id);
		}

		if ($_B['lang'] != $_B['lang_default']) {
			$_DATA['item']['id'] = $_DATA['item']['id_lang'];
		}

		//Load theme cho page add slide
		$_DATA['content_module'] = $this->temp->load('customFormAdd');
	}
	/**
	 * [get_lang_use description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-05-27
	 * @return [type]                     [description]
	 */
	public function get_lang_use() {
		global $_B, $_DATA;
		$lang_use = explode(',', $_B['cf']['lang_use']);
		if (!empty($lang_use)) {
			foreach ($lang_use as $k => $v) {
				if (isset($_GET['id'])) {
					$lang_use[$k] = array(
						'lang'   => $v,
						'url'    => $_B['home'] . '/' . $_GET['mod'] . '-' . $_GET['page'] . '-' . $_GET['sub'] . '-' . $_GET['id'] . '-lang-' . $v,
						'exists' => '',
					);
				} else {
					$lang_use[$k] = array(
						'lang'   => $v,
						'url'    => $_B['home'] . '/' . $_GET['mod'] . '-' . $_GET['page'] . '-' . $_GET['sub'] . '-lang-' . $v,
						'exists' => '',
					);
				}

			}
		}
		return $lang_use;
	}
	/**
	 * [listForm description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-05-27
	 * @return [type]                     [description]
	 */
	public function listForm() {
		global $_DATA, $_B;
		$_S['breadcrumb_page'] = lang('breadcrumb_add_slide');
		$_S['title']           = lang('title');
		$_S['description']     = lang('description');
		$page                  = $this->request->get_int('p', 'GET');
		$content               = $this->mCF->getList($page);
		$_DATA['content']      = $content['content'];
		$_DATA['pagination']   = @$content['pagination'];
		$_DATA['lang_use']     = $this->get_lang_use();
		$_DATA['lang']         = $_B['lang_default'];
		$_DATA['lang_using'] = $this->request->get_string('lang', 'GET');
		//Load theme cho page add slide
		$_DATA['content_module'] = $this->temp->load('customFormList');
	}

	public function listEmail() {
		global $_DATA, $_B;
		$_S['breadcrumb_page'] = lang('breadcrumb_manager_email');
		$_S['title']           = lang('title');
		$_S['description']     = lang('description');

		
		if(isset($_POST['continue'])){
			$id_form                  = $this->request->get_int('id', 'GET');
			$data = array(
				'idw'     => $this->idw,
				'email'   => $this->request->get_string('email', 'POST'),
				'name'    => $this->request->get_string('name', 'POST'),				
				'id_form' => $id_form,
			);
		 // 	echo "<pre>";
			// print_r($data);
			// echo "</pre>";
			// die();
			$result = $this->mCF->add_email($data);
			if($result['status']){ 
				$_SESSION['success'] = lang('success');
				$continue = $this->request->get_string('continue', 'POST');
				$this->mCF->redirect($_B['home'].'/'.$_DATA['mod'].'-'.$_DATA['page'].'-index-'.$this->request->get_int('id', 'GET').'-lang-'.$this->lang, $result['last_id']);
			}else{
				$_SESSION['error_submit'] = $result['error'];
			}
		}
		$id_form             = $this->request->get_int('id', 'GET');
		$data_email          = $this->mCF->getEmail($id_form);
		$name_form           = $this->mCF->getNameForm($id_form);
		$_DATA['name_form']  = $name_form;

		$_DATA['data_email'] = $data_email;
		$_DATA['pagination'] = @$data_email['pagination'];
		$_DATA['lang_use']   = $this->get_lang_use();
		$_DATA['lang']       = $_B['lang_default'];

		//Load theme cho page add slide
		$_DATA['content_module'] = $this->temp->load('customFormEmailList');
	}

	/**
	 * [saveForm description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-05-27
	 * @return [type]                     [description]
	 */
	public function saveForm() {
		$id              = $this->request->get_int('id', 'POST');
		$title           = $this->request->get_string('title', 'POST');
		$form_backend    = $this->request->get_string('form_backend', 'POST');
		$modal_backend   = $this->request->get_string('modal_backend', 'POST');
		$form_frontend   = $this->request->get_string('form_frontend', 'POST');
		$arrayTitleField = $this->request->get_array('arrayTitleField', 'POST');
		$arrayNameField  = $this->request->get_array('arrayNameField', 'POST');
		$field           = array();
		
		foreach ($arrayNameField as $k => $v) {
			$field[$v] = $arrayTitleField[$k];
		}
		if (empty($id)) {
			//Luu moi form
			$data = array(
				'idw'           => $this->idw,
				'form_backend'  => $form_backend,
				'form_frontend' => $form_frontend,
				'modal_backend' => $modal_backend,
				'title'         => $title,
				'create_time'   => time(),
				'field'         => json_encode($field),
			);
			$id_k        = $this->mCF->add($data);
			$data_update = array(
				$this->getLangAndID['field_id'] => $id_k,
			);
			$this->mCF->update_form($data_update, $id_k);
			$result = array(
				'status'  => true,
				'message' => 'Thao tác thành công',
			);
		} else {
			$data = array(
				'idw'           => $this->idw,
				'form_backend'  => $form_backend,
				'form_frontend' => $form_frontend,
				'modal_backend' => $modal_backend,
				'title'         => $title,
				'update_time'   => time(),
				'field'         => json_encode($field),
			);
			$this->mCF->updateByIdForm($data, $id);
			$result = array(
				'status'  => true,
				'message' => 'Thao tác thành công',
			);
		}
		echo json_encode($result);
		$_DATA['content_module'] = '';
		exit();
	}
	/**
	 * [ajaxCoppyForm description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-05-27
	 * @return [type]                     [description]
	 */
	public function ajaxCoppyForm() {
		$id_form = $this->request->get_int('id_form', 'POST');
		$lang    = $this->request->get_string('lang', 'POST');
		//Get data form
		$data_form = $this->mCF->getFormByIdForm($id_form);
		$data      = $data_form;
		unset($data['id']);
		//Kiem tra ton tai chua
		$checkExist = $this->mCF->checkExist($id_form, $lang);
		if ($checkExist != 0) {
			$data['update_time'] = time();
			$this->mCF->updateCoppy($data, $lang, $id_form);
		} else {
			$data['create_time'] = time();
			$data['id_lang']     = $id_form;
			$this->mCF->create($data, $lang);

		}
		$result = array(
			'status'  => true,
			'message' => 'Sao chép thành công',
		);
		echo json_encode($result);
		$_DATA['content_module'] = '';
		exit();

	}
	/**
	 * [ajaxChangeTitle description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-05-27
	 * @return [type]                     [description]
	 */
	public function ajaxChangeTitle() {
		$id_form = $this->request->get_int('pk', 'POST');
		$title   = $this->request->get_string('value', 'POST');
		$data    = array(
			'title'       => $title,
			'update_time' => time(),
		);
		$this->mCF->updateByIdForm($data, $id_form);
		$result = array(
			'status' => true,
		);
		echo json_encode($result);
		$_DATA['content_module'] = '';
		exit();
	}
	/**
	 * [ajaxEditStatus description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-05-27
	 * @return [type]                     [description]
	 */
	public function ajaxEditStatus() {
		$id_form = $this->request->get_int('id', 'POST');
		$status  = $this->request->get_int('status', 'POST');
		$data    = array(
			'status'      => $status,
			'update_time' => time(),
		);
		$this->mCF->updateByIdForm($data, $id_form);
		$result = array(
			'status' => true,
		);
		echo json_encode($result);
		$_DATA['content_module'] = '';
		exit();
	}
	/**
	 * [ajaxDelete description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-05-27
	 * @return [type]                     [description]
	 */
	public function ajaxDelete() {
		$id_form = $this->request->get_int('id', 'POST');

		$this->mCF->delete($id_form);
		$result = array(
			'status' => true,
		);
		echo json_encode($result);
		$_DATA['content_module'] = '';
		exit();
	}
	/**
	 * [ajaxMultiDelete description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-05-27
	 * @return [type]                     [description]
	 */
	public function ajaxMultiDelete() {
		$id_form = $this->request->get_array('id', 'POST');
		foreach ($id_form as $k => $v) {
			$rs = $this->mCF->delete($v);
		}
		$result = array(
			'status' => true,
		);
		echo json_encode($result);
		$_DATA['content_module'] = '';
		exit();
	}

	public function viewdata() {
		global $_DATA,$_B;
		$page    = $this->request->get_int('p', 'GET');
		$id      = $this->request->get_int('id', 'GET');
		$field   = $this->mCF->getFieldForm($id);
		$field   = json_decode($field['field'], true);
		$content = $this->mCF->getDataForm($page, 50, $id, $_GET['lang']);
		foreach ($field as $k => $v) {
			$field[$k] = str_replace(':', '', $v);
		}
		$contents = array();
		foreach ($content['content'] as $k => $v) {
			$contents[$k]           = json_decode($v['data'], true);
			foreach ($contents[$k] as $k_file => $v_file) {
				preg_match("/file_(.*)/", $k_file, $matches);
				if(isset($matches[1]) && $matches[1]!=false){
					$contents[$k][$k_file]='<a target="_blank" href="'.$_B['upload_path'].$v_file.'">Tải file</a>';
				}
			}
			$contents[$k]['id']     = $v['id'];
			$contents[$k]['status'] = $v['status'];
			
		}
		$_DATA['lang_use']       = $this->get_lang_use();
		$_DATA['field']          = $field;
		$_DATA['content']        = $contents;
		$_DATA['pagination']     = @$content['pagination'];
		$_DATA['content_module'] = $this->temp->load('customFormViewData');
	}

	public function ajaxDeleteData() {
		$id = $this->request->get_int('id', 'POST');
		$this->mCF->deleteDataForm($id);
		$result = array(
			'status'  => true,
			'message' => 'Xóa thành công',
		);
		echo json_encode($result);
		exit();
	}

	public function ajaxMultiDeleteData() {
		$id = $this->request->get_array('id', 'POST');
		foreach ($id as $k => $v) {
			$this->mCF->deleteDataForm($v);
		}
		$result = array(
			'status'  => true,
			'message' => 'Xóa thành công',
		);
		echo json_encode($result);
		exit();
	}

	public function ajaxEditStatusDataForm() {
		$id     = $this->request->get_int('id', 'POST');
		$status = $this->request->get_int('status', 'POST');
		$data   = array(
			'status' => $status,
		);
		$this->mCF->updateStatusDataForm($id, $data);
		$result = array(
			'status'  => true,
			'message' => 'Thành công',
		);
		echo json_encode($result);
		exit();
	}


	public function ajaxChangeTitleEmail() {
		$id_form = $this->request->get_int('pk', 'POST');
		$email   = $this->request->get_string('value', 'POST');
		$data    = array(
			'email'       => $email,
		);
		$this->mCF->updateByIdEmail($data, $id_form);
		$result = array(
			'status' => true,
		);
		echo json_encode($result);
		$_DATA['content_module'] = '';
		exit();
	}
	public function ajaxChangeTitleName() {
		$id_form = $this->request->get_int('pk', 'POST');
		$name   = $this->request->get_string('value', 'POST');
		$data    = array(
			'name'       => $name,
		);
		$this->mCF->updateByIdEmail($data, $id_form);
		$result = array(
			'status' => true,
		);
		echo json_encode($result);
		$_DATA['content_module'] = '';
		exit();
	}
	public function ajaxDeleteEmail() {
		$id_form = $this->request->get_int('id', 'POST');

		$this->mCF->deleteEmail($id_form);
		$result = array(
			'status' => true,
		);
		echo json_encode($result);
		$_DATA['content_module'] = '';
		exit();
	}
}