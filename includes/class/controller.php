<?php
/**
 * @Project BNC v2 -> Controller
 * @File includes/class/controller.php
 * @author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 12/01/2014, 14:28 [PM]
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
} 
Class Controller {
	public $idw,$id,$lang,$page,$mod,$request,$cf,$id_field = 'id';
	private $data = array();
	public function __construct($sub=null) {
		global $_B,$web,$mod; 
		
		$this->mod     = $mod;  
		$this->page    = get_class($this);
		$this->sub     = ($sub != null)?$sub:$_B['r']->get_string('sub','GET');
		$this->idw     = $web['idw'];
		$this->request = $_B['r'];
		$this->lang    = $_B['lang']; 
		if ($this->lang !='vi') {
			$this->id_field = 'id_lang';
		}
		$p 				= $_B['r']->get_string('p', 'GET'); 
		$this->p 		= ($p) ? $p:1;
		if(empty($this->sub)){
			$this->sub = 'index';
		}
		$this->curUrl = $_B['curUrl']['URI_Not_dotExtension'];
		$this->parseId();
		$this->setDataDefault();
		if ($this->mod=='news'||$this->mod=='album') {
			$this->getConfigModule();	
		}
		
		
		
	}
	public function loadImage($img,$op='resize',$width=null,$height=null){
		global $_B;
		
		if ($op=='resize' || $op=='crop') {
			if (($width==null||$height==null)) {
				return '[Erro]:Bạn thiếu tham số widht|heith';
			}
			if ($img=='0'||empty($img)) {
				$thumb = HTTP_STATIC_RESIZE.'upload/web/1/1/no-img.gif'.'&amp;mode='.$op.'&amp;size='.$width.'x'.$height;
			}else{
				$thumb = HTTP_STATIC_RESIZE.$img.'&amp;mode='.$op.'&amp;size='.$width.'x'.$height;
			}	
			return $thumb;
		}else if($op=='none'){
			$thumb = HTTP_STATIC.$img;
			return $thumb;
		}
	}
	public function linkUrl($page,$sub=null,$id=null){
		global $_B,$web;

		if ($web['ssl'] == true) {
			$url = 'https://';
			//$web['HTTP_SERVER'] = 'https://';
		}else{
			$url = 'http://';
			//$web['HTTP_SERVER'] = 'http://';
		}
		if (isset($id)) {
			$id = '-'.$id;
		}
		if ($sub!=null) {
			$sub = '-'.strtolower($sub);
		}
		$newUrl = $url.$web['home'].'/'.strtolower($this->mod).'-'.strtolower($page).$sub.$id.strtolower($web['dotExtension']);
		return $newUrl;
	}
	
}
?>