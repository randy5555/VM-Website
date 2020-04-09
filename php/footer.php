<?php
$nofooters=array();

$smartyFooter = new crmSmarty();
if(!in_array($module,$nofooters) && !isset($_REQUEST["ajax"]) && !isset($_REQUEST["login"])) {
	if(isset($footer_assign) && !empty($footer_assign)) {
		foreach($footer_assign as $k=>$v) {
			$smartyFooter->assign($k,$v);
		}
	}
	if(!isset($_SESSION['tz'])) { $smartyFooter->assign("do_tz",true); }
	else { $smartyFooter->assign("do_tz",false); }
	if(isset($footer_inc)) { $smartyFooter->assign("footer_inc",$footer_inc); }
	
	$smartyFooter->assign("is_authenticated",$is_authenticated);
	$smartyFooter->display("footer.tpl");
} else {
	$smartyFooter->display("footer_ajax.tpl");
}