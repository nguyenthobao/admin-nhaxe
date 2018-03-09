<?php
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
class MenuListAbove{
	public $idw,$r,$lang,$result_id,$menulistabove; 
	public function __construct(){
		global $_B;	 
		$this->r         = $_B['r'];
		$this->idw       = $_B['web']['idw'];
		$this->lang      = $_B['cf']['lang'];
		$this->result_id = "";
	}
public function getMenuListAbove($value=null){
		$lang=$this->r->get_string('lang','GET');
		$menulistabove = new Model($lang.'_menuabove');	
		$menulistabove->where('idw',$this->idw);
		$total 		= $menulistabove->num_rows();
		$max 		= 15;
		$maxNum 	= 5;
		$url 	    = 'menu-menulistabove-lang-'.$lang;
		$page 		= pagination($max, $total, $maxNum,$url);
		$start 		= $page['start'];
		$pagination = $page['pagination'];
		$select 	= '*';
		$menulistabove->where('idw',$this->idw);
		$menulistabove->orderBy('id','DESC');
		$result['data'] 	  = $menulistabove->get(null,array($start,$max),$select);
	
 		if ($total > 15) {
			$result['pagination'] = $pagination;
		}	
		return $result;
			
	}
	public function activeStatusMenulistabove(){
		global $_B;
		$lang   = $this->r->get_string('lang','GET');
		$id     = $this->r->get_int('key','POST');
		$status = $this->r->get_string('status','POST');
		$menulistabove = new Model($lang.'_menuabove');
		$update = array('status'=>$status);
		$menulistabove->where('id',$id);
		$menulistabove->where('idw',$this->idw);
		$result = $menulistabove->update($update);
	}
	public function deleteMenulistabove($id=null){
		$lang 	= $this->r->get_string('lang','GET');
		$id 	= $this->r->get_int('key','POST');
		if ( !is_numeric($id) or $id == 0) {
			$data['status'] = false;
			return json_encode($data);
		}

		$menulistabove = new Model($lang.'_menuabove');
		$menulistabove->where('id',$id);
		$menulistabove->where('idw',$this->idw);
		$menulistabove->delete();

		$data['status'] = true;
		return json_encode($data);	
	}
	public function deleteMultiID(){
			$lang= $this->r->get_string('lang','GET');
			$ids = $this->r->get_array('name_id','POST');
			foreach($ids as $k=>$v){
				$menulistabove=new Model($lang.'_menuabove');
				$menulistabove->where('id',$v);
		        $menulistabove->where('idw',$this->idw);
		        $menulistabove->delete();
			}
			$r['status'] = true;
			return $r;

	}
	public function editNameCustomers(){
		$id    = 	$this->r->get_int('pk','POST');
		$title = $this->r->get_string('value','POST');
		//Cắt bỏ chuỗi -- .
		$rule="/([^-+\s]).+$/";
		if (!empty($title))
		{
			preg_match($rule, $title, $pr_title);			
			$lang = $this->r->get_string('lang' ,'GET');
			$menulistabove = new Model($lang.'_menuabove');
			$menulistabove->where('id',$id);
			$menulistabove->where('idw',$this->idw);
			$result = $menulistabove->update(array('customers'=>$pr_title[0]));
		}
	}
	public function saveImgFast(){
		//global $_B;
		$id = $this->r->get_int('id_img','POST');
		$str = 'img_news_'.$id;
		//echo $str;
		include(DIR_HELPER_UPLOAD);
	  	$options = array('max_size' => 1600);
		$upload = new BncUpload($options);
		if (!empty($str)){
		    $up_img = $upload->upload($this->idw,'menu',$str);
			$lang   = $this->r->get_string('lang' ,'GET');
			$menulistabove = new Model($lang."_menuabove");
			$menulistabove->where('id',$id);
			$menulistabove->where('idw',$this->idw);
			$result = $menulistabove->update(array('img'=>$up_img));
			if ($result) {
				$data['status'] = true;
			}else{
				$data['status'] = false;
			}
			return $data;
		}
	}
	
}
	