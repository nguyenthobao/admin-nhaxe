<?php
/**
 * Code By Nguyen Xuan Truong
 *
 */
class Language {
	function __construct() {
		global $_B;
		$this->temp              = $_B['temp'];
		$this->request           = $_B['r'];
		$this->idw               = $_B['web']['idw'];
		$this->langDefault       = $_B['cf']['lang'];
		$this->dir_mod_frontend  = DIR_MODULES_FRONTEND;
		$this->dir_lang_frontend = DIR_LANG_FRONTEND;
	}

	public function index() {
		global $_DATA;

		$_DATA['content_module'] = $this->temp->load('Language');
	}
}