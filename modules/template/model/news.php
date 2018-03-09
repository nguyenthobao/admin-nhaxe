<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/category.php 
 * @Author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 08/17/2014, 10:14 AM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class News extends GlobalNews{
	public $idw,$catNewObj,$catNewObjvi,$r,$lang,$newsObj,$newsRelated;
	private $uid;
	public function __construct(){
		global $_B;	 
		$this->r = $_B['r'];
		$this->idw = $_B['web']['idw'];
		$this->lang = $_B['cf']['lang'];
	}
	public function addNews(){

		global $_B;
		
		$getLangAndID = getLangAndID();
		$this->newsObj = new Model($getLangAndID['lang'].'_news');
		
		//START UPLOAD
		include(DIR_HELPER_UPLOAD);
	  	$options = array('max_size' => 1600);
		$upload = new BncUpload($options);
		$up_img = $upload->upload($this->idw,'news','img_news');
		//END UPLOAD
		//POST news vip
		if($this->r->get_string('news_vip','POST')=='on') {
			$is_vip = 1;
		}else{
			$is_vip = 0;
		}
		//POST news hot
		if($this->r->get_string('news_hot','POST')=='on'){
			$is_hot = 1;
		}else{
			$is_hot = 0;
		}

		$id_cat = $this->r->get_array('cat_name','POST');
		$cat_id = implode(',',$id_cat);

		$related_id = $this->r->get_array('related_id','POST');
		$related_news = implode(',', $related_id);

		$news_id = $this->r->get_int('id');

		$id_lang = null;
		if ($getLangAndID['lang']!='vi'){
			$id_lang = $this->r->get_int('id');
			$news_id = $this->r->get_int('id_lang');
		}
		$date_time_up = $this->r->get_string('time_up','POST');
		$date_time=str_replace("/", "-",$date_time_up);
		$time_up= strtotime($date_time);
		if($time_up !=0)
		{
			$status=2;
		}else{
			$status=$this->r->get_int('status','POST');
		}

		$data = array(
			'idw'				=>$this->idw,
			'id_lang'			=>$id_lang,				
			'cat_id'     		=>$cat_id,
			'img'				=>$up_img,
			'title'				=>$this->r->get_string('title','POST'),
			'short'				=>$this->r->get_string('description','POST'),
			'details'			=>$this->r->get_string('content','POST'),
			'create_uid'		=>$_B['uid'],
			'sort'				=>$this->r->get_string('sort','POST'),
			'author'			=>$this->r->get_string('author','POST'),
			'news_source'		=>$this->r->get_string('news_source','POST'),
			'create_time'		=>time(),
			'meta_title'		=>$this->r->get_string('meta_title','POST'),
			'meta_keyword'		=>$this->r->get_string('meta_keyword','POST'),
			'meta_description'	=>$this->r->get_string('meta_description','POST'),
			'is_vip'			=>$is_vip,
			'is_hot'			=>$is_hot,
			'related_news'     	=>$related_news,
			'status'			=>$status,
			'time_up'			=>$time_up,
		);

		if (isset($_POST['img_news'])&&$_POST['img_news']=="1") {
			unset($data['img']);
		}
		
		$tin_danh_muc = array(
			'news_id' 			=>$news_id,
			'idw'          		=>$this->idw,
			'status'        	=>($this->r->get_string('chk_cat_related','POST')=='on')? 1:0,
			'show_quantity' 	=>$this->r->get_string('show_quantity','POST'),
			'show_sort' 		=>$this->r->get_string('show_sort','POST'),
			'show_type' 		=>$this->r->get_string('show_type','POST'),
			'show_news' 		=>$this->r->get_string('show_news','POST'),
			);
		$tin_lien_quan = array(
			'news_id' 			=>$news_id,
			'idw'          		=>$this->idw,
			'status'        	=>($this->r->get_string('chk_news_related','POST')=='on')?1:0,
			'show_quantity' 	=>$this->r->get_string('show_quantity_1','POST'),
			'show_sort' 		=>$this->r->get_string('show_sort_1','POST'),
			'show_type' 		=>$this->r->get_string('show_type_1','POST'),
			'show_news' 		=>$this->r->get_string('show_news_1','POST'),
			);


		//Kiểm tra xem nếu tồn tại id thì update, nếu không thì insert
		$id = $this->r->get_int('id','GET');

		if (!empty($id)) {
			$this->newsObj->where($getLangAndID['field_id'],$id);
			$this->newsObj->where('idw',$this->idw);
			$result = $this->newsObj->update($data);				
			$checkExistRelated = $this->checkExistRelated($id,$news_id);
			if ($checkExistRelated==true) {
				$this->addNewsRelated('news_same_category',$tin_danh_muc,'update');
				$this->addNewsRelated('news_related',$tin_lien_quan,'update');
			}
			else
			{
				$this->addNewsRelated('news_same_category',$tin_danh_muc);
				$this->addNewsRelated('news_related',$tin_lien_quan);
			}

			if ($getLangAndID['lang']=='vi') {
				//Update lại parent_id nếu sửa bản ghi tiếng việt
				$data = array(
					'id_lang'=>$id
				);
				//function fixParentCat($data,$id,$action)
				//@param1 : mảng truyền vào xử lý
				//@param2: id
				//@param3: action truyền vào để xử lý theo yêu cầu. VD: delete,update
				$this->fixNewsID($data,$id,'update');
			}else{
				//Kiểm tra xem bản ghi đã tồn tại bên ngôn ngữ này chưa. 
				//True : update
				//false: insert
				$checkExistNews = $this->checkExistNews($id,$getLangAndID['lang']);
				if ($checkExistNews==true) {
					$this->newsObj->where($getLangAndID['field_id'],$id);
					$this->newsObj->where('idw',$this->idw);
					$result = $this->newsObj->update($data);		
				}else{
					$result = $this->newsObj->insert($data);
				}
			}				
		}else{
			$result = $this->newsObj->insert($data);

			$tin_danh_muc['news_id']  = $result;
			$tin_lien_quan['news_id'] = $result;
			$this->addNewsRelated('news_same_category',$tin_danh_muc);				
			$this->addNewsRelated('news_related',$tin_lien_quan);
		}
		
		if ($getLangAndID['lang']!='vi'){
			$return['last_id'] = $this->r->get_int('id');
		}else{
			$return['last_id'] = $this->newsObj->getLastId();
		}			
		if ($result) {
			$return['status'] = true;
		}else{
			$return['status'] = false;
			$return['error'] = $this->newsObj->getLastError();
		}
		return $return;
	}
	/**
	 * add config of module news
	 */
	protected function addNewsRelated($table,$data,$ac = 'add'){
		$this->newsRelated = new Model($table);
		if ($ac=='update') {
			$id = $this->r->get_int('id','GET');
			$this->newsRelated->where('news_id',$id);
			$this->newsRelated->where('idw',$this->idw);
			$this->newsRelated->update($data);
		}else if($ac=='add'){
			$result = $this->newsRelated->insert($data);	
		}else{
			//delete
		}		
		if ($result) {
			return true;
		}
		return false;
	}

	//get News

	public function getNewsID(){
		$id = $this->r->get_int('id','get');
		$this->newsObj = new Model('vi_news');
		//$select = array('id');
		$this->newsObj->where('id',$id);
		$this->newsObj->where('idw',$this->idw);
		$result = $this->newsObj->getOne();
		$result['cat_id'] = explode(',', $result['cat_id']);
		return $result;
	}
	
	
	public function getNewsRelated($table){
		$id = $this->r->get_int('id','GET');
		$this->newsRelated = new Model($table);
		$this->newsRelated->where('news_id',$id);
		$this->newsRelated->where('idw',$this->idw);
		$result = $this->newsRelated->getOne();
		if ($result) {
			return $result;
		}
	}
	public function searchRelatedNews()
	{
		global $_B;
		$id = $this->r->get_int('idsearch');
		$str_vd ='';
		$other=$this->r->get_array('key','POST');
		$text=$this->r->get_string('text','POST');
		$getLangAndID=getLangAndID();
		$this->newsObj= new Model($getLangAndID['lang'].'_news');
		$select = array('id','id_lang','title','img');
		$this->newsObj->where('title','%'.$text.'%','like');
		$this->newsObj->where('idw',$this->idw);
		$this->newsObj->where('status',1);
		$row = $this->newsObj->get(null,null,$select);
		if(!empty($row))
		{
			foreach ($row as $k => $v) {
				if(!empty($other))
				{					
					if(in_array ($v['id'], $other)){
						}else{
							if($id!=$v['id'])
							{
								$str_vd .= "<li data-id={$v['id']} >";								
								$str_vd .= "<span><img src='{$_B['upload_path']}{$v['img']}' /></span>";
								$str_vd .= "<a href='javascript:void()'>{$v['title']}</a>";
								$str_vd .= "</li>";
							}
						}					
				}else{
					if($id!=$v['id'])
					{
						$str_vd .= "<li data-id={$v['id']} >";						
						$str_vd .= "<span><img src='{$_B['upload_path']}{$v['img']}' /></span>";
						$str_vd .= "<a href='javascript:void()'>{$v['title']}</a>";
						$str_vd .= "</li>";
					}
				}
			}
		}
		if($str_vd == ''){
			echo 'empty';
		}else{
			echo $str_vd;
		}		
	}
}