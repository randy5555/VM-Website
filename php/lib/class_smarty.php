<?php
require("php/smarty/Smarty.class.php");
class crmSmarty extends Smarty {
	function __construct() {
		global $root_directory,$dir_theme,$title,$site_URL,$path_theme;
		// Class Constructor.
		// These automatically get set with each new instance.
		
		parent::__construct();
		
		$this->setTemplateDir($root_directory.$dir_theme."/");
		$this->setCompileDir($root_directory."php/smarty/templates_c/");
		$this->setConfigDir($root_directory."php/smarty/configs/");
		$this->setCacheDir($root_directory."php/smarty/cache/");
		
		//$this->caching = Smarty::CACHING_LIFETIME_CURRENT;
		$this->assign('app_name', $title);
		$this->assign('theme_dir',$path_theme);
		$this->assign('site_url',$site_URL);
	}
}