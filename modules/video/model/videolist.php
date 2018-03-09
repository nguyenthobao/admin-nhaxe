<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/categorylist.php 
 * @Author Hùng (hungdct1083@gmail.com)
 * @Createdate 08/21/2014, 14:31 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class VideoList extends GlobalVideo{
	public $idw,$catVideoObj,$r,$lang; 
	public function __construct(){
			global $_B;	 
			$this->r = $_B['r'];
			$this->idw = $_B['web']['idw'];
			$this->lang = $_B['cf']['lang'];
			$this->lang_use = $_B['cf']['lang_use'];
			
	}
	public function activeStatusVideo(){
		global $_B;
			$getLangAndID = getLangAndID();
			$this->catVideoObj = new Model($getLangAndID['lang'].'_video');
			$status = $this->r->get_string('status','POST');
			$id = $this->r->get_int('key','POST');
			$update = array('status'=>$status,'update_time'=>time());
			if($getLangAndID['lang']!='vi')
			{
				$this->catVideoObj->where('idw',$this->idw);
				$this->catVideoObj->where($getLangAndID['field_id'],$id);
				$result = $this->catVideoObj->update($update);
				//$result = $this->getCategoryByParent($id);
			}else
			{
				$this->catVideoObj->where('idw',$this->idw);
				$this->catVideoObj->where('id',$id);
				$result = $this->catVideoObj->update($update);
			}	


	}
	public function activeVipVideo(){
		global $_B;
			$getLangAndID = getLangAndID();
			$this->catVideoObj = new Model($getLangAndID['lang'].'_video');
			$vip = $this->r->get_string('vip','POST');
			$id = $this->r->get_int('key','POST');
			$update = array('is_vip'=>$vip,'update_time'=>time());
			if($getLangAndID['lang']!='vi')
			{
				$this->catVideoObj->where('idw',$this->idw);
				$this->catVideoObj->where($getLangAndID['field_id'],$id);
				$result = $this->catVideoObj->update($update);
				//$result = $this->getCategoryByParent($id);
			}else
			{
				$this->catVideoObj->where('idw',$this->idw);
				$this->catVideoObj->where('id',$id);
				$result = $this->catVideoObj->update($update);
			}	


	}
	public function activeHotVideo(){
		global $_B;
			$getLangAndID = getLangAndID();
			$this->catVideoObj = new Model($getLangAndID['lang'].'_video');
			$hot = $this->r->get_string('hot','POST');
			$id = $this->r->get_int('key','POST');
			$update = array('is_hot'=>$hot,'update_time'=>time());
			if($getLangAndID['lang']!='vi')
			{
				$this->catVideoObj->where('idw',$this->idw);
				$this->catVideoObj->where($getLangAndID['field_id'],$id);
				$result = $this->catVideoObj->update($update);
				//$result = $this->getCategoryByParent($id);
			}else
			{
				$this->catVideoObj->where('idw',$this->idw);
				$this->catVideoObj->where('id',$id);
				$result = $this->catVideoObj->update($update);
			}	


	}
	public function autoPostVideo()
	{
		global $_B;
		$getLangAndID=getLangAndID();
		$this->catVideoObj=new Model($getLangAndID['lang'].'_video');
		$select = array('id','id_lang','title','date_up','status');
		$this->catVideoObj->where('idw',$this->idw);
		$this->catVideoObj->where('status','2');
		$data = $this->catVideoObj->get(null,null,$select);
		foreach ($data as $key => $value) {
			if($value['date_up']<= strtotime(date('Y-m-d H:i:s')) && $value['date_up'] != 0)
			{
				$value['status']="1";
				$value['date_up']=0;
				$result[]=$value['id'];
			}
		}
		return $result;

	}
	public function activePostVideo(){
		global $_B;
			$getLangAndID = getLangAndID();
			$this->catVideoObj = new Model($getLangAndID['lang'].'_video');
			$status = '1';
			$date_up=0;
			$id = $this->r->get_int('key','POST');
			$update = array('status'=>$status,'date_up'=>$date_up,'update_time'=>time());
				$this->catVideoObj->where('idw',$this->idw);
				$this->catVideoObj->where($getLangAndID['field_id'],$id);
				$result = $this->catVideoObj->update($update);
				//$result = $this->getCategoryByParent($id);
			

	}
	public function refeshVideo(){
		global $_B;
			$getLangAndID = getLangAndID();
			$this->catVideoObj = new Model($getLangAndID['lang'].'_video');
			//$status = $this->r->get_string('status','POST');
			$id = $this->r->get_int('key','POST');
			$update = array('create_time'=>time());
			if($getLangAndID['lang']!='vi')
			{
				$this->catVideoObj->where('idw',$this->idw);
				$this->catVideoObj->where($getLangAndID['field_id'],$id);
				$result = $this->catVideoObj->update($update);
				//$result = $this->getCategoryByParent($id);
			}else
			{
				$this->catVideoObj->where('idw',$this->idw);
				$this->catVideoObj->where('id',$id);
				$result = $this->catVideoObj->update($update);
			}	

			echo implode(",", $update) ;
	}
	public function deleteMulti(){
		global $_B;
		include(DIR_HELPER_UPLOAD);
		$upload = new BncUpload();
		$result = array();
		$getLangAndID = getLangAndID();
		$daiid= $this->r->get_array('key','POST');
		if($getLangAndID['lang']!='vi')
		{
			$this->catVideoObj = new Model($getLangAndID['lang'].'_video');
			foreach($daiid as $k=>$v){	
				$this->catVideoObj->where('idw',$this->idw);
				$this->catVideoObj->where($getLangAndID['field_id'],$v);
				$select = array('id,id_lang,title,img');
				$tmp = $this->catVideoObj->getOne(null,$select);
				$del = $upload->del(array($tmp['img']));

				$this->catVideoObj->where($getLangAndID['field_id'],$v);
				$this->catVideoObj->where('idw',$this->idw);
				$this->catVideoObj->delete();
				$result[]=$v;
			}
		}else
		{
			//$this->catVideoObj = new Model($getLangAndID['lang'].'_video');
			$language = explode(',', $this->lang_use);
			foreach($daiid as $k=>$v){				
					if(!empty($language)){
					foreach ($language as $key => $value) {
						$this->catVideoObj = new Model($value.'_video');	
						$this->catVideoObj->where('idw',$this->idw);
						$this->catVideoObj->where($this->get_lang_id($value),$v);
						$select = array('id,id_lang,title,img');
						$tmp = $this->catVideoObj->getOne(null,$select);
						$del = $upload->del(array($tmp['img']));

						$this->catVideoObj = new Model($value.'_video');	
						$this->catVideoObj->where('idw',$this->idw);
						$this->catVideoObj->where($this->get_lang_id($value),$v);
						$this->catVideoObj->delete();
						
						}
					}
					$result[]=$v;


			}
		}

		echo implode(",", $result) ;
	
	}
	
	public function deleteVideo(){
			include(DIR_HELPER_UPLOAD);
			$upload = new BncUpload();
			$id = $this->r->get_int('key','POST');
			$getLangAndID = getLangAndID();
			
			if($getLangAndID['lang']!='vi')
			{
				$this->catVideoObj = new Model($getLangAndID['lang'].'_video');	
				$this->catVideoObj->where('idw',$this->idw);
				$this->catVideoObj->where($getLangAndID['field_id'],$id);
				$select = array('id,id_lang,title,img');
				$result = $this->videoObj->getOne(null,$select);
				$del = $upload->del($result['img']);

				$this->catVideoObj = new Model($getLangAndID['lang'].'_video');	
				$this->catVideoObj->where('idw',$this->idw);
				$this->catVideoObj->where($getLangAndID['field_id'],$id);
				$this->catVideoObj->delete();
				if(!empty($v1['img_video'])){
							$upload->del($this->upload_path.$v1['img_video']);	
						}
		
			}else
			{
				$language = explode(',', $this->lang_use);
				if(!empty($language)){
					foreach ($language as $k => $v) {
						$this->catVideoObj = new Model($v.'_video');	
						$this->catVideoObj->where('idw',$this->idw);
						$this->catVideoObj->where($this->get_lang_id($v),$id);
						$select = array('id,id_lang,title,img');
						$result = $this->catVideoObj->getOne(null,$select);
						$del = $upload->del(array($result['img']));
					//	print_r($result['img']);
						
						$this->catVideoObj = new Model($v.'_video');	
						$this->catVideoObj->where('idw',$this->idw);
						$this->catVideoObj->where($this->get_lang_id($v),$id);
						$this->catVideoObj->delete();
						//$result[]=$v;
					}
				}

			}	
			//return $result;
	
	}
	protected function getVideoByParent($cat_id) {
		$ids = array();
		$lang = (empty($this->lang))?'vi':$this->lang;
		$this->catVideoObj = new Model($lang.'_video');
		$this->catVideoObj->where('cat_id',$cat_id);
		$this->catVideoObj->where('idw',$this->idw);
		$ids = $this->catVideoObj->get(null,null,'id');
		foreach ($ids as $k=>$v) {
			$this->catVideoObj->where('id',$v);
			$this->catVideoObj->where('idw',$this->idw);
			$this->catVideoObj->delete();
			$result = $this->getCategoryByParent($v);
		}
	}	
	public function getCatVideo($value=null){
		
		$getLangAndID = getLangAndID();
		$this->catVideoObj = new Model($getLangAndID['lang'].'_video');
		//$autoPostVideo=$this->autoPostVideo();	
		if($value['action']=='searchVideo'){

			if(($value['cat_id']!='')and($value['cat_id']!='default')){
				$this->catVideoObj->Where('cat_id','%'.$value['cat_id'].'%','like');
			}
			if(($value['status_video']!='')and($value['status_video']!='default')){
				$this->catVideoObj->where('status',$value['status_video']);
			}
			if(($value['is_vip']!='')and($value['is_vip']!='default')){
				$this->catVideoObj->where('is_vip',$value['is_vip']);
			}
			if(($value['is_hot']!='')and($value['is_hot']!='default')){
				$this->catVideoObj->where('is_hot',$value['is_hot']);
			}
			if($value['video_title']!='')
			{
				$this->catVideoObj->Where('title','%'.$value['video_title'].'%','like');
			}
		}	
		$this->catVideoObj->where('idw',$this->idw);
		$total = $this->catVideoObj->num_rows();
		
		
		$max = 10;
		$maxNum = 5;
		if($value['action']=='searchVideo'){
			 $url = 'video-videolist-lang-'.$getLangAndID['lang'].'-value-'.$_GET['value'];
		}else{
			$url = 'video-videolist-lang-'.$getLangAndID['lang'];
		}


		//$url = 'video-videolist-lang-'.$getLangAndID['lang'];
		$page = pagination($max, $total, $maxNum,$url);
		
		$start = $page['start'];
		$pagination = $page['pagination'];
		$select = '`id`,`id_lang`,`alias`,`title`,`img`,`status`,`is_hot`,`is_vip`,`sort`,`create_time`,`date_up`';

		$this->catVideoObj->where('idw',$this->idw);
		if($value['action']=='searchVideo'){			
			if(($value['cat_id']!='')and($value['cat_id']!='default')){
				$this->catVideoObj->Where('cat_id','%'.$value['cat_id'].'%','like');
			}
			if(($value['status_video']!='')and($value['status_video']!='default')){
				$this->catVideoObj->where('status',$value['status_video']);
			}
			if(($value['is_vip']!='')and($value['is_vip']!='default')){
				$this->catVideoObj->where('is_vip',$value['is_vip']);
			}
			if(($value['is_hot']!='')and($value['is_hot']!='default')){
				$this->catVideoObj->where('is_hot',$value['is_hot']);
			}
			if($value['video_title']!='')
			{
				$this->catVideoObj->Where('title','%'.$value['video_title'].'%','like');
			}
		}

		$this->catVideoObj->orderBy('create_time','DESC');
		$result['data'] = $this->catVideoObj->get(null,array($start,$max),$select);
		foreach ($result['data'] as $key => $value) {
				if($value['date_up']<= strtotime(date('Y-m-d H:i')) && $value['date_up'] != 0)
				{
					$value['status']="1";
					$value['date_up']=0;
					$this->catVideoObj->where('idw',$this->idw);
					$this->catVideoObj->where($getLangAndID['field_id'],$value['id']);
					$this->catVideoObj->update($value);
				}
				$result['data'][$key] = $value;
				
		}
		if ($getLangAndID['lang']!='vi') {
			foreach ($result['data'] as $k => $v) {
				$v['id'] = $v['id_lang'];
				$result['data'][$k] = $v;
				
			}
		}
		if ($total > 10) {
			$result['pagination'] = $pagination;
		}	
				
		return $result;



	}
	public function editTitleVideo(){
		$id = 	$this->r->get_int('pk','POST');
		$title = $this->r->get_string('value','POST');
		$title =preg_replace('/\s\s+/', ' ', trim($title));
		$rule="/([^-+\s]).+$/";
		if (!empty($title))
		{
			preg_match($rule, $title, $pr_title);
		
			$getLangAndID = getLangAndID();
			$this->catVideoObj = new Model($getLangAndID['lang'].'_video');
			$this->catVideoObj->where($getLangAndID['field_id'],$id);
			$this->catVideoObj->where('idw',$this->idw);
			$result = $this->catVideoObj->update(array('title'=>$pr_title[0],'update_time'=>time()));
		}

	}
	
	public function editSortVideo(){
		$id = 	$this->r->get_int('pk','POST');
		$sort = $this->r->get_int('value','POST');
		$getLangAndID = getLangAndID();
		$this->catVideoObj = new Model($getLangAndID['lang'].'_video');
		$this->catVideoObj->where($getLangAndID['field_id'],$id);
		$this->catVideoObj->where('idw',$this->idw);
		$result = $this->catVideoObj->update(array('sort'=>$sort,'update_time'=>time()));
	}
	public function saveImgFast(){
		//global $_B;
		$id = $this->r->get_int('id_img','POST');
		$str = 'img_video_'.$id;
		//echo $str;
		include(DIR_HELPER_UPLOAD);
	  	$options = array('max_size' => 1600);
		$upload = new BncUpload($options);
		$up_img = $upload->upload($this->idw,'video',$str);
		if (!empty($up_img)){

			$getLangAndID = getLangAndID();
			$this->catVideoObj = new Model($getLangAndID['lang']."_video");
			$this->catVideoObj->where($getLangAndID['field_id'],$id);
			$this->catVideoObj->where('idw',$this->idw);
			$result = $this->catVideoObj->update(array('img'=>$up_img));
			if ($result) {
				$data['status'] = true;
			}else{
				$data['status'] = false;
			}
			return $data;
		}
	}
	public function copyVideo(){
		global $_B;
		$getLangAndID = getLangAndID();
		$this->catVideoObj = new Model($getLangAndID['lang'].'_video');
		$daiid= $this->r->get_array('key','POST');
		//print_r($daiid);
		if ($daiid) {
			$this->catVideoObj->where($getLangAndID['field_id'],$daiid,'IN');
			$this->catVideoObj->where('idw',$this->idw);
			$data = $this->catVideoObj->get(null,null,'*');
			//print_r($data);
			foreach ($data as $key => $value) {
				$timeCopy = date('H:i:s d-m');
				$value['title'] .= ' - Copy - '.$timeCopy;
				$imp = array(
				'idw'			=>$this->idw,
				'img'			=>$value['img'],
				'title'			=>$value['title'],
				'short'			=>$value['short'],
				'link_video'	=>$value['link_video'],
				'status'		=>$value['status'],
				'details'			=>$value['details'],
				'meta_title'		=>$value['meta_title'],
				'meta_keyword'	 => $value['meta_keyword'],
				'meta_description'	=>$value['meta_description'],
				'create_uid'		=>$_B['uid'],
				'create_time'		=>time(),
				'tags'				=>$value['tags'],
				'sort'				=>$value['short'],
				'cat_id'			=>$value['cat_id'],
				'is_vip'			=>$value['is_vip'],
				'is_hot'			=>$value['is_hot'],
				'date_up'			=>$value['date_up'],
				'video_lqdm'		=>$value['video_lqdm'],
				'slvddm' 			=>$value['slvddm'],
				'sttvdm' 			=>$value['sttvdm'],
				'kieuhtdm' 			=>$value['kieuhtdm'],
				'kieusxdm' 			=>$value['kieusxdm'],
				'video_lqtc' 		=>$value['video_lqtc'],
				'slvdtc' 			=>$value['slvdtc'],
				'sttvtc' 			=>$value['sttvtc'],
				'kieuhttc' 			=>$value['kieuhttc'],
				'kieusxtc' 			=>$value['kieusxtc'],
				'related_video'		=>$value['related_video'],
					);
				$latest_id = $this->catVideoObj->insert($imp);

			}
		}	
	}
	public function ajaxCopyVideo() {
        $langData  = $this->r->get_string('langData', 'POST');
        $emptyData  = $this->r->get_int('emptyData', 'POST');
        $getLangAndID = getLangAndID();
        $this->catVideoObj = new Model($getLangAndID['lang'].'_video');
        $this->catVideoObj->where('idw', $this->idw);
        $data = $this->catVideoObj->get();
        // echo $data;
        // exit();
        //Kiểm tra làm rỗng
        if ($emptyData == 1) {
            $this->emptyVideo($langData);
        } 
        $this->ajaxCopyCategory($langData,$emptyData);
        //Đệ quy install
        if(!empty($data)){
        	$insl = $this->copyVideoLang($data,$langData); 
    	}
 		echo "Sao chép thành công";
	}

	public function copyVideoLang($data, $langData) { 
				$catVideoObj = new Model($langData.'_video');
		        foreach ($data as $k => $v) {
		            $data_insert = $v;
		            unset($data_insert['id']);
		            if ($v['id_lang'] == null) {
		                $data_insert['id_lang'] = $v['id'];
		            }
		            
		            $idcp= $catVideoObj->insert($data_insert);
		            
		        }
		  		return true;
		 }
	private function emptyVideo($langData) {

		        $this->catVideoObj = new Model($langData.'_video');
		        if($this->idw){
		        	$this->catVideoObj->where('idw', $this->idw);
		        	return $this->catVideoObj->delete();
		        }	        	
		}
	public function ajaxCopyCategory($langData,$emptyData) {
        
        $getLangAndID = getLangAndID();
        $this->catVideoObj = new Model($getLangAndID['lang'].'_category');
        $this->catVideoObj->where('idw', $this->idw);
        $data = $this->catVideoObj->get();
        //Kiểm tra làm rỗng
        $this->emptyCategory($langData);
        
        //Đệ quy install
        if(!empty($data)){
        	$insl = $this->copyCategoryLang($data,$langData); 
    	}
 		//echo "Sao chép thành công";
	}

	public function copyCategoryLang($data, $langData) { 
				$catVideoObj = new Model($langData.'_category');
		        foreach ($data as $k => $v) {
		            $data_insert = $v;
		            unset($data_insert['id']);
		            if ($v['id_lang'] == null) {
		                $data_insert['id_lang'] = $v['id'];
		            }
		            
		            $idcp= $catVideoObj->insert($data_insert);
		            
		        }
		  		return true;
	}
	private function emptyCategory($langData) {

		        $this->catVideoObj = new Model($langData.'_category');
		        if($this->idw){
		        	$this->catVideoObj->where('idw', $this->idw);
		        	return $this->catVideoObj->delete();
		        }	        	
		}
	
}