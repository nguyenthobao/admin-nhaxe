<?php
/**
 * @Project BNC v2 -> Admin -> Album
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

/**
 * update category model
 */
class categoryUpdate extends Album {
	/*
	 * update data param
	 */
	public $id;
	public $title;
	public $contents_description;
	public $avatar;
	public $icon;
	public $bg_image;
	public $status;
	public $update_time;
	public $meta_title;
	public $meta_keywords;
	public $meta_description;
	public $order_by;
	public $parent_id;
	public $get_lang;

	public $avatar_check;
	public $icon_check;
	public $bg_image_check;
	public $alias;
	public $is_save;
	public $title_alias;
	public $is_home;

	/*
	 * update category
	 */
	public function updateCategory() {
		$this->objTable = new Model($this->getLangAndID['lang'] . '_album_category');

		if ($this->getLangAndID['lang'] != $this->lang) {
			$id_lang   = $this->id;
			$parent_id = $this->getParentID();
		} else {
			$id_lang   = 0;
			$parent_id = $this->parent_id;
		}

		$data = array(
			'idw'                  => $this->idw,
			'title'                => $this->title,
			'contents_description' => $this->contents_description,
			                               //'avatar'               => $this->avatar,
			                               //'icon'                 => $this->icon,
			                               //'bg_image'             => $this->bg_image,
			'status'               => $this->status,
			//'create_uid'           => $this->B['uid'],
			'update_uid'           => $this->B['uid'],
			                               //'create_time'          => $this->create_time,
			'update_time'          => $this->update_time,
			'meta_title'           => $this->meta_title,
			'meta_keywords'        => $this->meta_keywords,
			'meta_description'     => $this->meta_description,
			'order_by'             => $this->order_by,
			'id_lang'              => $id_lang,
			'parent_id'            => $parent_id,
			'is_home'              => $this->is_home,
			'num_show'              => $this->limit,
		);
		if ($this->is_save == "on") {
			$data['alias'] = $this->alias;
		} else {
			$data['alias'] = $this->title_alias;
		}
		if (!empty($this->avatar) || $this->avatar_check == 'remove') {
			$data['avatar'] = $this->avatar;
		}
		if (!empty($this->icon) || $this->icon_check == 'remove') {
			$data['icon'] = $this->icon;
		}
		if (!empty($this->bg_image) || $this->bg_image_check == 'remove') {
			$data['bg_image'] = $this->bg_image;
		}

		if (!empty($this->id)) {

			$this->objTable->where($this->getLangAndID['field_id'], $this->id);
			$this->objTable->where('idw', $this->idw);
			$result = $this->objTable->update($data);

			//an album
			$this->hideByCate($this->id, $this->status);
			/*
			 * ap dung cho tat ca danh muc con
			 */
			if ($this->status != 1) {
				$this->getChildCate($this->id);
				if (!empty($this->arr)) {
					foreach ($this->arr as $v) {
						$this->objTable = new Model($this->getLangAndID['lang'] . '_album_category');
						$data           = array(
							'status'      => $this->status,
							'update_uid'  => $this->B['uid'],
							'update_time' => $this->update_time,
						);
						$this->objTable->where('id', $v);
						$this->objTable->where('idw', $this->idw);
						$this->objTable->update($data);
						//an album
						$this->hideByCate($v, $this->status);
						//an tat ca ngon ngu khac
						if ($this->status == 0 && $this->getLangAndID['lang'] == $this->lang) {
							$this->applyAllLang($data, $this->id, 'update', '_album_category');
						}

					}
					$return['ids'] = implode(",", $this->arr);
				}
			}

			if ($this->getLangAndID['lang'] == $this->lang) {
				//Update lại parent_id nếu sửa bản ghi tiếng việt
				$data = array(
					'parent_id' => $parent_id,
				);
				//function fixParentCat($data,$id,$action)
				//@param1 : mảng truyền vào xử lý
				//@param2: id
				//@param3: action truyền vào để xử lý theo yêu cầu. VD: delete,update
				$this->fixParentCat($data, $this->id, 'update');
			} else {
				//Kiểm tra xem bản ghi đã tồn tại bên ngôn ngữ này chưa.
				//True : update
				//false: insert
				$checkExist = $this->checkExist($this->id, $this->getLangAndID['lang'], '_album_category');
				if ($checkExist == true) {
					$this->objTable->where($this->getLangAndID['field_id'], $this->id);
					$this->objTable->where('idw', $this->idw);
					$result = $this->objTable->update($data);
				} else {
					$result = $this->objTable->insert($data);
				}
			}
		}

		if ($this->getLangAndID['lang'] != $this->lang) {
			$return['last_id'] = $this->id;
		} else {
			$return['last_id'] = $result;
		}

		if ($result) {
			$return['status'] = true;
		} else {
			$return['status'] = false;
			$return['error']  = $this->objTable->getLastError();
		}

		return $return;

	}

/*
 * get image category
 */
	public function getAvatar() {
		$this->objTable = new Model($this->lang . '_album_category');
		$select         = array('avatar', 'icon', 'bg_image');
		$this->objTable->where('id', $this->id);
		$this->objTable->where('idw', $this->idw);
		$result = $this->objTable->getOne(null, $select);

		if ($result) {
			return $result;
		}
	}

/*
 * get one category
 */
	public function getCategoryItem() {
		if (!$this->safeUpdate()) {
			return 'errorUpdate';
		}

		$this->objTable = new Model($this->getLangAndID['lang'] . '_album_category');
		$this->objTable->where($this->getLangAndID['field_id'], $this->id);
		$this->objTable->where('idw', $this->idw);
		$result = $this->objTable->getOne();
		//Xử lý nếu danh mục cha chưa có tiếng anh.
		$parent_id = $this->getParentID();
		if ($parent_id != 0 && $this->getLangAndID['lang'] != $this->lang) {
			$this->objTable = new Model($this->getLangAndID['lang'] . '_album_category');
			$this->objTable->where('id_lang', $parent_id);
			$this->objTable->where('idw', $this->idw);
			$checkExist = $this->objTable->num_rows();
			if ($checkExist == 0) {
				return 'notTranslate';
			}
		}

		if ($result) {
			return $result;
		}
	}
	protected function getParentID() {
		$id = $this->id;

		$this->objTable = new Model($this->lang . '_album_category');
		$select         = array('parent_id');
		$this->objTable->where('id', $id);
		$this->objTable->where('idw', $this->idw);
		$result = $this->objTable->getOne(null, $select);
		if ($result) {
			return $result['parent_id'];
		}
	}
	protected function safeUpdate() {
		$id = $this->id;
		if ($this->get_lang) {
			$this->objTable = new Model($this->lang . '_album_category');
			$select         = array('id');
			$this->objTable->where('id', $id);
			$this->objTable->where('idw', $this->idw);
			$result = $this->objTable->getOne(null, $select);
			if ($result) {
				return $result['id'];
			}
		}
	}

}
