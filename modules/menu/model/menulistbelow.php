<?php
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
class MenuListBelow{
	public $idw,$r,$lang,$result_id,$menulistbelow; 
	public function __construct(){
		global $_B;	 
		$this->r         = $_B['r'];
		$this->idw       = $_B['web']['idw'];
		$this->lang      = $_B['cf']['lang'];
		$this->result_id = "";
	}
public function getMenuListBelow($value=null){
		$lang=$this->r->get_string('lang','GET');
		$menulistbelow = new Model($lang.'_menubelow');	
		$menulistbelow->where('idw',$this->idw);
		$total 		= $menulistbelow->num_rows();
		$max 		= 15;
		$maxNum 	= 5;
		$url 	    = 'menu-menulistbelow-lang-'.$lang;
		$page 		= pagination($max, $total, $maxNum,$url);
		$start 		= $page['start'];
		$pagination = $page['pagination'];
		$select 	= '*';
		$menulistbelow->where('idw',$this->idw);
		$menulistbelow->orderBy('id','DESC');
		$result['data'] 	  = $menulistbelow->get(null,array($start,$max),$select);
	
 		if ($total > 15) {
			$result['pagination'] = $pagination;
		}	
		return $result;
			
	}
	public function activeStatusMenulistbelow(){
		global $_B;
		$lang   = $this->r->get_string('lang','GET');
		$id     = $this->r->get_int('key','POST');
		$status = $this->r->get_string('status','POST');
		$menulistabove = new Model($lang.'_menubelow');
		$update = array('status'=>$status);
		$menulistabove->where('id',$id);
		$menulistabove->where('idw',$this->idw);
		$result = $menulistabove->update($update);
	}
	public function deleteMenulistbelow($id=null){
		$lang 	= $this->r->get_string('lang','GET');
		$id 	= $this->r->get_int('key','POST');
		if ( !is_numeric($id) or $id == 0) {
			$data['status'] = false;
			return json_encode($data);
		}

		$menulistbelow = new Model($lang.'_menubelow');
		$menulistbelow->where('id',$id);
		$menulistbelow->where('idw',$this->idw);
		$menulistbelow->delete();

		$data['status'] = true;
		return json_encode($data);	
	}
	public function deleteMultiID(){
			$lang= $this->r->get_string('lang','GET');
			$ids = $this->r->get_array('name_id','POST');
			foreach($ids as $k=>$v){
				$menulistbelow=new Model($lang.'_menubelow');
				$menulistbelow->where('id',$v);
		        $menulistbelow->where('idw',$this->idw);
		        $menulistbelow->delete();
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
			$menulistbelow = new Model($lang.'_menubelow');
			$menulistbelow->where('id',$id);
			$menulistbelow->where('idw',$this->idw);
			$result = $menulistbelow->update(array('customers'=>$pr_title[0]));
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
			$menulistbelow = new Model($lang."_menubelow");
			$menulistbelow->where('id',$id);
			$menulistbelow->where('idw',$this->idw);
			$result = $menulistbelow->update(array('img'=>$up_img));
			if ($result) {
				$data['status'] = true;
			}else{
				$data['status'] = false;
			}
			return $data;
		}
	}
	
}
	