<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /moduels/home/model/global_home.php 
 * @Author Quang Chau Tran (quangchauvn@gmail.com)
 * @Createdate 08/23/2014, 02:36 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class GlobalHome{
	private $idw,$r,$lang;
	public function __construct(){
			global $_B;	 
			$this->r = $_B['r'];
			$this->idw = $_B['web']['idw'];
			$this->lang = $_B['cf']['lang'];
	}
	//Chỉ là demo cho phân trang 
	public function getNewsList(){
		include_once(DIR_CLASS."pagination.php"); 
		$max = 3;
		$maxNum = 4;
		$select = array('id','id_lang','title');
		$this->catNewObj = new Model('vi_news');
		$this->catNewObj->where('idw',$this->idw);
		$total = $this->catNewObj->num_rows();
		echo "Tổng bản ghi : {$total}<br/>";
		$nav = new Pagination($max, $total, $maxNum, 'page');
		$result = $this->catNewObj->get(null,array(0,$max),$select);
		foreach ($result as $key => $value) {
			echo "<span>-- ".$value['title']."</span><br/>";
		}
		$link = 'news-demophantrang-';
		echo $nav->first(' <a href="'.$link.'{nr}"><<</a> | ', ' << | ');

		echo $nav->previous(' <a href="'.$link.'{nr}">Previous</a> | ', ' Previous | ');

		echo $nav->numbers(' <a href="'.$link.'{nr}">{nr}</a> | ', ' <b>{nr}</b> | ');

		echo $nav->next(' <a href="'.$link.'{nr}">Next</a> | ', ' Next | ');

		echo $nav->last(' <a href="'.$link.'{nr}">>></a> | ', ' >> | ');

		echo $nav->info('Result {start} to {end} of {total} - ');

		echo $nav->info('Page {page} of {pages} ');

		echo "<pre>";
		print_r($nav);
		echo "</pre>";

	}
}