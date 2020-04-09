<?php
$noheaders=array();

$smartyHeader = new crmSmarty();
if(!in_array($module,$noheaders) && !isset($_REQUEST["ajax"]) && !isset($_REQUEST["login"])) {
	$smartyHeader->assign("is_authenticated",$is_authenticated);
	if($is_authenticated) {
		$smartyHeader->assign("username",$current_user->username);
		$smartyHeader->assign("userid",$current_user->id);
		$smartyHeader->assign("role",$current_user->role);
	} else {
		$smartyHeader->assign("username","guest");
		$smartyHeader->assign("role","guest");
		$smartyHeader->assign("userid",0);
	}
	$smartyHeader->assign("action",$action);
	$smartyHeader->assign("module",strtolower($module));
	$smartyHeader->assign("record",$record);
	$smartyHeader->assign("recordl",strtolower($record));
	$title = ucwords($module);
	
	$smartyHeader->assign("title",$title);
	$smartyHeader->assign("use_nav",$use_nav);
	$smartyHeader->display("header.tpl");
} else {
	$smartyHeader->display("header_ajax.tpl");
}
