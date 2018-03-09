<?php
/**
 * @Project BNC v2 -> Admin -> Album
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

/**
 * home model
 */
class home extends Album {
	/*
	 * get list param
	 */
	public $title;
	public $status;
	public $category;
	public $search;
	public $start       = 0;
	public $max_rec     = 10; //num rec
	public $num_display = 5; //paging
	public $url;
	public $paging;
	public $time_now;
	public $total;

	public function getList() {
		global $_B;
		$this->objTable = new Model($this->getLangAndID['lang'] . '_album');
		$select         = array('id', 'id_lang', 'alias','title', 'status', 'avatar', 'avatar_id', 'category_id', 'order_by', 'post_time', 'hide_by_cate');

		//paging
		$this->objTable->where('idw', $this->idw);
		if ($this->search) {
			if ($this->title != '') {
				$this->objTable->where('title', "%" . $this->title . "%", 'LIKE');
			}

			if ($this->status != '' && $this->status != 2) {
				$this->objTable->where('status', $this->status);
			}

			if ($this->category != '') {
				$this->objTable->where('category_id', "%," . $this->category . ",%", 'LIKE');
			}

			if ($this->status != '' && $this->status == 2) {
				$this->objTable->where('post_time', $this->time_now, '>');
			}

			if ($this->status != '' && $this->status == 1) {
				$this->objTable->where('post_time', $this->time_now, '<');
			}

		}

		$total        = $this->objTable->num_rows();
		$this->total  = $total;
		$page         = pagination($this->max_rec, $total, $this->num_display, $this->url);
		$this->start  = $page['start'];
		$this->paging = $page['pagination'];
		//paging end*/

		$this->objTable->where('idw', $this->idw);
		if ($this->search) {
			if ($this->title != '') {
				$this->objTable->where('title', "%" . $this->title . "%", 'LIKE');
			}

			if ($this->status != '' && $this->status != 2) {
				$this->objTable->where('status', $this->status);
			}

			if ($this->category != '') {
				$this->objTable->where('category_id', "%," . $this->category . ",%", 'LIKE');
			}

			if ($this->status != '' && $this->status == 2) {
				$this->objTable->where('post_time', $this->time_now, '>');
			}

			if ($this->status != '' && $this->status == 1) {
				$this->objTable->where('post_time', $this->time_now, '<');
			}

		}

		$this->objTable->orderBy('order_by', 'ASC');
		$data = $this->objTable->get(null, array($this->start, $this->max_rec), $select);

		if ($this->getLangAndID['lang'] != $this->lang) {
			foreach ($data as $k => $v) {
				$v['id']  = $v['id_lang'];
				$data[$k] = $v;
			}
		}
		foreach ($data as $k => $v) {
			$data[$k]['link'] = $_B['web']['redirect'][0] . '/'.$data[$k]['alias'].'-1-3-' . $v['id'] . '.html';
		}

		if ($data) {
			return $data;
		}
	}


	// copy lang album
	public function ajaxCopyAlbum() {
        $langData  = $this->r->get_string('langData', 'POST');
        $emptyData  = $this->r->get_int('emptyData', 'POST');
        $this->objTable = new Model($this->getLangAndID['lang'].'_album');
        $this->objTable->where('idw', $this->idw);
        $data = $this->objTable->get();
        
        //Kiểm tra làm rỗng
        if ($emptyData == 1) {
            $this->emptyAlbum($langData);
        } 
        $this->ajaxCopyCategory($langData,$emptyData);
        //Đệ quy install
        if(!empty($data)){
        	$insl = $this->copyAlbumLang($data,$langData); 
    	}
 		echo "Sao chép thành công";
 		exit();
	}

	public function copyAlbumLang($data, $langData) { 
				$objTable = new Model($langData.'_album');
		        foreach ($data as $k => $v) {
		            $data_insert = $v;
		            unset($data_insert['id']);
		            if ($v['id_lang'] == null) {
		                $data_insert['id_lang'] = $v['id'];
		            }
		            
		            $idcp= $objTable->insert($data_insert);
		            
		        }
		  		return true;
		 }
	private function emptyAlbum($langData) {

		        $this->objTable = new Model($langData.'_album');
		        if($this->idw){
		        	$this->objTable->where('idw', $this->idw);
		        	return $this->objTable->delete();
		        }	        	
		}

	public function ajaxCopyCategory($langData,$emptyData) {
        
        $getLangAndID = getLangAndID();
        $this->obj = new Model($this->getLangAndID['lang'].'_album_category');
        $this->obj->where('idw', $this->idw);
        $data = $this->obj->get();
        //Kiểm tra làm rỗng
        
        $this->emptyCategory($langData);
        
        //Đệ quy install
        if(!empty($data)){
        	$insl = $this->copyCategoryLang($data,$langData); 
    	}
 		//echo "Sao chép thành công";
	}

	public function copyCategoryLang($data, $langData) { 
				$obj = new Model($langData.'_album_category');
		        foreach ($data as $k => $v) {
		            $data_insert = $v;
		            unset($data_insert['id']);
		            if ($v['id_lang'] == null) {
		                $data_insert['id_lang'] = $v['id'];
		            }
		            
		            $idcp= $obj->insert($data_insert);
		            
		        }
		  		return true;
	}
	private function emptyCategory($langData) {

		        $this->obj = new Model($langData.'_album_category');
		        if($this->idw){
		        	$this->obj->where('idw', $this->idw);
		        	return $this->obj->delete();
		        }	        	
		}		
}
