<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/category.php
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/17/2014, 10:14 AM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
class News extends GlobalNews {
	public $idw, $catNewObj, $catNewObjvi, $r, $lang, $newsObj, $newsRelated;
	private $uid;
	public function __construct() {
		global $_B;
		$this->r    = $_B['r'];
		$this->idw  = $_B['web']['idw'];
		$this->lang = $_B['cf']['lang'];
	}

	public function addNews() {
		global $_B;
		$getLangAndID  = getLangAndID();
		$db            = db_connect('news');
		$this->newsObj = new Model($getLangAndID['lang'] . '_news', $db);
		//POST news vip
		if ($this->r->get_string('news_vip', 'POST') == 'on') {
			$is_vip = 1;
		} else {
			$is_vip = 0;
		}
		//POST news hot
		if ($this->r->get_string('news_hot', 'POST') == 'on') {
			$is_hot = 1;
		} else {
			$is_hot = 0;
		}

        //POST news travel
        if ($this->r->get_string('news_travel', 'POST') == 'on') {
            $is_travel = 1;
        } else {
            $is_travel = 0;
        }

		$id_cat = $this->r->get_array('cat_name', 'POST');
		$cat_id = ',' . implode(',', $id_cat) . ',';

		$related_id   = $this->r->get_array('related_id', 'POST');
		$related_news = ',' . implode(',', $related_id) . ',';

		$news_id = $this->r->get_int('id');

		$id_lang = null;
		if ($getLangAndID['lang'] != 'vi') {
			$id_lang = $this->r->get_int('id');
			$news_id = $this->r->get_int('id_lang');
		}
		if ($this->r->get_string('chk_cat_related', 'POST') == 'on') {
			$tin_danh_muc = array(
				'news_id'       => $news_id,
				'status'        => $this->r->get_string('chk_cat_related', 'POST'),
				'show_quantity' => $this->r->get_string('show_quantity', 'POST'),
				'show_sort'     => $this->r->get_string('show_sort', 'POST'),
				'show_type'     => $this->r->get_string('show_type', 'POST'),
				'show_news'     => $this->r->get_string('show_news', 'POST'),
			);
			$config_news_cat = json_encode($tin_danh_muc);
		}
		if ($this->r->get_string('chk_news_related', 'POST') == 'on') {
			$tin_lien_quan = array(
				'news_id'       => $news_id,
				'status'        => $this->r->get_string('chk_news_related', 'POST'),
				'show_quantity' => $this->r->get_string('show_quantity_1', 'POST'),
				'show_sort'     => $this->r->get_string('show_sort_1', 'POST'),
				'show_type'     => $this->r->get_string('show_type_1', 'POST'),
				'show_news'     => $this->r->get_string('show_news_1', 'POST'),
			);
			$config_news_related = json_encode($tin_lien_quan);
		}

		$date_time_up = $this->r->get_string('time_up', 'POST');
		$date_time    = str_replace("/", "-", $date_time_up);
		$time_up      = strtotime($date_time);
		if ($time_up != 0) {
			$status = 2;
		} else {
			$status = $this->r->get_int('status', 'POST');
		}
		$str   = strip_tags($this->r->get_string('title', 'POST'));
		$title = trim($str);

		if ($title != '') {
			//START UPLOAD
			include DIR_HELPER_UPLOAD;
			$options = array('max_size' => 1600);
			$upload  = new BncUpload($options);
			$up_img  = $upload->upload($this->idw, 'news', 'img_news');
			//END UPLOAD
			//Tags
			$tags = explode(',', $this->r->get_string('tags', 'POST'));
			if (is_array($tags) == true) {
				$tag_id = ',';
				foreach ($tags as $k => $v) {
					$tag_id .= $this->addTags($v) . ',';
				}
			} else {
				$tag_id = '';
			}

			$data = array(
				'idw'                 => $this->idw,
				'id_lang'             => $id_lang,
				'cat_id'              => $cat_id,
				'img'                 => $up_img,
				'title'               => $title,
				'short'               => $this->r->get_string('description', 'POST'),
				'alias'               => fixTitle($this->r->get_string('alias', 'POST')),
				'details'             => $this->r->get_string('content', 'POST'),
				'create_uid'          => $_B['uid'],
				'sort'                => $this->r->get_int('sort', 'POST'),
				'author'              => $this->r->get_string('author', 'POST'),
				'news_source'         => $this->r->get_string('news_source', 'POST'),
                'label_name'          => $this->r->get_string('label_name', 'POST'),
				'tags'                => $tag_id,
				'create_time'         => time(),
				'meta_title'          => $this->r->get_string('meta_title', 'POST'),
				'meta_keyword'        => $this->r->get_string('meta_keyword', 'POST'),
				'meta_description'    => $this->r->get_string('meta_description', 'POST'),
				'is_vip'              => $is_vip,
				'is_hot'              => $is_hot,
				'is_travel'           => $is_travel,
				'related_news'        => $related_news,
				'config_news_cat'     => $config_news_cat,
				'config_news_related' => $config_news_related,
				'status'              => $status,
				'time_up'             => $time_up,
			);
		} else {
			return false;
		}
		if (isset($_POST['img_news']) && $_POST['img_news'] == "1") {
			unset($data['img']);
		}
		//Kiểm tra xem nếu tồn tại id thì update, nếu không thì insert
		$id = $this->r->get_int('id', 'GET');

		if (!empty($id)) {
			if ($this->r->get_string('is_save', 'POST') == 'on') {
				$str_alias = $this->r->get_string('alias', 'POST');
			} else {
				$str_alias = $this->r->get_string('title_alias', 'POST');
			}
			//Tags
			$tags = explode(',', $this->r->get_string('tags', 'POST'));
			if (is_array($tags) == true) {
				$tag_id = ',';
				foreach ($tags as $k => $v) {
					$tag_id .= $this->addTags($v) . ',';
				}
			} else {
				$tag_id = '';
			}
			$data = array(
				'idw'                 => $this->idw,
				'id_lang'             => $id_lang,
				'cat_id'              => $cat_id,
				'img'                 => $up_img,
				'title'               => $title,
				'alias'               => fixTitle($str_alias),
				'short'               => $this->r->get_string('description', 'POST'),
				'details'             => $this->r->get_string('content', 'POST'),
				'update_uid'          => $_B['uid'],
				'sort'                => $this->r->get_int('sort', 'POST'),
				'author'              => $this->r->get_string('author', 'POST'),
				'news_source'         => $this->r->get_string('news_source', 'POST'),
				'label_name'          => $this->r->get_string('label_name', 'POST'),
                'original_price'      => $this->r->get_float('original_price', 'POST'),
                'sale_price'          => $this->r->get_float('sale_price', 'POST'),
                'description1'        => $this->r->get_string('description1', 'POST'),
                'description2'        => $this->r->get_string('description2', 'POST'),
                'description3'        => $this->r->get_string('description3', 'POST'),

				'tags'                => $tag_id,
				'update_time'         => time(),
				'meta_title'          => $this->r->get_string('meta_title', 'POST'),
				'meta_keyword'        => $this->r->get_string('meta_keyword', 'POST'),
				'meta_description'    => $this->r->get_string('meta_description', 'POST'),
				'is_vip'              => $is_vip,
				'is_hot'              => $is_hot,
				'is_travel'           => $is_travel,
				'related_news'        => $related_news,
				'config_news_cat'     => $config_news_cat,
				'config_news_related' => $config_news_related,
				'status'              => $status,
				'time_up'             => $time_up,
			);

			if (isset($_POST['img_news']) && $_POST['img_news'] == "1") {
				unset($data['img']);
			}
			$this->newsObj->where($getLangAndID['field_id'], $id);
			$this->newsObj->where('idw', $this->idw);
			$result = $this->newsObj->update($data);
			if ($getLangAndID['lang'] == 'vi') {
				//Update lại parent_id nếu sửa bản ghi tiếng việt
				$data = array(
					'id_lang' => $id,
				);
				//function fixParentCat($data,$id,$action)
				//@param1 : mảng truyền vào xử lý
				//@param2: id
				//@param3: action truyền vào để xử lý theo yêu cầu. VD: delete,update
				$this->fixNewsID($data, $id, 'update');
			} else {
				//Kiểm tra xem bản ghi đã tồn tại bên ngôn ngữ này chưa.
				//True : update
				//false: insert
				$checkExistNews = $this->checkExistNews($id, $getLangAndID['lang']);
				if ($checkExistNews == true) {
					$this->newsObj->where($getLangAndID['field_id'], $id);
					$this->newsObj->where('idw', $this->idw);
					$result = $this->newsObj->update($data);
				} else {
					$result = $this->newsObj->insert($data);
				}
			}
		} else {
			$result = $this->newsObj->insert($data);
		}
		if (!empty($id)) {
			$return['last_id'] = $id;
		} else {
			$return['last_id'] = $result;
		}
		if ($result) {
			$return['status'] = true;
		} else {
			$return['status'] = false;
			$return['error']  = $this->newsObj->getLastError();
		}
		return $return;
	}

	//get News
	public function getNewsID() {
		$id            = $this->r->get_int('id', 'get');
		$db            = db_connect('news');
		$this->newsObj = new Model('vi_news', $db);
		//$select = array('id');
		$this->newsObj->where('id', $id);
		$this->newsObj->where('idw', $this->idw);
		$result = $this->newsObj->getOne();

		$result['cat_id'] = explode(',', $result['cat_id']);
		return $result;
	}
	public function getNewsIds($ids, $op = array()) {
		$getLangAndID = getLangAndID();
		$ids          = explode(',', $ids);
		foreach ($ids as $k => $v) {
			if (!empty($v)) {
				$id[] = $v;
			}
		}
		$db            = db_connect('news');
		$this->newsObj = new Model($getLangAndID['lang'] . '_news', $db);
		$this->newsObj->where('idw', $this->idw);
		$this->newsObj->where($getLangAndID['field_id'], $ids, 'IN');
		$select = array('id', 'id_lang', 'title', 'img');
		$result = $this->newsObj->get(null, array(0, 10), $select);
		return $result;
	}

	public function getNewsRelated($table) {
		$id                = $this->r->get_int('id', 'GET');
		$this->newsRelated = new Model($table);
		$this->newsRelated->where('news_id', $id);
		$this->newsRelated->where('idw', $this->idw);
		$result = $this->newsRelated->getOne();
		if ($result) {
			return $result;
		}
	}
	public function searchRelatedNews() {
		global $_B;
		$id            = $this->r->get_int('idsearch');
		$str_news      = '';
		$other         = $this->r->get_array('key', 'POST');
		$text          = $this->r->get_string('text', 'POST');
		$getLangAndID  = getLangAndID();
		$db            = db_connect('news');
		$this->newsObj = new Model($getLangAndID['lang'] . '_news', $db);
		$select        = array('id', 'id_lang', 'title', 'img');
		$this->newsObj->where('title', '%' . $text . '%', 'like');
		$this->newsObj->where('idw', $this->idw);
		$this->newsObj->where('status', 1);
		$row = $this->newsObj->get(null, null, $select);
		if (!empty($row)) {
			foreach ($row as $k => $v) {
				if (!empty($other)) {
					if (in_array($v['id'], $other)) {
					} else {
						if ($id != $v['id']) {
							$str_news .= "<li data-id={$v['id']} >";
							$str_news .= "<span><img src='{$_B['upload_path']}{$v['img']}' /></span>";
							$str_news .= "<a href='javascript:void()'>{$v['title']}</a>";
							$str_news .= "</li>";
						}
					}
				} else {
					if ($id != $v['id']) {
						$str_news .= "<li data-id={$v['id']} >";
						$str_news .= "<span><img src='{$_B['upload_path']}{$v['img']}' /></span>";
						$str_news .= "<a href='javascript:void()'>{$v['title']}</a>";
						$str_news .= "</li>";
					}
				}
			}
		}
		if ($str_news == '') {
			echo 'empty';
		} else {
			echo $str_news;
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