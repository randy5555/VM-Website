<?php
if(isset($_SESSION["auth_failed"])) {
	$smarty->assign("login_message",$_SESSION["auth_failed"]);
	unset($_SESSION["auth_failed"]);
}
if(isset($_SESSION["new_login"]) && $_SESSION["new_login"] == true) {
	unset($_SESSION["new_login"]);
	$smarty->assign("login_message","Account created, please log in to continue.");
}

if($current_user->authenticated == true) {
	$smarty->assign("login_message","You are already logged in.");
} 

$smarty->display("login.tpl");