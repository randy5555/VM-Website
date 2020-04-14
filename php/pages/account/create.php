<?php
$smarty->assign("account_email",$current_user->data["email"]);
$smarty->assign("account_instance_limit",$current_user->data["account_VMinstanceLimit"]);
$smarty->assign("account_username",$current_user->data["username"]);


$smarty->display("account/create.tpl");
