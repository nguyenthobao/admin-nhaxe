<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/video.php
 * @Author Hùng
 * @Createdate 08/15/2014, 16:38 PM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

class Video extends GlobalVideo {
	public $idw, $videoObj, $catVideoObjvi, $r, $lang;
	private $uid;
	public function __construct() {
		global $_B;
		$this->r        = $_B['r'];
		$this->idw      = $_B['web']['idw'];
		$this->lang     = $_B['cf']['lang'];
		$this->lang_use = $_B['cf']['lang_use'];
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

	public function addvideo() {
		global $_B;
		$getLangAndID = getLangAndID();

		$title = $this->r->get_string('title', 'POST');
		$title = preg_replace('/\s\s+/', ' ', trim($title));
		if ($this->r->get_string('video_lqdm', 'POST') == 'on') {
			$video_lqdm = 1;
		} else {
			$video_lqdm = 0;
		}
		if ($this->r->get_string('video_lqtc', 'POST') == 'on') {
			$video_lqtc = 1;
		} else {
			$video_lqtc = 0;
		}
		//END UPLOAD
		$id_cat = $this->r->get_array('cat_name', 'POST');
		$cat_id = ',' . implode(',', $id_cat) . ',';
		$id     = $this->r->get_int('id');
		if ($_GET['lang'] != 'vi') {
			$id_lang = $this->r->get_int('id', 'GET');
		} else {
			$id_lang = '';
		}
		$link_video = $this->r->get_string('link_video', 'POST');
		if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $link_video, $match)) {
				$link_video = 'http://youtu.be/'.$match[1];
		}
		
		$testlink   = @strpos($link_video, "youtu.be");

		$date_uptmp1 = $this->r->get_string('date_up', 'POST');
		$date_uptmp  = @str_replace("/", "-", $date_uptmp1);
		$date_up     = strtotime($date_uptmp);
		if ($date_up != 0) {
			$status = 2;
		} else {
			$status = $this->r->get_int('status', 'POST');
		}
		//POST video vip
		if ($this->r->get_string('video_vip', 'POST') == 'on') {
			$is_vip = 1;
		} else {
			$is_vip = 0;
		}
		//POST video hot
		if ($this->r->get_string('video_hot', 'POST') == 'on') {
			$is_hot = 1;
		} else {
			$is_hot = 0;
		}

		$related_id    = $this->r->get_array('related_id', 'POST');
		$related_video = ',' . implode(',', $related_id) . ',';

		if ($testlink != true) {
			$return['status'] = false;
			$return['error']  = "Lỗi ! Video không tồn tại. Bạn chưa nhập đúng link video. Xin hãy nhập lại !!!";
			return $return;
			return false;

		} else {
			if ($title != '') {
				//START UPLOAD
				include DIR_HELPER_UPLOAD;
				$options = array('max_size' => 1600);
				$upload  = new BncUpload($options);
				$up_img  = @$upload->upload($this->idw, 'video', 'img_video');

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
					'idw'              => $this->idw,
					'img'              => $up_img,
					'title'            => $title,
					'alias'            => $this->r->get_string('alias', 'POST'),
					'short'            => $this->r->get_string('short', 'POST'),
					'link_video'       => $link_video,
					'status'           => $status,
					'details'          => $this->r->get_string('content', 'POST'),
					'meta_title'       => $this->r->get_string('meta_title', 'POST'),
					'meta_keyword'     => $this->r->get_string('meta_keyword', 'POST'),
					'meta_description' => $this->r->get_string('meta_description', 'POST'),
					'create_uid'       => $_B['uid'],
					'create_time'      => time(),
					'id_lang'          => $id_lang,
					'tags'             => $tag_id,
					'sort'             => (int) $this->r->get_string('sort', 'POST'),
					'cat_id'           => $cat_id,
					'is_vip'           => (int) $is_vip,
					'is_hot'           => (int) $is_hot,
					'date_up'          => $date_up,
					'video_lqdm'       => (int) $video_lqdm,
					'slvddm'           => $this->r->get_int('slvddm', 'POST'),
					'sttvdm'           => $this->r->get_int('sttvdm', 'POST'),
					'kieuhtdm'         => $this->r->get_int('kieuhtdm', 'POST'),
					'kieusxdm'         => $this->r->get_int('kieusxdm', 'POST'),
					'video_lqtc'       => (int) $video_lqtc,
					'slvdtc'           => $this->r->get_int('slvdtc', 'POST'),
					'sttvtc'           => $this->r->get_int('sttvtc', 'POST'),
					'kieuhttc'         => $this->r->get_int('kieuhttc', 'POST'),
					'kieusxtc'         => $this->r->get_int('kieusxtc', 'POST'),
					'related_video'    => $related_video,
				);
				if (empty($up_img)) {
					unset($data['img']);
				}
			} else {
				return false;
			}

			if (!empty($id)) {

				if ($this->r->get_string('is_save', 'POST') == 'on') {
					$str_alias = $this->r->get_string('alias', 'POST');
				} else {
					$str_alias = $this->r->get_string('title_alias', 'POST');
				}
				if (is_array($tags) == true) {
					$tag_id = ',';
					foreach ($tags as $k => $v) {
						$tag_id .= $this->addTags($v) . ',';
					}
				} else {
					$tag_id = '';
				}
				$data = array(
					'idw'              => $this->idw,
					'img'              => $up_img,
					'title'            => $title,
					'alias'            => $str_alias,
					'short'            => $this->r->get_string('short', 'POST'),
					'link_video'       => $link_video,
					'status'           => $status,
					'details'          => $this->r->get_string('content', 'POST'),
					'meta_title'       => $this->r->get_string('meta_title', 'POST'),
					'meta_keyword'     => $this->r->get_string('meta_keyword', 'POST'),
					'meta_description' => $this->r->get_string('meta_description', 'POST'),
					'update_uid'       => $_B['uid'],
					'update_time'      => time(),
					'id_lang'          => $id_lang,
					'tags'             => $tag_id,
					'sort'             => (int) $this->r->get_string('sort', 'POST'),
					'cat_id'           => $cat_id,
					'is_vip'           => (int) $is_vip,
					'is_hot'           => (int) $is_hot,
					'date_up'          => $date_up,
					'video_lqdm'       => (int) $video_lqdm,
					'slvddm'           => (int) $this->r->get_int('slvddm', 'POST'),
					'sttvdm'           => (int) $this->r->get_int('sttvdm', 'POST'),
					'kieuhtdm'         => (int) $this->r->get_int('kieuhtdm', 'POST'),
					'kieusxdm'         => (int) $this->r->get_int('kieusxdm', 'POST'),
					'video_lqtc'       => (int) $video_lqtc,
					'slvdtc'           => (int) $this->r->get_int('slvdtc', 'POST'),
					'sttvtc'           => (int) $this->r->get_int('sttvtc', 'POST'),
					'kieuhttc'         => (int) $this->r->get_int('kieuhttc', 'POST'),
					'kieusxtc'         => (int) $this->r->get_int('kieusxtc', 'POST'),
					'related_video'    => $related_video,
				);
				if (empty($up_img)) {
					unset($data['img']);
				}
				//$this->videoObj->where($getLangAndID['field_id'], $id);
				$db       = db_connect('video');
				$videoObj = new Model($getLangAndID['lang'] . '_video', $db);

				$videoObj->where($getLangAndID['field_id'], $id);
				$videoObj->where('idw', $this->idw);
				$result = $videoObj->update($data);
				/*if ($getLangAndID['lang']=='vi') {
				$data['cat_id']= $this->addCatIdAll($id);
				}else
				{
				$data['cat_id']= $this->addCatId($id);
				}*/

				if ($getLangAndID['lang'] == 'vi') {
					//Update lại parent_id nếu sửa bản ghi tiếng việt
					$data = array(
						'id_lang' => $id,
					);
					$this->fixVideoID($data, $id, 'update');

				} else {
					//Kiểm tra xem bản ghi đã tồn tại bên ngôn ngữ này chưa.
					//True : update
					//false: insert
					$checkExist = $this->checkExist($id, $getLangAndID['lang'], 'video');
					if ($checkExist == false) {
						$db       = db_connect('video');
						$videoObj = new Model($getLangAndID['lang'] . '_video', $db);
						$result   = $videoObj->insert($data);
						//$data['cat_id']= $this->addCatId($id);
					}
				}
			} else {

				if ($data['date_up'] == 0) {
					$db       = db_connect('video');
					$videoObj = new Model($getLangAndID['lang'] . '_video', $db);
					$result   = $videoObj->insert($data);
				} else {
					$data['status'] = 2;
					$db             = db_connect('video');
					$videoObj       = new Model($getLangAndID['lang'] . '_video', $db);
					$result         = $videoObj->insert($data);
				}
			}

			if ($id) {
				$return['last_id'] = $this->r->get_int('id', 'GET');
			} else {
				$return['last_id'] = $result;
			}

			if ($result) {
				$return['status'] = true;
			} else {
				$return['status'] = false;
				$return['error']  = $videoObj->getLastError();
			}
			return $return;
		}

	}
	//get video
	public function getVideoByID() {
		global $_B;
		$db             = db_connect('video');
		$id             = $this->r->get_int('id');
		$getLangAndID   = getLangAndID();
		$this->videoObj = new Model($getLangAndID['lang'] . '_video', $db);
		$select         = array('id,id_lang,title,img,link_video,short,details,tags,status,cat_id,is_vip,is_hot,date_up,meta_title,meta_keyword,meta_description,sort,video_lqdm,slvddm,sttvdm,kieuhtdm,kieusxdm,video_lqtc,slvdtc,sttvtc,kieuhttc,kieusxtc,related_video,alias');
		$this->videoObj->where($getLangAndID['field_id'], $id);
		$this->videoObj->where('idw', $this->idw);
		$result = $this->videoObj->getOne(null, $select);
		if ($result['date_up'] != 0) {
			$result['date_up'] = date("d/m/Y H:i", $result['date_up']);
		}
		$result['cat_id'] = explode(',', $result['cat_id']);

		$editTags    = explode(',', $result['tags']);
		$editTagsNew = array();
		foreach ($editTags as $k => $v) {
			if ($v != '') {
				$editTagsNew[] = $this->getTagName($v);
			}
		}
		$result['tags'] = implode(',', $editTagsNew);

		if ($result) {
			return $result;
		}

	}
	protected function getParentIDVD() {
		$id                  = $this->r->get_int('id');
		$db                  = db_connect('video');
		$this->catVideoObjvi = new Model('vi_video', $db);
		$select              = array('parent_id');
		$this->catVideoObjvi->where('id', $id);
		$this->catVideoObjvi->where('idw', $this->idw);
		$result = $this->catVideoObjvi->getOne(null, $select);

		if ($result) {
			return $result['parent_id'];
		}
	}
	public function getRelatedVideo($items = null) {
		$id             = $this->r->get_int('id');
		$db             = db_connect('video');
		$getLangAndID   = getLangAndID();
		$this->videoObj = new Model($getLangAndID['lang'] . '_video', $db);
		$select         = array('id', 'id_lang', 'title', 'img');
		$this->videoObj->where('idw', $this->idw);
		$this->videoObj->where('status', 1);
		if ($items != null) {
			foreach ($items as $key => $value) {
				$this->videoObj->where($getLangAndID['field_id'], $value, '!=');
			}

		}
		if ($id) {
			$this->videoObj->where($getLangAndID['field_id'], $id, "!=");
		}

		$this->videoObj->orderBy('id', 'DESC');
		$result['data'] = $this->videoObj->get(null, array(0, 10), $select);
		if (!empty($result['data'])) {
			if ($getLangAndID['lang'] != 'vi') {
				foreach ($result['data'] as $k => $v) {
					$v['id']            = $v['id_lang'];
					$result['data'][$k] = $v;
				}
			}
		}
		return $result;
	}
	public function getRelatedVideoByID($id) {
		//$id = $this->r->get_int('id');
		$getLangAndID   = getLangAndID();
		$db             = db_connect('video');
		$this->videoObj = new Model($getLangAndID['lang'] . '_video', $db);
		$select         = array('id', 'id_lang', 'title', 'img');
		$this->videoObj->where($getLangAndID['field_id'], $id);
		$this->videoObj->where('idw', $this->idw);
		$data = $this->videoObj->getOne(null, $select);
		if (!empty($data)) {
			if ($getLangAndID['lang'] != 'vi') {

				$data['id'] = $data['id_lang'];
				//$data[$k] = $v;

			}
			return $data;
		}
	}
	public function testidlang($id) {
		$getLangAndID   = getLangAndID();
		$db             = db_connect('video');
		$this->videoObj = new Model($getLangAndID['lang'] . '_video', $db);
		$this->videoObj->where($getLangAndID['field_id'], $id);
		$this->videoObj->where('idw', $this->idw);
		$data = $this->videoObj->getOne();
		if (!empty($data)) {
			return true;
		} else {
			return false;
		}

	}
	public function searchVideoLQ() {
		global $_B;
		$db                = db_connect('video');
		$id                = $this->r->get_int('idsearch');
		$str_vd            = '';
		$other             = $this->r->get_array('key', 'POST');
		$text              = $this->r->get_string('text', 'POST');
		$getLangAndID      = getLangAndID();
		$this->catVideoObj = new Model($getLangAndID['lang'] . '_video', $db);
		$select            = array('id', 'id_lang', 'title', 'img');
		$this->catVideoObj->where('title', '%' . $text . '%', 'like');
		$this->catVideoObj->where('idw', $this->idw);
		$this->catVideoObj->where('status', 1);
		$row = $this->catVideoObj->get(null, null, $select);
		if (!empty($row)) {
			foreach ($row as $k => $v) {

				if (!empty($other)) {

					if (in_array($v['id'], $other)) {
					} else {
						if ($id != $v['id']) {
							$str_vd .= "<li data-id={$v['id']} >";
							//$str_vd .= "<span><img src='http://static1.webbnc.vn/{$v['img']}'/></span>";
							$str_vd .= "<span><img src='{$_B['upload_path']}{$v['img']}' /></span>";
							$str_vd .= "<a href='javascript:void()'>{$v['title']}</a>";
							$str_vd .= "</li>";
						}
					}

				} else {
					if ($id != $v['id']) {
						$str_vd .= "<li data-id={$v['id']} >";
						//$str_vd .= "<span><img src='http://static1.webbnc.vn/{$v['img']}'/></span>";
						$str_vd .= "<span><img src='{$_B['upload_path']}{$v['img']}' /></span>";
						$str_vd .= "<a href='javascript:void()'>{$v['title']}</a>";
						$str_vd .= "</li>";
					}
				}
			}
		}
		if ($str_vd == '') {
			echo 'empty';
		} else {
			echo $str_vd;
		}

	}

	public function searchVideo() {
		$getLangAndID      = getLangAndID();
		$db                = db_connect('video');
		$this->catVideoObj = new Model($getLangAndID['lang'] . '_video', $db);
		$select            = '`id`,`id_lang`,`title`,`img`,`status`,`sort`';
		$video_title       = $this->r->get_string('video_title', 'POST');
		$this->catVideoObj->where('idw', $this->idw);
		$this->catVideoObj->where('title ', $video_title);
		$data = $this->catVideoObj->get(null, null, $select);

		echo "<pre>";
		print_r($data);
		echo "</pre>";
		die();
		return $data;
	}
	public function addCatId($id) {
		global $_B;
		$getLangAndID        = getLangAndID();
		$db                  = db_connect('video');
		$this->catVideoObj   = new Model($getLangAndID['lang'] . '_video', $db);
		$this->catVideoObjVi = new Model('vi_video');
		$this->catVideoObjVi->where('idw', $this->idw);
		$this->catVideoObjVi->where('id', $id);
		$select  = array('id', 'cat_id');
		$data    = $this->catVideoObjVi->getOne(null, $select);
		$dataAdd = array(
			'cat_id' => $data['cat_id'],
		);
		$this->catVideoObj->where('idw', $this->idw);
		$this->catVideoObj->where($getLangAndID['field_id'], $id);
		$this->catVideoObj->update($dataAdd);
	}
	public function addCatIdAll($id) {
		global $_B;
		$db                  = db_connect('video');
		$getLangAndID        = getLangAndID();
		$this->catVideoObjVi = new Model('vi_video', $db);
		$this->catVideoObjVi->where('idw', $this->idw);
		$this->catVideoObjVi->where('id', $id);
		$select  = array('id', 'cat_id');
		$data    = $this->catVideoObjVi->getOne(null, $select);
		$dataAdd = array(
			'cat_id' => $data['cat_id'],
		);
		$language = explode(',', $this->lang_use);
		if (!empty($language)) {
			foreach ($language as $k => $v) {
				$this->catVideoObj = new Model($v . '_video', $db);
				$this->catVideoObj->where('idw', $this->idw);
				$this->catVideoObj->where($this->get_lang_id($v), $id);
				$this->catVideoObj->update($dataAdd);
				//$result[]=$v;
			}
		}
	}

	public function getConfig() {
		$oBj = new Model($this->lang . '_setting');
		$oBj->where('idw', $this->idw);
		return $oBj->getOne();
	}

}