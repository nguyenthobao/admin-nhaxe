<?php
/**
 * @Project BNC v2 -> Admin -> Album
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

/**
 * add album model
 */
class albumNew extends Album {
	/*
	 * album param
	 */
	public $title;
	public $contents_description;
	public $avatar;
	public $avatar_id;
	public $category_id;
	public $status;
	public $create_time;
	public $meta_title;
	public $meta_keywords;
	public $meta_description;
	public $tags;
	public $order_by;
	public $post_time;
	public $related;
	public $related_cate;
	public $id;
	public $not_in;
	public $album_vip;
	public $album_hot;
	public $alias;

	/*
	 * luu allbum
	 */
	public function addAlbum() {
		$return['status'] = false;
		$return['error']  = 'empty';
		if (!empty($this->title)) {
			$data = array(
				'idw'                  => $this->idw,
				'title'                => $this->title,
				'contents_description' => $this->contents_description,
				'avatar'               => $this->avatar,
				'avatar_id'            => $this->avatar_id,
				'category_id'          => $this->category_id,
				'status'               => $this->status,
				'create_uid'           => $this->B['uid'],
				//'update_uid'           => 0,
				'create_time'          => $this->create_time,
				'album_hot'            => $this->album_hot,
				'album_vip'            => $this->album_vip,
				                               //'update_time'          => 0,
				                               //'id_lang'              => $this->id_lang,
				'meta_title'           => $this->meta_title,
				'meta_keywords'        => $this->meta_keywords,
				'meta_description'     => $this->meta_description,
				//'views'                => 0,
				'tags'                 => $this->tags,
				'order_by'             => $this->order_by,
				'post_time'            => ($this->post_time != '' ? $this->post_time : 0), //$this->post_time,
				'related'              => $this->related,
				'related_cate'         => $this->related_cate,
				'alias'                => $this->alias,
			);

			//kiem tra trang thai danh muc
			if ($this->checkCateStatusHide($this->arr)) {
				$data['hide_by_cate'] = '1';
			}

			$this->objTable    = new Model($this->getLangAndID['lang'] . '_album');
			$return['last_id'] = $result = $this->objTable->insert($data); //insert data

			if ($return['last_id']) {
				$this->idAlbumOfPic($return['last_id'], $this->tmp_id);
				$this->setAvatar($this->avatar_id);
				$return['status'] = true;
			} else {
				$return['status'] = false;
				$return['error']  = $this->objTable->getLastError();
			}
		}

		return $return;
	}

	/*
	 * cap nhat id album cho anh
	 */
	public function idAlbumOfPic($album_id, $tmp_id) {
		$this->objTable = new Model($this->lang . '_album_images');
		$data           = array(
			'album_id' => $album_id,
		);
		$this->objTable->where('idw', $this->idw);
		$this->objTable->where('tmp_id', $tmp_id);
		$this->objTable->update($data);
	}
	/*
	 * cap nhat id album cho anh
	 */
	public function setAvatar($avatar_id) {
		$this->objTable = new Model($this->lang . '_album_images');
		$data           = array(
			'avatar' => 1,
		);
		$this->objTable->where('idw', $this->idw);
		$this->objTable->where('id', $avatar_id);
		$this->objTable->update($data);
	}

	public function getConfig() {
		$oBj = new Model('vi_config');
		$oBj->where('idw', $this->idw);
		return $oBj->getOne();
	}
	/************************TAGS*********************/
	public function addTags($tag) {
		global $_B;
		//Check exist tag
		$check = $this->checkExistTag($tag);
		if ($check != false) {
			return $check;
		} else {
			$db    = db_connect('seo');
			$tagDb = new Model('tags', $db);
			$data  = array(
				'idw'   => $_B['web']['idw'],
				'tag'   => $tag,
				'alias' => fixTitle($tag),
			);
			return $tagDb->insert($data);
		}

	}
	public function getTagName($tag_id) {
		global $_B;
		$db    = db_connect('seo');
		$tagDb = new Model('tags', $db);
		$tagDb->where('idw', $_B['web']['idw']);
		$tagDb->where('id', $tag_id);
		$result = $tagDb->getOne(null, 'tag');
		if (count($result) != 0) {
			return $result['tag'];
		} else {
			return false;
		}
	}
	private function checkExistTag($tag) {
		global $_B;
		$db    = db_connect('seo');
		$tagDb = new Model('tags', $db);
		$tagDb->where('idw', $_B['web']['idw']);
		$tagDb->where('tag', $tag);
		$result = $tagDb->getOne(null, 'id');
		if (count($result) != 0) {
			return $result['id'];
		} else {
			return false;
		}

	}
	/************************END TAGS*********************/
}