<?php
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
class Blockcustom {
	public $request, $idw, $lang, $modelObj;
	public function __construct() {
		global $_B;
		$this->request = $_B['r'];
		$this->idw     = $_B['web']['idw'];
		$this->lang    = $_B['cf']['lang'];
		//$this->modelObj = new Model($this->lang . '_blockcustom');
		$this->modelObj = new Model($_GET['lang'] . '_block');
	}
	/**
	 * [addBlockcustom description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 */
	public function addBlockcustom() {
		global $_B;
		$this->modelObj = new Model($_GET['lang'] . '_block');
		$title      = $this->request->get_string('title', 'POST');
		$html       = $_POST['html'];
		$css        = $this->request->get_string('css', 'POST');
		$sort       = $this->request->get_int('sort', 'POST');
		$position   = $this->request->get_string('position', 'POST');
		$status     = $this->request->get_int('status', 'POST');
		$lang       = $this->request->get_string('lang', 'POST');
		$active_mod = $this->request->get_array('active_mod', 'POST');

		if (count($active_mod) == count($_B['mod_in_home'])) {
			$active_mod = ',all,';
		} else {
			$active_mod = ',' . implode(',', $active_mod) . ',';
		}
		$content = array(
			'css'  => @$css,
			'html' => @$html,
		);
		if ($lang != 'vi') {
			$id_lang = $this->request->get_int('id');
			$data = array(
			'idw'          => $this->idw,
			'title'        => $title,
			'sort'         => $sort,
			'position'     => $position,
			'status'       => $status,
			'active_mod'   => $active_mod,
			'type'         => 1,
			'data_custome' => json_encode($content),
			'idblock'      => $this->countMax(),
			'id_lang'	   => $id_lang,
			);
		}else{
			$data = array(
			'idw'          => $this->idw,
			'title'        => $title,
			'sort'         => $sort,
			'position'     => $position,
			'status'       => $status,
			'active_mod'   => $active_mod,
			'type'         => 1,
			'data_custome' => json_encode($content),
			'idblock'      => $this->countMax(),
			);
		}
		if ($lang != 'vi')
		{
			$tmp = $this->getByID($_GET['id']);
		}
		
		if ($_GET['id'] == false || $_GET['id'] == '' || $id_lang != null) {
			if($tmp==null){
				$last_id = $this->modelObj->insert($data);
				$result  = array(
					'status'  => true,
					'last_id' => $last_id,
				);
			}else{
				$this->modelObj->where('id_lang', $_GET['id']);
				$this->modelObj->where('idw', $this->idw);
				$this->modelObj->update($data);
				$result = array(
					'status'  => true,
					'last_id' => $id,
				);
			}
			
		} else {
			$id = $_GET['id'];
			$this->modelObj->where('id', $id);
			$this->modelObj->where('idw', $this->idw);
			$this->modelObj->update($data);
			$result = array(
				'status'  => true,
				'last_id' => $id,
			);
		}
		
		return $result;
	}

	/**
	 * [countMax description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-08-12
	 * @return [type]                     [description]
	 */
	public function countMax() {
		$data = $this->modelObj->where('idw', $this->idw)->orderBy('idblock', 'DESC')->getOne(null, 'idblock');
		if ($data['idblock'] == '') {
			return 0;
		} else {
			return $data['idblock'] + 1;
		}
	}

	/**
	 * [getAll description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @return [type]                     [description]
	 */
	public function getAll() {
		global $_B;
		$lang = $_GET['lang'];
		$total    = $this->getTotal();
		$per_page = 20;
		$page     = $this->request->get_int('p', 'GET');
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

		$this->modelObj->where('idw', $this->idw);
		$this->modelObj->where('type', 1);
		$this->modelObj->orderBy('id', 'DESC');
		$result_o       = $this->modelObj->get(null, $limit, '*');
		$result['data'] = $result_o;
		if($lang != 'vi'){
			foreach ($result['data'] as $key => $value) {
				$result['data'][$key]['id'] = $value['id_lang'];
			}
		}

		if ($total > $per_page) {
			$url                           = $_B['home'] . '/template-blockcustom-lang-' . $_GET['lang'];
			$result['pagination']          = pagination($per_page, $total, 5, $url);
			$result['pagination']['limit'] = $per_page;
		}

		return $result;

	}
	/**
	 * [getTotal description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @return [type]                     [description]
	 */
	private function getTotal() {
		$this->modelObj->where('idw', $this->idw);
		$this->modelObj->where('type', 1);
		$result = $this->modelObj->num_rows();
		return $result;
	}
	public function getByID($id) {
		$lang = $_GET['lang'];
		if($lang != 'vi'){
			$this->modelObj->where('id_lang', $id);
		}else
		{
			$this->modelObj->where('id', $id);
		}	
		$this->modelObj->where('idw', $this->idw);
		$this->modelObj->where('type', 1);
		$result = $this->modelObj->getOne(null, '*');
		return $result;

	}
	/**
	 * [getByIDTable description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @param  [type]                     $table [description]
	 * @param  [type]                     $id    [description]
	 * @return [type]                            [description]
	 */
	private function getByIDTable($table, $id) {
		$modelObjEn = new Model($table);
		$modelObjEn->where('id', $id);
		return $modelObjEn->getOne(null, '*');
	}
	/**
	 * [editPosition description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @return [type]                     [description]
	 */
	public function editPosition() {
		$id       = $this->request->get_int('pk', 'POST');
		$position = $this->request->get_int('value', 'POST');

		$data = array(
			'position' => $position,
		);
		$this->modelObj->where('idw', $this->idw);
		$this->modelObj->where('id', $id);
		$this->modelObj->where('type', 1);
		$this->modelObj->update($data);
		$result = array('status' => true);
		echo json_encode($result);
	}
	/**
	 * [activeStatus description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @return [type]                     [description]
	 */
	public function activeStatus() {
		$id     = $this->request->get_int('key', 'POST');
		$status = $this->request->get_int('status', 'POST');
		$data   = array(
			'status' => $status,
		);
		$this->modelObj->where('idw', $this->idw);
		$this->modelObj->where('id', $id);
		$this->modelObj->where('type', 1);
		$this->modelObj->update($data);
		$result = array('status' => true);
		echo json_encode($result);
	}
	/**
	 * [editSort description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @return [type]                     [description]
	 */
	public function editSort() {
		$id   = $this->request->get_int('pk', 'POST');
		$sort = $this->request->get_int('value', 'POST');
		$data = array(
			'sort' => $sort,
		);
		$this->modelObj->where('idw', $this->idw);
		$this->modelObj->where('id', $id);
		$this->modelObj->where('type', 1);
		$this->modelObj->update($data);

		$result = array('status' => true);
		echo json_encode($result);
	}
	/**
	 * [editTitle description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @return [type]                     [description]
	 */
	public function editTitle() {
		$id    = $this->request->get_int('pk', 'POST');
		$title = $this->request->get_string('value', 'POST');
		$data  = array(
			'title' => $title,
		);

		$this->modelObj->where('idw', $this->idw);
		$this->modelObj->where('id', $id);
		$this->modelObj->where('type', 1);
		$this->modelObj->update($data);

		$result = array('status' => true);
		echo json_encode($result);
	}
	/**
	 * [deleteBlock description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @return [type]                     [description]
	 */
	public function deleteBlock() {
		$lang = $this->request->get_string('lang', 'POST');
		$id   = $this->request->get_int('key', 'POST');
		$this->modelObj->where('idw', $this->idw);
		if ($lang!='vi') {
			$this->modelObj->where('id_lang', $id);
		}else{
			$this->modelObj->where('id', $id);
		}
		
		//$this->modelObj->where('type', 1);
		$this->modelObj->delete();

		return json_encode(array('status' => true));
	}
	/**
	 * [deleteMuti description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @return [type]                     [description]
	 */
	public function deleteMuti() {
		$lang = $this->request->get_string('lang', 'POST');
		$id   = $this->request->get_array('id', 'POST');
		$this->modelObj->where('idw', $this->idw);
		$this->modelObj->where('id', $id, 'IN');
		$this->modelObj->where('type', 1);
		$this->modelObj->delete($data);

		return json_encode(array('status' => true));
	}
}
