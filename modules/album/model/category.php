<?php
/**
 * @Project BNC v2 -> Admin -> Album
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

/**
 * category list model
 */
class category extends Album {
	/*
	 * get list param
	 */
	public $id;
	public $title;
	public $status;
	public $search;
	public $start       = 0;
	public $max_rec     = 10; //num rec
	public $num_display = 5; //paging
	public $url;
	public $paging;

	// Get category list
	public function getList() {
		$db             = db_connect('album');
		$this->objTable = new Model($this->getLangAndID['lang'] . '_album_category', $db);
		$select         = array('id', 'id_lang', 'title', 'parent_id', 'status', 'order_by');

		/*/paging
		$this->objTable->where('idw',$this->idw);
		if($this->search){
		if($this->title!='') $this->objTable->where('title','%'.$this->title.'%','LIKE');
		if($this->status!='') $this->objTable->where('status',$this->status);
		}

		$total = $this->objTable->num_rows();
		$page = pagination($this->max_rec, $total, $this->num_display, $this->url);
		$this->start = $page['start'];
		$this->paging = $page['pagination'];
		/array($this->start,$this->max_rec)/paging end*/

		$this->objTable->where('idw', $this->idw);
		if ($this->search) {
			if ($this->title != '') {
				$this->objTable->where('title', '%' . $this->title . '%', 'LIKE');
			}

			if ($this->status != '') {
				$this->objTable->where('status', $this->status);
			}

		}

		$this->objTable->orderBy('id', 'DESC');
		$data = $this->objTable->get(null, null, $select);

		if ($this->getLangAndID['lang'] != $this->lang) {
			foreach ($data as $k => $v) {
				$v['id']  = $v['id_lang'];
				$data[$k] = $v;
			}
		}

		$result = $this->getCategory($data);
		if ($result) {
			return $result;
		}
	}

	/**
	 * Get category
	 *
	 * @param $data|array
	 * @param $parent|int
	 * @param $space|string
	 *
	 * @return Array
	 *
	 */
	protected function getCategory($data = array(), $parent = 0, $space = '') {
		$current = array();
		if (is_array($data)) {
			foreach ($data as $key => $val) {
				if ($val['parent_id'] == $parent) {
					$current[] = $val;
					unset($data[$key]);
				}
			}
		}
		if (sizeof($current) > 0) {
			foreach ($current as $k => $v) {
				$current[$k]['title'] = $v['title'];
				$current[$k]['space'] = $space . " ";
				$current[$k]['sub']   = $this->getCategory($data, $v['id'], $space . '--');
			}
		}
		return $current;
	}

}
