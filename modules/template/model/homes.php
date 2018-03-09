<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/template.php 
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 10/13/2014, 16:10 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class Temp {
	public $idw,$r,$lang,$blocksAll,$blockFree;
	public $homeUse;
	public $blockUseInfo = array(
		1 => array(),
		2 => array(),
		3 => array(),
		4 => array(),
	);
	public $count = array(  
		'store'=> array(
			0 => 0,
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 0,
			7 => 0,
			8 => 0,
			9 => 0,
			)
		); 
	public function __construct(){
		global $_B,$web;	 
		$this->r = $_B['r'];
		$this->idw = $_B['web']['idw'];
		$this->lang = $this->r->get_string('lang','GET');;
	}
	public function index(){
		$return['homes'] = $this->getHomes();
		$return['count'] = $this->count;
		$return['homeUse'] = $this->homeUse;
		return $return;
	}  
	public function getHomes(){
		$blocksObj = new Model('homes');
		$blocksObj->where('status',1);
		$blocksObj->orderBy('sort','ASC');
		$this->blocksAll = $this->fixLangBlock($blocksObj->get());

		$blockUseObj = new Model($this->lang.'_home'); 

		$blockUseObj->where('idw',$this->idw); 
		$blockUseObj->orderBy('sort','ASC');  
		$this->divide($blockUseObj->get());   
		$data = $this->getBlockPositon($this->blocksAll, $this->homeUse);
		return $data;
	}
	
	private function getBlockPositon($blocks,$info){
		$idblocks = array();
		foreach ($info as $key => $value) {
			$idblocks[] = $value['idhome'];
		}
		foreach ($blocks as $key => $value) {
			if(in_array($value['id'], $idblocks)){
				unset($blocks[$key]);
			}
		}
		return $blocks;
	}
	public function divide($blocks){ 
		foreach ($blocks as $key => $value) { 
			$blocks[$key]['thumb'] = $this->getThumb($value);
			$blocks[$key]['name_default'] = $this->getNameDefault($value['file'], $value['module_str']);
		} 
		$this->homeUse = $blocks;
	}
	public function getNameDefault($file, $mod) {
        $blocksObj = new Model('homes');
        $blocksObj->where('file', $file);
        $blocksObj->where('module_str', $mod);
        $data = $blocksObj->getOne();
        return $data[$this->lang . '_name'];
    }
	private function fixLangBlock($blocks,$lang='vi'){ 
		$this->count['store'][0] = count($blocks); 
		$key_lang = $lang.'_name';
		foreach ($blocks as $key => $value) {
			$blocks[$key]['name'] = $value[$key_lang]; 
			$blocks[$key]['thumb'] = $this->getThumb($value); 
			if(!isset($this->count['store'][$value['module']]))
			{
				$this->count['store'][$value['module']] = 1;
			}
			else
			{
				$this->count['store'][$value['module']] ++; 
			}
		}
		return $blocks;
	}
	
	public function ajax(){
		$action = $this->r->get_string('action',"POST");
		
		if($action ==''){
 			$action = 'getstore';
		}

 		$action = 'ajax_'.$action;
		$data = $this->$action();
		$json = json_encode($data);
		header('Content-Type: application/json');
		exit($json);
	}

	private function ajax_saveposition(){
		$position = $this->r->get_int('position','POST'); 
		$data = json_decode($_POST['arr'],true);
		foreach ($data as $key => $value) {
			$this->ajax_saveposition_save($value,$position);
		}
		$return = array('status'=>true);
		return $return;
	}
	
	private function ajax_savetitle(){
		$title=$this->r->get_string('title','POST');
		$id=$this->r->get_int('id','POST');
		$data=array(
			'title'=>$title
		);
		$this->ajax_savetitle_save($data,$id);
		$return = array('status'=>true,'message'=>lang('success'));
		return $return;
	}
	
	private function ajax_savetitle_save($data,$id)
	{
		$blockObj =  new Model($this->lang.'_home');
		$blockObj->where('idw',$this->idw);
		$blockObj->where('id',$id);
		return $blockObj->update($data);
	}
	
	private function ajax_saveposition_save($data){
		$blockObj =  new Model($this->lang.'_home');
		$blockObj->where('idw', $this->idw);
		//$blockObj->where('position', $position);
		$blockObj->where('idhome', $data['idhome']);

		if ($blockObj->num_rows() > 0) 
		{
			 

			$blockObj->where('idw', $this->idw);
			//$blockObj->where('position', $position);
			$blockObj->where('idhome', $data['idhome']);
			//unset($blockObj['title']);
			$blockObj->update($data);
			
		}
		else
		{ 
			 
			$data['idw']=$this->idw;
			//$data['position']=$position;
			$blockObj->insert($data);
		} 
		return true;
	}
	private function ajax_hiddenblock(){
		$id=$this->r->get_int('id','POST');
		$data = json_decode($_POST['arr'],true);		
		$blockObj =  new Model($this->lang.'_home');
		$blockObj->where('idw', $this->idw);
		if($id){
			$blockObj->where('idhome',$id);
			$blockObj->update($data);
			$return = array('status'=>true);
			return $return;
		}
		else
		{
			$return = array('status'=>false);
			return $return;
		}
			
	}
	
	private function ajax_delblock(){
		$id=$this->r->get_int('id','POST');
		//$idpos=$this->r->get_int('position','POST');
		
		$blockObj =  new Model($this->lang.'_home');
		$blockObj->where('idw', $this->idw);
		if($id){
			$blockObj->where('idhome',$id);
			//$blockObj->where('position',$idpos);
			$blockObj->delete();
			$return = array('status'=>true);
			return $return;
		}
		else
		{
			$return = array('status'=>false);
			return $return;
		}
			
	}

 
	private function ajax_getstore(){
		$data['blocks']       = $this->getBlocks();
		$data['count']        = $this->count;
		$data['datablockUse'] = $this->blockUse; 
		return $data;
	}
	
	
	private function getThumb($data){
		if(file_exists('http://dev3.webbnc.vn/modules/'.$data['module_str'].'/themes/blocks/thumb/'.$data['file'].'.png')){
			return 'http://dev3.webbnc.vn/modules/'.$data['module_str'].'/themes/blocks/thumb/'.$data['file'].'.png';
		}
		else
		{
			return 'http://dev2.webbnc.vn/themes/default/assets/no_image.gif';
		}
		
	}
}