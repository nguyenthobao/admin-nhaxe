<?php
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
class Contactqa{
	public $idw,$r,$lang,$result_id,$questions_answers; 
	public function __construct(){
		global $_B;	 
		$this->r         = $_B['r'];
		$this->idw       = $_B['web']['idw'];
		$this->lang      = $_B['cf']['lang'];
		$this->result_id = "";
	}

	public function getQA(){
		$id   = $this->r->get_int('id','GET');
		$lang = $this->r->get_string('lang','GET');
		$questions_answers = new model($lang.'_contact_answer');
		$select = "*";
		$questions_answers ->where('idw',$this->idw);
		$questions_answers ->where('id_mail',$id);
		$result = $questions_answers ->get(null,null,$select);
		return $result;
	}
	
}