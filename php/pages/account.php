<?php
if($is_authenticated) {
	$action = strtolower($action);
	if($action == "settings") {
		include "php/pages/account/settings.php";
	}
} else {
	include "php/pages/login.php";
}