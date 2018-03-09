<?php
$idw    = $_B['web']['idw']; //id web
$dfLang = $_B['cf']['lang']; //default lang
$reload = rand();

// lang layout
$_S['title_header']      = lang('title_header');
$_S['title_module']      = lang('title_module');
$_S['title_module_m']    = lang('title_module_m');
$_S['title_manager_mod'] = lang('title_manager_mod');
$_S['breadcrumb_mod']    = lang('breadcrumb_mod');
$pages                   = array('watermark', 'iframe', 'ajaxBlockcustom', 'blockcustomadd', 'blockcustom', 'blockright', 'block', 'homes', 'ajaxtemplate', 'ajax', 'ajaxslide', 'ajaximage', 'slide', 'slidelist', 'image', 'imagelist','social','support','copyBlocks','copyHomes');
$page                    = $_B['r']->get_string('page', 'GET');
$nxt_more                = array('viewdata', 'customForm', 'addLayout', 'Language', 'ConvertLang','social','support');
$_B['mod_in_home']       = $mod_in_home;
if (!in_array($_GET['page'], $nxt_more)) {
	include_once DIR_MODULES . $mod . "/global/readFont.php";
	if (!in_array($page, $pages)) {
		$page = 'template';
	}
	include_once DIR_MODULES . "template/global/global.php"; //Load model global dùng chung
	$global_block_nxt = new global_block_nxt;
	include_once DIR_MODULES . $mod . "/model/blockcustom.php";
	$blockcustom = new Blockcustom;
	include_once DIR_MODULES . $mod . "/model/global_slide.php"; //Load model dùng chung
	include_once DIR_MODULES . $mod . "/model/global_template.php"; //Load model dùng chung
	if (file_exists(DIR_MODULES . $mod . "/model/" . $page . ".php")) {
		include_once DIR_MODULES . $mod . "/model/" . $page . ".php";
	}
	include_once DIR_MODULES . $mod . "/controller/" . $page . ".php";
} else {
	include_once DIR_MODULES . $mod . "/model/addLayout.php";
	include_once DIR_MODULES . $mod . "/model/formcustom.php";
	include_once DIR_MODULES . $mod . "/controller/" . $page . ".php";
	$controller = new $page;
	if (isset($_GET['sub'])) {
		$sub = $_GET['sub'];
		$controller->$sub();
	} else {
		$controller->index();
	}
	$content_module = $_DATA['content_module'];
}
