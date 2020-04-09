<?php
if(isset($register_error) && $register_error != "") {
	$smarty->assign("register_message",$register_error);
}

$smarty->display("register.tpl");