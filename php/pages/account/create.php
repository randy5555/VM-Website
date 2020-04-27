<?php
$smarty->assign("account_email",$current_user->data["email"]);
$smarty->assign("account_instance_limit",$current_user->data["account_VMinstanceLimit"]);
$smarty->assign("account_username",$current_user->data["username"]);
$smarty->assign("csrf_token", common::getCSRF());

$sql = "select * from `server` where `server_enabled` = 1";
$sth = $dbh->run($sql);
$enabled_servers = array();
while($row = $dbh->fetch($sth)) {
	$enabled_servers[$row["server_id"]] = $row;
}
$smarty->assign("enabled_servers", $enabled_servers);

$smarty->display("account/create.tpl");
