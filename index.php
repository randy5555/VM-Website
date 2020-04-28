<?php
if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
  $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
} else if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
  $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_X_FORWARDED_FOR"];
}


header('Referrer-Policy: same-origin');

ini_set("display_errors",0);

include "init.php";
global $dbh;
$ajax = false;
if(Request::issetRequest("ajax")) {
	$ajax = true;
}

$module = Request::issetRequest("module") ? $_REQUEST["module"] : "home";
$action = Request::issetRequest("action") ? $_REQUEST["action"] : "home";
$record = Request::issetRequest("record") ? $_REQUEST["record"] : 0;

include "php/auth.php";

if(isset($current_user) && $current_user->role=="admin") {
	$smarty->assign("is_admin",true);
} else {
	$smarty->assign("is_admin",false);
}

$smarty->assign("_ACTION",$action);
$smarty->assign("_MODULE",strtolower($module));
$smarty->assign("_RECORD",$record);


if(!$is_authenticated && Request::issetPost("account_register")) {
	$reg_username = Request::get("reg_username",false,"post");
	$reg_password1 = Request::get("reg_password1",false,"post");
	$reg_password2 = Request::get("reg_password2",false,"post");
	$reg_email1 = Request::get("reg_email1",false,"post");
	$reg_email2 = Request::get("reg_email2",false,"post");
	$csrf = $_POST["csrf"];

	$new_user = new Users();
	if(!common::validateCSRF($csrf)) {
		$register_error = $new_user->errorMessage = "Not valid.";
		$action = "home";
		$module = "register";

		$smarty->assign("reg_username",$reg_username);
		$smarty->assign("reg_email1",$reg_email1);
	} else {
		if($new_user->register($reg_username, $reg_password1, $reg_password2, $reg_email1, $reg_email2)!==false) {
			$_SESSION["new_login"] = true;
			$register_error = "";
			header("Location: {$site_URL}login");
		} else {
			$register_error = $new_user->errorMessage;
			$action = "home";
			$module = "register";

			$smarty->assign("reg_username",$reg_username);
			$smarty->assign("reg_email1",$reg_email1);
		}
	}
} else {
	$register_error = "";
}
//may remove "nav" as it was a concept from where I pulled these template sources from.
$use_nav = false;
if($module == "home" || $module == "login" || $module == "register") { $use_nav = false; }

include "php/header.php";

if($module == "ajax") {
	include "php/ajax.php";
} else {
	if(file_exists("php/pages/$module.php")) {
		include "php/pages/$module.php";
	} else {
		include "php/home.php";
	}
}

include "php/footer.php";