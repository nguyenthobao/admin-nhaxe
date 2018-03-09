<?php
/**
 * @Project BNC v2 -> Admin -> Album
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

/**
 * update album model
 */
class albumUpdate extends Album {
	/*
	 * album param
	 */
	public $id;
	public $title;
	public $contents_description;
	public $avatar;
	public $avatar_id;
	public $category_id;
	public $status;
	public $update_time;
	public $meta_title;
	public $meta_keywords;
	public $meta_description;
	public $tags;
	public $order_by;
	public $post_time;
	public $id_lang;
	public $get_lang;
	public $related;
	public $related_cate;
	public $not_in;
	public $album_hot;
	public $album_vip;
	public $alias;
	public $is_save;
	public $title_alias;

	/*
	 * luu allbum
	 */
	public function updateAlbum() {
		$db               = db_connect('album');
		$return['status'] = false;
		$return['error']  = 'empty';
		if ($this->getLangAndID['lang'] != $this->lang) {
			$id_lang = $this->id;
		} else {
			$id_lang = '';
		}
		if (!empty($this->title)) {
			$data = array(
				'idw'                  => $this->idw,
				'title'                => $this->title,
				'contents_description' => $this->contents_description,
				'avatar'               => $this->avatar,
				'avatar_id'            => $this->avatar_id,
				'category_id'          => $this->category_id,
				'status'               => $this->status,
				'album_hot'            => $this->album_hot,
				'album_vip'            => $this->album_vip,
				                               //'create_uid'           => $this->B['uid'],
				'update_uid'           => $this->B['uid'],
				//'create_time'          => $this->create_time,
				'update_time'          => $this->update_time,
				                               //'id_lang'              => $id_lang,
				'meta_title'           => $this->meta_title,
				'meta_keywords'        => $this->meta_keywords,
				'meta_description'     => $this->meta_description,
				//'views'                => 0,
				'tags'                 => $this->tags,
				'order_by'             => $this->order_by,
				'post_time'            => ($this->post_time != '' ? $this->post_time : 0),
				'related'              => $this->related,
				'related_cate'         => $this->related_cate,
			);
			if ($this->is_save == "on") {
				$data['alias'] = $this->alias;
			} else {
				$data['alias'] = $this->title_alias;
			}
			if ($id_lang) {
				$data['id_lang'] = $id_lang;
			}

			//kiem tra trang thai danh muc
			if ($this->checkCateStatusHide($this->arr)) {
				$data['hide_by_cate'] = '1';
			} else {
				$data['hide_by_cate'] = '0';
			}
			$this->objTable = new Model($this->getLangAndID['lang'] . '_album', $db);
			/*
			if(!empty($this->id)){
			$this->objTable->where($this->getLangAndID['field_id'],$this->id);
			$this->objTable->where('idw',$this->idw);
			$result = $this->objTable->update($data);
			}
			 */
			//Kiểm tra xem bản ghi đã tồn tại bên ngôn ngữ này chưa.
			//True : update
			//false: insert
			$checkExist = $this->ifExist($this->id, $this->getLangAndID['lang'], '_album');
			if ($checkExist == true) {
				$this->objTable->where($this->getLangAndID['field_id'], $this->id);
				$this->objTable->where('idw', $this->idw);

				$result = $this->objTable->update($data);
				//$return['last_id'] = $this->id;
				$data = array(
					'category_id' => $this->category_id,
				);
				$this->applyAllLang($data, $this->id, 'update'); //
			} else {
				$result = $this->objTable->insert($data);
			}

			$return['last_id'] = $this->id;

			if ($result) {
				$this->updateAvatar($this->avatar_id, $this->id);
				$return['status'] = true;
			} else {
				$return['status'] = false;
				$return['error']  = $this->objTable->getLastError();
			}
		}
		return $return;
	}

	/*
	 * get images album
	 */
	public function getImages() {
		$res            = array();
		$db             = db_connect('album');
		$this->objTable = new Model($this->getLangAndID['lang'] . '_album_images', $db);
		$select         = array('id', 'title', 'description', 'album_id', 'src_link', 'order_by', 'avatar');
		$this->objTable->where('album_id', $this->id);
		$this->objTable->where('idw', $this->idw);
		$this->objTable->orderBy('order_by', 'ASC');
		$data = $this->objTable->get(null, null, $select);
		/*
		foreach($data as $v){
		$result['id']=$v['id'];
		//$result['title']=$data['title'];
		//$result['description']=$data['description'];
		$result['album_id']=$v['album_id'];
		$result['src_link']=$v['src_link'];
		$result['order_by']=$v['order_by'];
		$result['avatar']=$v['avatar'];
		$imageLang=$this->getImagesLang($v['id']);
		if($imageLang){
		$result['title']=$imageLang['title'];
		$result['description']=$imageLang['description'];
		}else{
		$result['title']='';
		$result['description']='';
		}
		array_push($res, $result);
		}

		if($this->getLangAndID['lang']!=$this->lang){
		return $res;
		}else{
		return $data;
		}*/

		return $data;
	}
	//
	public function getImagesLang($id) {
		$db             = db_connect('album');
		$this->objTable = new Model($this->getLangAndID['lang'] . '_album_images', $db);
		$select         = array('title', 'description');
		$this->objTable->where('id_lang', $id);
		$this->objTable->where('idw', $this->idw);
		$result = $this->objTable->getOne(null, $select);
		if ($result) {
			return $result;
		}
	}

	/*
	 * get one album
	 */
	public function getAlbumItem() {
		if (!$this->safeUpdate()) {
			return 'errorUpdate';
		}
		$db             = db_connect('album');
		$this->objTable = new Model($this->getLangAndID['lang'] . '_album', $db);
		$this->objTable->where($this->getLangAndID['field_id'], $this->id);
		$this->objTable->where('idw', $this->idw);
		$result = $this->objTable->getOne();
		//if($this->checkPostTime($result['post_time']))
		//$result['post_time']='';

		if ($result) {
			$result['category_id'] = array_filter(explode(',', $result['category_id']));
			return $result;
		}
	}
	public function category_id() // id of df
	{
		$db = db_connect('album');
		if ($this->getLangAndID['lang'] != $this->lang) {
			$this->objTable = new Model($this->lang . '_album', $db);
			$select         = array('category_id');
			$this->objTable->where('idw', $this->idw);
			$this->objTable->where('id', $this->id);
			$result = $this->objTable->getOne(null, $select);
			if ($result) {
				$result['category_id'] = array_filter(explode(',', $result['category_id']));
				return $result['category_id'];
			}
		}
	}

	/*
	 * safe update
	 */
	protected function safeUpdate() {
		$id = $this->id;
		$db = db_connect('album');
		if ($this->get_lang) {
			$this->objTable = new Model($this->lang . '_album', $db);
			$select         = array('id');
			$this->objTable->where('id', $id);
			$this->objTable->where('idw', $this->idw);
			$result = $this->objTable->getOne(null, $select);
			if ($result) {
				return $result['id'];
			}
		}
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