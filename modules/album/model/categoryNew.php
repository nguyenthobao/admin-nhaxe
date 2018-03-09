<?php
/**
 * @Project BNC v2 -> Admin -> Album
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

/**
 * add category model
 */
class categoryNew extends Album {
	/*
	 * insert data param
	 */
	public $title;
	public $contents_description;
	public $avatar;
	public $icon;
	public $bg_image;
	public $status;
	public $create_time;
	public $meta_title;
	public $meta_keywords;
	public $meta_description;
	public $order_by;
	public $parent_id;
	public $alias;
	public $is_home;
	/*
	 * them danh muc
	 */
	public function addCategory() {
		$this->objTable = new Model($this->getLangAndID['lang'] . '_album_category');

		$data = array(
			'idw'                  => $this->idw,
			'title'                => $this->title,
			'contents_description' => $this->contents_description,
			'avatar'               => $this->avatar,
			'icon'                 => $this->icon,
			'bg_image'             => $this->bg_image,
			'status'               => $this->status,
			'create_uid'           => $this->B['uid'],
			//'update_uid'           => 0,
			'create_time'          => $this->create_time,
			                               //'update_time'          => 0,
			                               //'id_lang'              => 0,
			'meta_title'           => $this->meta_title,
			'meta_keywords'        => $this->meta_keywords,
			'meta_description'     => $this->meta_description,
			//'views'                => 0,
			'order_by'             => $this->order_by,
			'parent_id'            => $this->parent_id,
			'alias'                => $this->alias,
			'is_home'              => $this->is_home,
			'num_show'              => $this->limit,
		);

		$return['last_id'] = $this->objTable->insert($data); //insert data

		if ($return['last_id']) {
			$return['status'] = true;
		} else {
			$return['status'] = false;
			$return['error']  = $this->objTable->getLastError();
		}

		return $return;

	}

}
