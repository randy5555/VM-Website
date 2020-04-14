<?php
if($is_authenticated) {
	$action = strtolower($action);
	if($action == "settings") {
		include "php/pages/account/settings.php";
	} else if($action == "create") {
		include "php/pages/account/create.php";
	} else if($action == "manage") {
		include "php/pages/account/manage.php";
	}
} else {
	include "php/pages/login.php";
}