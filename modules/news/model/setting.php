<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/setting.php 
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/17/2014, 10:14 AM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
class Setting extends GlobalNews{
	public $idw,$r,$settingObj;
	private $uid;
	public function __construct(){
		global $_B;	 
		$this->r = $_B['r'];
		$this->idw = $_B['web']['idw'];
		$this->lang = $_B['cf']['lang'];
		
		$getLangAndID = getLangAndID();
		$this->settingObj = new Model($getLangAndID['lang'].'_config');
	}
	public function addSetting(){
		global $_B;
		$setting_post = $this->r->get_array('setting','POST');
		$sort = array();
		foreach ($setting_post as $k => $v) {
			$sort[$k] = $v['sort'];
		}
		asort($sort);
		foreach ($sort as $k=>$v) {
			$sort[$k] = $setting_post[$k];
		}
		$setting = json_encode($sort);
		$data = array(
			'idw'          => $this->idw,
			'key'          => 'news_relateds',
			'value_string' => $setting
			);
		$this->settingObj->where('idw',$this->idw);
		$this->settingObj->where('`key`','news_relateds');
		$exist = $this->settingObj->num_rows();	
		if (!empty($exist)) {
			$this->settingObj->where('idw',$this->idw);
			$this->settingObj->where('`key`',$data['key']);
			$result = $this->settingObj->update($data);
		}else{
			$result = $this->settingObj->insert($data);
		}
		if ($result) {
			$return['status'] = true;
		}else{
			$return['status'] = false;
			$return['error'] = $this->settingObj->getLastError();
		}
		return $return;
	}
	public function searchNewsVip(){
		global $_B;
		$getLangAndID = getLangAndID();
		$start = $this->r->get_int('start', 'POST');
		$cat_id = $this->r->get_string('id_cat','POST');
		$title = $this->r->get_string('titles','POST');
		$start = $this->r->get_int('start', 'POST');
		$this->newsObj = new Model($getLangAndID['lang'].'_news');
		$this->newsObj->where('idw',$this->idw);
		$this->newsObj->where('status',1);
		$this->newsObj->where('is_vip',0);
		if ($cat_id) {
			$this->newsObj->where('cat_id','%,'.(int)$cat_id.',%','LIKE');	
		}
		if (!empty($title)) {
			$this->newsObj->where('title','%'.$title.'%','LIKE');	
		}
		$select = array('id','id_lang','title','img');
		$result['data'] = $this->newsObj->get(null,array(0,15),$select);		
		foreach ($result['data'] as $k => $v) {
			if($v['img'] != '')
			{
				$v['img'] = $_B['upload_path']."".$v['img'];
			}
			else
			{
				$v['img'] = $_B['home']."/themes/default/assets/no_image.gif";
			}
			if ($getLangAndID['lang']!='vi') {
				$v['id'] = $v['id_lang'];
			}
			$result['data'][$k] = $v;
		}
		echo json_encode($result);
	}
	public function searchNewsHot(){
		global $_B;
		$getLangAndID = getLangAndID();
		$start = $this->r->get_int('start', 'POST');
		$cat_id = $this->r->get_string('id_cat','POST');
		$title = $this->r->get_string('titles','POST');
		$start = $this->r->get_int('start', 'POST');
		$this->newsObj = new Model($getLangAndID['lang'].'_news');
		$this->newsObj->where('idw',$this->idw);
		$this->newsObj->where('status',1);
		$this->newsObj->where('is_hot',0);
		if ($cat_id) {
			$this->newsObj->where('cat_id','%,'.(int)$cat_id.',%','LIKE');	
		}
		if (!empty($title)) {
			$this->newsObj->where('title','%'.$title.'%','LIKE');	
		}
		$select = array('id','id_lang','title','img');
		$result['data'] = $this->newsObj->get(null,array(0,15),$select);		
		foreach ($result['data'] as $k => $v) {
			if($v['img'] != '')
			{
				$v['img'] = $_B['upload_path']."".$v['img'];
			}
			else
			{
				$v['img'] = $_B['home']."/themes/default/assets/no_image.gif";
			}
			if ($getLangAndID['lang']!='vi') {
				$v['id'] = $v['id_lang'];
			}
			$result['data'][$k] = $v;
		}
		echo json_encode($result);
	}
	public function saveSettingNewsCat()
	{
		global $_B;		
		$getLangAndID = getLangAndID();
		$news_vip_id         = $this->r->get_string('news_vip_id','POST');
		$news_hot_id         = $this->r->get_string('news_hot_id','POST');
		$news_lasted_qty_cat = $this->r->get_string('news_lasted_qty_cat','POST');
				
		$this->newsObj = new Model($getLangAndID['lang'].'_news');
		$this->newsObj->where('idw',$this->idw);
		//Update tất cả tin của website này về không vip
		if (!empty($news_vip_id)) {
			$this->newsObj->update(array('is_vip'=>0));
			$id_vip = preg_replace("/^,{1}/","",$news_vip_id);
			$id_vip = preg_replace("/,$/","",$id_vip);
			$id_vip = explode(',',$id_vip);
			$this->newsObj->where('idw',$this->idw);
			$this->newsObj->where('id',$id_vip,'IN');
			$this->newsObj->update(array('is_vip'=>1));
		}
		if (!empty($news_hot_id)) {
			$this->newsObj->update(array('is_hot'=>0));
			$id_hot = preg_replace("/^,{1}/","",$news_hot_id);
			$id_hot = preg_replace("/,$/","",$id_hot);
			$id_hot = explode(',',$id_hot);
			$this->newsObj->where('idw',$this->idw);
			$this->newsObj->where('id',$id_hot,'IN');
			$this->newsObj->update(array('is_hot'=>1));
		}
		$data = array(
			'news_lasted_qty_cat' => array(
				'idw'          => $this->idw,
				'key'          => 'news_lasted_qty_cat',
				'value_string' => json_encode($news_lasted_qty_cat)
				),
			'news_vip'	=> array(
				'idw'          => $this->idw,
				'key'          => 'news_vip_id',
				'value_string' => json_encode($news_vip_id)
				),
			'news_hot' => array(
				'idw'          => $this->idw,
				'key'          => 'news_hot_id',
				'value_string' => json_encode($news_hot_id)
				)
			);
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// die();
		foreach ($data as $k => $v) {
				$this->settingObj->where('idw',$this->idw);
				$this->settingObj->where('`key`',$v['key']);			
				$exist = $this->settingObj->num_rows();
			if ($exist > 0) {
				$this->settingObj->where('idw',$this->idw);
				$this->settingObj->where('`key`',$v['key']);
				$this->settingObj->update($v);
			}else{
				$this->settingObj->insert($v);
			}
		}
	}
	public function saveSettingNewsPage()
	{		
		global $_B;
		include(DIR_HELPER_UPLOAD);
		$options = array('max_size' => 1600);
		$upload  = new BncUpload($options);
		$val_img     = $upload->upload($this->idw,'news','img_page_news');
		$val_icon    = $upload->upload($this->idw,'news','icon_page_news');
		$val_bg      = $upload->upload($this->idw,'news','bg_page_news');

		$setting_page = array(
			'title'				=> $this->r->get_string('title','POST'),
			'description'		=> $this->r->get_string('description','POST'),			
			'meta_title'		=> $this->r->get_string('meta_title','POST'),
			'meta_keyword'		=> $this->r->get_string('meta_keyword','POST'),
			'meta_description'	=> $this->r->get_string('meta_description','POST'),
			'quantity_news'		=> $this->r->get_int('quantity_news','POST'),
		);
		if (!empty($val_img)) {
			$setting_page['img'] = $val_img;
		}else{
			if (isset($_POST['val_img_page'])) {
				$setting_page['img'] = $_POST['val_img_page'];
			}
		}
		if (!empty($val_icon)) {
			$setting_page['icon'] = $val_icon;
		}else{
			if (isset($_POST['val_icon_page'])) {
				$setting_page['icon'] = $_POST['val_icon_page'];
			}
		}
		if (!empty($val_bg)) {
			$setting_page['bg'] = $val_bg;
		}else{
			if (isset($_POST['val_bg_page'])) {
				$setting_page['bg'] = $_POST['val_bg_page'];
			}			
		}

		$data = array(
			'idw'          		=> $this->idw,
			'key'          		=> 'setting_page',
			'value_string' 		=> json_encode($setting_page),
		);
		
		$this->settingObj->where('idw',$this->idw);
		$this->settingObj->where('`key`','setting_page');
		$exist = $this->settingObj->num_rows();
		if (!empty($exist)) {			
			$this->settingObj->where('idw',$this->idw);
			$this->settingObj->where('`key`',$data['key']);
			$result = $this->settingObj->update($data);
		}else{
			$result = $this->settingObj->insert($data);
		}
		if ($result) {
			$return['status'] = true;
		}else{
			$return['status'] = false;
			$return['error'] = $this->settingObj->getLastError();
		}
		return $return;
	}	
	public function delImgSetting()
	{
		$this->settingObj->where('idw',$this->idw);
		$this->settingObj->where('`key`','setting_page');
		$data = $this->settingObj->getOne();
		$result = json_decode($data['value_string'],1);
		unset($result['img']);
		$this->settingObj->where('idw',$this->idw);
		$this->settingObj->where('`key`','setting_page');
		$resultNew = $this->settingObj->update(array('value_string'=>json_encode($result)));		
		return $resultNew;		
	}
	public function delIconSetting()
	{
		$this->settingObj->where('idw',$this->idw);
		$this->settingObj->where('`key`','setting_page');
		$data = $this->settingObj->getOne();		
		$result = json_decode($data['value_string'],1);
		unset($result['icon']);
		$this->settingObj->where('idw',$this->idw);
		$this->settingObj->where('`key`','setting_page');
		$resultNew = $this->settingObj->update(array('value_string'=>json_encode($result)));		
		return $resultNew;		
	}
	public function delBgSetting()
	{
		$this->settingObj->where('idw',$this->idw);
		$this->settingObj->where('`key`','setting_page');
		$data = $this->settingObj->getOne();
		$result = json_decode($data['value_string'],1);
		unset($result['bg']);
		$this->settingObj->where('idw',$this->idw);
		$this->settingObj->where('`key`','setting_page');
		$resultNew = $this->settingObj->update(array('value_string'=>json_encode($result)));		
		return $resultNew;		
	}
	public function saveSettingNewsHome()
	{
		$setting_home = array(
			'title_new'    => $this->r->get_string('title_new','POST'),
			'status_new'   => $this->r->get_int('status_new','POST'),
			'quantity_new' => $this->r->get_string('quantity_new','POST'),
			'title_hot'    => $this->r->get_string('title_hot','POST'),
			'status_hot'   => $this->r->get_int('status_hot','POST'),
			'quantity_hot' => $this->r->get_string('quantity_hot','POST'),
			'title_vip'    => $this->r->get_string('title_vip','POST'),
			'status_vip'   => $this->r->get_int('status_vip','POST'),
			'quantity_vip' => $this->r->get_string('quantity_vip','POST'),
		);
		$data = array(
			'idw'          		=> $this->idw,
			'key'          		=> 'setting_home',
			'value_string' 		=>json_encode($setting_home)
		);
		
		$this->settingObj->where('idw',$this->idw);
		$this->settingObj->where('`key`','setting_home');
		$exist = $this->settingObj->num_rows();
		if (!empty($exist)) {
			$this->settingObj->where('idw',$this->idw);
			$this->settingObj->where('`key`',$data['key']);
			$result = $this->settingObj->update($data);
		}else{
			$result = $this->settingObj->insert($data);
		}
		if ($result) {
			$return['status'] = true;
		}else{
			$return['status'] = false;
			$return['error'] = $this->settingObj->getLastError();
		}
		return $return;
	}
	public function resetSetting(){
		$this->settingObj->where('idw',$this->idw);
		$this->settingObj->delete();
	}
	public function getSetting(){
		$this->settingObj->where('idw',$this->idw);
		$results = $this->settingObj->get(null,null,'`key`,value_string');
		if (!empty($results)) {
			foreach ($results as $v) {
				$result[$v['key']] = json_decode($v['value_string'],true);
			}
			return $result;
		}		
	}	
}