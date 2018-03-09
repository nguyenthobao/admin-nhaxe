<?php
/**
 *
 */
class Model_Tags {

	function __construct() {
		global $_B;
		$this->idw   = $_B['web']['idw'];
		$this->db    = db_connect('seo');
		$this->model = new Model('tags', $this->db);

	}
	/**
	 * [getList description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-05-29
	 * @param  [type]                     $page     [description]
	 * @param  integer                    $per_page [description]
	 * @return [type]                               [description]
	 */
	public function getList($page, $per_page = 30) {
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

		$total = $this->total();

		$this->model->where('idw', $this->idw);
		$this->model->orderBy('id', 'DESC');
		$result['tags'] = $this->model->get(null, $limit, '*');

		if ($total > $per_page) {
			$url                           = 'seo-tags-lang-' . $_GET['lang'];
			$result['pagination']          = pagination($per_page, $total, 5, $url);
			$result['pagination']['limit'] = $per_page;
		}

		return $result;
	}
	/**
	 * [total description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-05-29
	 * @return [type]                     [description]
	 */
	public function total() {
		$this->model->where('idw', $this->idw);
		return $this->model->num_rows();
	}
	/**
	 * [deleteTags description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-05-29
	 * @param  [type]                     $tag_id [description]
	 * @return [type]                             [description]
	 */
	public function deleteTags($tag_id) {
		$this->model->where('idw', $this->idw);
		$this->model->where('id', $tag_id);
		return $this->model->delete();

	}
	/**
	 * [updateTags description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-05-29
	 * @param  [type]                     $data   [description]
	 * @param  [type]                     $tag_id [description]
	 * @return [type]                             [description]
	 */
	public function updateTags($data, $tag_id) {
		$this->model->where('idw', $this->idw);
		$this->model->where('id', $tag_id);
		return $this->model->update($data);
	}

}