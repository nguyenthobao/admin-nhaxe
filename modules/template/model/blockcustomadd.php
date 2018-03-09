<?php
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
class Blockcustomadd {
	public $request, $idw, $lang, $modelObj;
	public function __construct() {
		global $_B;
		$this->request = $_B['r'];
		$this->idw     = $_B['web']['idw'];
		$this->lang    = $_B['cf']['lang'];
		//$this->modelObj = new Model($this->lang . '_blockcustom');
		$this->modelObj = new Model($this->lang . '_block');
	}

	public function addBlockcustom() {
		global $_B;
		if (isset($_COOKIE['truong'])) {
			echo '<pre>';
			print_r($this->lang);
			echo '</pre>';
			die();
		}
		
		$title      = $this->request->get_string('title', 'POST');
		$html       = $this->request->get_string('html', 'POST');
		$css        = $this->request->get_string('css', 'POST');
		$sort       = $this->request->get_int('sort', 'POST');
		$position   = $this->request->get_string('position', 'POST');
		$status     = $this->request->get_int('status', 'POST');
		$active_mod = $this->request->get_array('active_mod', 'POST');
		$content    = array(
			'css'  => @$css,
			'html' => @$html,
		);
		if (count($active_mod) == count($mod_in_home)) {
			$active_mod = ',all,';
		} else {
			$active_mod = ',' . implode(',', $active_mod) . ',';
		}

		$data = array(
			'idw'          => $this->idw,
			'title'        => $title,
			// 'html'        => $html,
			// 'css'         => $css,
			'sort'         => $sort,
			'position'     => $position,
			'status'       => $status,
			'create_time'  => time(),
			'active_mod'   => $active_mod,
			'type'         => 1,
			'data_custome' => json_encode($content),
		);
		
		$this->modelObj->insert($data);
		$result = array(
			'status' => true,
		);
		return $result;
	}
}